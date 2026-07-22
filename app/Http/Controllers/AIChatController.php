<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Buku;
use App\Models\Kueri;
use Illuminate\Support\Facades\DB;


class AIChatController extends Controller
{
    
    public function chat(Request $request)
    {
       $message = strtolower(trim($request->message));

        // ==========================
        // RESPON PERCAKAPAN UMUM
        // ==========================

        $conversation = [
            [
                'keywords' => ['assalamualaikum'],
                'answer' => 'Waalaikumsalam warahmatullahi wabarakatuh. Selamat datang di Perpustakaan DDI Cambalagi. Ada buku yang ingin saya bantu carikan?'
            ],
            [
                'keywords' => ['selamat pagi'],
                'answer' => 'Selamat pagi!  Ada buku yang ingin saya bantu carikan hari ini?'
            ],
            [
                'keywords' => ['selamat siang'],
                'answer' => 'Selamat siang!  Ada yang bisa saya bantu mencari buku?'
            ],
            [
                'keywords' => ['selamat sore'],
                'answer' => 'Selamat sore!  Ada buku yang sedang Anda cari?'
            ],
            [
                'keywords' => ['selamat malam'],
                'answer' => 'Selamat malam!  Ada buku yang ingin saya bantu carikan?'
            ],
            [
                'keywords' => ['halo', 'hai', 'hello', 'hallo'],
                'answer' => 'Halo!  Selamat datang di Perpustakaan DDI Cambalagi. Ada buku yang ingin saya bantu carikan?'
            ],
            [
                'keywords' => ['siapa kamu', 'kamu siapa', 'anda siapa', 'siapa anda', 'perkenalkan dirimu'],
                'answer' => 'Saya adalah AI Asisten Perpustakaan DDI Cambalagi. Saya siap membantu Anda mencari informasi buku berdasarkan data yang tersedia di sistem perpustakaan.'
            ],
            [
                'keywords' => ['apa fungsimu', 'kamu bisa apa', 'apa tugasmu', 'apa yang bisa kamu lakukan'],
                'answer' => ' Saya bisa membantu Anda mencari informasi buku berdasarkan data yang tersedia di sistem perpustakaan.'
            ],
            [
                'keywords' => ['terima kasih', 'makasih', 'thanks'],
                'answer' => 'Sama-sama. Senang bisa membantu. 😊'
            ],
            [
                'keywords' => ['apa kabar', 'gimana kabarmu'],
                'answer' => 'Alhamdulillah Baik, terima kasih. Saya disini selalu siap membantu Anda mencari informasi buku di perpustakaan.'
            ]
        ];

        foreach ($conversation as $item) {

            foreach ($item['keywords'] as $keyword) {

                // Hanya balas jika isi pesan hampir sama dengan keyword
                if ($message == $keyword) {

                    return response()->json([
                        'answer' => $item['answer']
                    ]);
                }
            }
        }

        // ==========================
        // LANJUTKAN KE AI
        // ==========================

        $intent = $this->extractIntent($request->message);

        $books = $this->searchBook($intent);

        $answer = $this->generateResponse(
            $request->message,
            $books
        );

        return response()->json([
            'answer' => $answer
        ]);

    }

