<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Buku;
use App\Models\Kueri;
use Illuminate\Support\Facades\DB;

class AIChatController extends Controller
{
    public function chat(Request $request)
    {
        $message = trim($request->message);

        try {
            $intent = $this->extractIntent($message);
            $books = $this->searchBook($intent);

            $answer = $this->generateResponse($message, $books);

            return response()->json([
                'answer' => $answer
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'answer' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fungsi pusat untuk mengirim request ke Groq dengan sistem multi-key fallback
     */
    private function sendToGroqWithFallback(array $payload)
    {
        $apiKeys = config('services.groq.keys');
        $apiKeys = array_filter($apiKeys);

        if (empty($apiKeys)) {
            throw new \Exception('API Key Groq belum dikonfigurasi di sistem.');
        }

        $response = null;
        $success = false;
        $lastErrorMessage = 'Terjadi gangguan pada koneksi AI.';

        foreach ($apiKeys as $index => $apiKey) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', $payload);

                if ($response->successful()) {
                    $success = true;
                    break;
                }

                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? '';
                $lastErrorMessage = $errorMessage ?: $lastErrorMessage;

                if ($response->status() == 429 || stripos($errorMessage, 'rate_limit') !== false || stripos($errorMessage, 'quota') !== false) {
                    Log::warning("API Key ke-" . ($index + 1) . " terkena rate limit. Berpindah ke key selanjutnya...");
                    continue;
                }

                throw new \Exception($errorMessage ?: 'Gagal memproses permintaan AI.');

            } catch (\Exception $e) {
                $lastErrorMessage = $e->getMessage();
                Log::warning("Gagal menggunakan API Key ke-" . ($index + 1) . ": " . $e->getMessage());
            }
        }

        if (!$success) {
            throw new \Exception("Maaf, batas penggunaan seluruh API AI sedang habis (rate limit) atau terjadi gangguan. Silakan coba beberapa saat lagi.");
        }

        return $response;
    }

    private function generateResponse($question, $books)
    {
        if ($books->isEmpty()) {
            $metadata = "DATA TIDAK DITEMUKAN";
        } else {
            $metadata = "";
            foreach ($books as $book) {
                $namaRak = $book->rak_buku?->nama_rak ?? '-';
                $namaKelas = $book->kelas?->nama ?? '-';
                $namaPenerbit = $book->penerbit?->nama_penerbit ?? '-';
                $deskripsiBuku = $book->deskripsi ?? 'Tidak ada ringkasan deskripsi khusus untuk buku ini.';
                
                $metadata .= "- Judul: " . ucwords(strtolower($book->judul)) . " | Kelas: {$namaKelas} | Pengarang: {$book->pengarang} | Penerbit: {$namaPenerbit} | Rak: {$namaRak} | Deskripsi: {$deskripsiBuku}\n";
            }
        }

        $payload = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => '
Kamu adalah Pustika, AI Asisten Perpustakaan DDI Cambalagi yang cerdas, ramah, interaktif, dan to the point.

ATURAN UTAMA IDENTITAS & PEMBUAT:
1. JANGAN PERNAH menyebutkan nama pembuat atau pencipta (Fadli Idrus / mahasiswa UNITAMA) jika pengguna hanya bertanya: "siapa kamu", "kamu siapa", atau perkenalan umum sejenis. Untuk pertanyaan "siapa kamu", cukup jawab bahwa kamu adalah Pustika, AI Asisten Perpustakaan DDI Cambalagi yang bertugas membantu mencari buku dan informasi perpustakaan.
2. Identitas pembuat (Fadli Idrus, mahasiswa UNITAMA) **HANYA BOLEH** diceritakan jika pengguna secara spesifik menanyakan tentang pembuat, pencipta, atau pengembang (contoh: "siapa yang menciptakan kamu?", "siapa yang buat kamu?").

Aturan Lainnya:
1. JANGAN pernah menyebutkan informasi **Rak** (seperti Rak: Campuran) saat pengguna hanya mencari, meminta daftar, atau bertanya tentang buku, KECUALI jika pengguna secara spesifik menanyakan lokasi, letak, posisi, atau nomor rak buku tersebut.
2. Jika hasil pencarian menemukan **lebih dari satu buku**, tampilkan daftar buku tersebut secara jelas dengan menyertakan **Judul, Pengarang, dan Kelas** masing-masing buku. Setelah itu tanyakan kepada pengguna dengan ramah: "Kamu mau dijelaskan mengenai buku yang mana?"
3. Jika pengguna meminta penjelasan spesifik untuk **satu buku tertentu**, berikan ringkasan atau penjelasan singkat mengenai isi/materi buku tersebut berdasarkan data "Deskripsi" yang tersedia tanpa mengulang-ulang metadata secara kaku.
4. Jika ditemukan data buku yang judul, pengarang, dan kelasnya sama persis lebih dari satu di dalam metadata, gabungkan penjelasannya secara umum tanpa perlu menanyakan tentang "edisi" atau mengarang hal yang tidak ada di data.
5. Jangan mengarang data di luar data buku yang diberikan.
6. Jika "DATA TIDAK DITEMUKAN", jawab dengan ramah: "Maaf, buku yang kamu cari tidak ditemukan di perpustakaan kami."
                    '
                ],
                [
                    'role' => 'user',
                    'content' => "Pertanyaan: {$question}\n\nData Buku yang Tersedia:\n{$metadata}"
                ]
            ]
        ];

        $response = $this->sendToGroqWithFallback($payload);

        return $response->json()['choices'][0]['message']['content'];
    }

    private function searchBook(array $intent)
    {
        $query = Buku::with([
            'kelas',
            'penerbit',
            'rak_buku'
        ]);

        if (!empty($intent['judul'])) {
            $keywords = preg_split('/\s+/', trim($intent['judul']));

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($sub) use ($word) {
                        $sub->where('judul', 'like', "%{$word}%")
                            ->orWhere('pengarang', 'like', "%{$word}%")
                            ->orWhere('deskripsi', 'like', "%{$word}%");
                    });
                }
            });
        }

        if (!empty($intent['pengarang'])) {
            $query->where('pengarang', 'like', '%' . $intent['pengarang'] . '%');
        }

        if (!empty($intent['penerbit'])) {
            $query->whereHas('penerbit', function ($q) use ($intent) {
                $q->where('nama_penerbit', 'like', '%' . $intent['penerbit'] . '%');
            });
        }

        if (!empty($intent['tahun'])) {
            $query->where('tahun', $intent['tahun']);
        }

        if (!empty($intent['kelas'])) {
            $kelasInput = $intent['kelas'];
            $query->whereHas('kelas', function ($q) use ($kelasInput) {
                $q->where('nama', 'like', '%' . $kelasInput . '%')
                  ->orWhere('deskripsi', 'like', '%' . $kelasInput . '%');
            });
        }

        if (!empty($intent['rak'])) {
            $query->whereHas('rak_buku', function ($q) use ($intent) {
                $q->where('nama_rak', 'like', '%' . $intent['rak'] . '%');
            });
        }

        // Dibatasi maksimal 5 buku saja untuk menghemat token dan menjaga kerapian chat
        return $query->take(5)->get();
    }

    private function extractIntent($message)
    {
        $prompt = <<<'PROMPT'
Kamu adalah AI Parser untuk Sistem Informasi Perpustakaan.
Tugasmu adalah menganalisis pesan pengguna dan mengubahnya menjadi JSON terstruktur untuk pencarian database buku.

Aturan:
1. Perbaiki kesalahan ejaan (typo) sesuai kaidah Bahasa Indonesia.
2. Ekstrak informasi sedetail mungkin dari pesan pengguna ke dalam field berikut:
   - "judul": untuk nama buku atau topik buku yang dicari (contoh: "akidah akhlak", "pkn").
   - "pengarang": nama penulis/pengarang buku jika disebutkan (contoh: "usman").
   - "penerbit": nama penerbit jika disebutkan.
   - "kelas": jenjang kelas yang diminta (contoh: "10", "11", "12", "X", "XI", "XII").
   - "tahun": tahun terbit jika ada.
   - "rak": lokasi rak jika ditanyakan.
3. Jika suatu informasi tidak disebutkan oleh pengguna, biarkan kosong ("").

Format Output (JSON Valid Tanpa Markdown):
{
  "intent": "cari_buku",
  "judul": "",
  "pengarang": "",
  "penerbit": "",
  "kelas": "",
  "tahun": "",
  "rak": ""
}
PROMPT;

        $payload = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $message]
            ],
            'response_format' => ['type' => 'json_object']
        ];

        $response = $this->sendToGroqWithFallback($payload);

        $content = data_get($response->json(), 'choices.0.message.content');
        Kueri::create(["text" => $content]);
        
        return json_decode($content, true) ?? [];
    }
}