    private function generateResponse($question, $books)
    {
        if ($books->isEmpty()) {
            $metadata = "DATA TIDAK DITEMUKAN";
        } else {

            $metadata = "";

            foreach ($books as $book) {

                $metadata .= "
                Judul      : {strtolower($book->judul)}     
                Pengarang  : {$book->pengarang}
                Penerbit   : " . ($book->penerbit?->nama ?? '-') . "
                Kategori   : " . ($book->kelas?->nama ?? '-') . "
                Rak        : " . ($book->rak_buku?->nama ?? '-') . "
                Tahun      : {$book->tahun}
                Jumlah     : {$book->jumlah}
                Deskripsi     : {strtolower($book->deskripsi)}

                ";
            }
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.groq.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [

            'model' => 'llama-3.3-70b-versatile',

            'messages' => [

                [
                    'role' => 'system',
                    'content' => '
            Kamu adalah AI Asisten Perpustakaan.

            Jawablah HANYA berdasarkan data yang diberikan.

            Jika DATA TIDAK DITEMUKAN maka jawab:

            "Maaf, buku yang Anda cari tidak ditemukan."

            Jangan mengarang data.

            Berikan jawaban yang singkat dan ramah.
            '
                        ],

                        [
                            'role' => 'user',
                            'content' => "

            Pertanyaan:

            {$question}

            Data Buku:

            {$metadata}

            "
                        ]

                    ]

                ]);

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

                                $sub->where("judul", 'like', "%{$word}%");
                                    // ->orWhere(DB::raw("LOWER('deskripsi')"), 'like', "%{strtolower($word)}%");

                            });

                        }

                    });

                }

                if (!empty($intent['pengarang'])) {
                    $query->where('pengarang', 'like', '%' . $intent['pengarang'] . '%');
                }
                if (!empty($intent['penerbit'])) {
                    $query->whereHas('penerbit', function ($q) use ($intent) {
                        $q->where('nama', 'like', '%' . $intent['penerbit'] . '%');
                    });
                }
                if (!empty($intent['tahun'])) {
                    $query->where('tahun', $intent['tahun']);
                }
                if (!empty($intent['kelas'])) {
                    $query->whereHas('kelas', function ($q) use ($intent) {
                        $q->where('nama', 'like', '%' . $intent['kelas'] . '%');
                    });
                }
                if (!empty($intent['rak'])) {
                    $query->whereHas('rak_buku', function ($q) use ($intent) {
                        $q->where('nama', 'like', '%' . $intent['rak'] . '%');
                    });
                }
           
            
        


        return $query->get();
    }



    private  function extractIntent($message)
    {
            // $message = strtolower($message);
            $prompt = <<<'PROMPT'
            Kamu adalah AI Parser untuk Sistem Informasi Perpustakaan.

Tugasmu adalah mengubah pertanyaan pengguna menjadi JSON terstruktur yang akan digunakan untuk pencarian data buku di database.

Aturan:

1. Perbaiki terlebih dahulu kesalahan ejaan (typo) sesuai kaidah Bahasa Indonesia.
2. Jangan mengubah maksud atau konteks pertanyaan pengguna.
3. Gunakan hasil perbaikan ejaan sebagai dasar untuk melakukan parsing.
4. Identifikasi informasi yang terdapat pada pertanyaan pengguna.
5. Jika suatu informasi tidak ada, isi dengan string kosong ("").
6. Tentukan nilai "intent" berdasarkan maksud pertanyaan pengguna.

Kemungkinan nilai intent:
- cari_buku
- cari_pengarang
- cari_penerbit
- cari_kelas
- cari_rak
- cari_tahun
- rekomendasi_buku
- jumlah_buku
- lainnya

Output HARUS berupa JSON VALID.

Format:

{
  "intent": "",
  "judul": "",
  "pengarang": "",
  "penerbit": "",
  "kelas": "",
  "tahun": "",
  "rak": ""
}

Aturan Output:
- Jangan menambahkan penjelasan.
- Jangan menggunakan markdown.
- Jangan menggunakan tanda ```json.
- Hanya tampilkan JSON yang valid.
- Semua key wajib ada.
- Jika nilainya tidak diketahui, isi dengan string kosong ("").

Contoh:

Input:
aya cari buku matmatika klas 11

Output:
{
  "intent": "cari_buku",
  "judul": "Matematika",
  "pengarang": "",
  "penerbit": "",
  "kelas": "11",
  "tahun": "",
  "rak": ""
}

Input:
buku biolog karya irnaningtyas

Output:
{
  "intent": "cari_buku",
  "judul": "Biologi",
  "pengarang": "Irnaningtyas",
  "penerbit": "",
  "kelas": "",
  "tahun": "",
  "rak": ""
}

Input:
ada buku terbitan erlangga

Output:
{
  "intent": "cari_penerbit",
  "judul": "",
  "pengarang": "",
  "penerbit": "Erlangga",
  "kelas": "",
  "tahun": "",
  "rak": ""
}
PROMPT;
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.groq.key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [

                'model' => 'llama-3.3-70b-versatile',

                'messages' => [

                    [
                        'role' => 'system',
                        'content' => $prompt
                    ],

                    [
                        'role' => 'user',
                        'content' => $message
                    ]

                ],

                // Memaksa model menghasilkan JSON
                'response_format' => [
                    'type' => 'json_object'
                ]

            ]);
            


            if ($response->failed()) {
                    Kueri::create(["text" => "Groq Error"]);
                throw new \Exception(
                    $response->json()['error']['message'] ?? 'Groq Error'
                );
            }
            if (!isset($response['choices'][0]['message']['content'])) {
                Kueri::create(["text" => json_encode($response)]);
                throw new \Exception('Response Groq tidak memiliki field choices. Response: ' . json_encode($response));
            }

            $content = data_get(
                $response->json(),
                'choices.0.message.content'
            );
            Kueri::create(["text" => $content]);
            
            return json_decode($content, true);
        }
}
