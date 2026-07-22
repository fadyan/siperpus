// =======================
// Chatbot AI
// =======================
// fetch('/chat', {
//     method: 'POST',
//     headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//     },
//     body: JSON.stringify({
//         message: 'saya ingin mencari buku Akidah Akhlak yang pengarangnya usman'
//     })
// })
// .then(async (res) => {
//     console.log(res);

//     const data = await res.json();

//     if (!res.ok) {
//         console.error("Error Response:", data);
//         throw new Error(data.message || "Terjadi kesalahan");
//     }

//     console.log(data);
// })
// .catch((err) => {
//     console.error(err);
// });


// =======================
// Dashboard
// =======================
document.addEventListener('DOMContentLoaded', function () {

    const hasil = document.getElementById('hasilPencarian');
    const searchBook = document.getElementById('searchBook');
    const limitBook = document.getElementById('limitBook');

    if (!hasil || !searchBook || !limitBook) return;

    const defaultHTML = hasil.innerHTML;

    let timeout = null;

    // Event pencarian
    searchBook.addEventListener('input', function () {

        clearTimeout(timeout);

        timeout = setTimeout(loadBooks, 200);

    });

    // Event dropdown
    limitBook.addEventListener('change', loadBooks);

    // Fungsi mengambil data
    function loadBooks(){

        const keyword = searchBook.value.trim();
        const limit = limitBook.value;

        // Jika kosong dan limit 8 tampilkan dashboard awal
        if(keyword === '' && limit == 8){
            hasil.innerHTML = defaultHTML;
            return;
        }

        fetch(
            window.dashboardConfig.searchUrl +
            '?keyword=' + encodeURIComponent(keyword) +
            '&limit=' + limit
        )
        .then(res => res.json())
        .then(renderBooks);

    }

    // Fungsi menampilkan buku
    function renderBooks(data){

        let html = '';

        if(data.length === 0){

            hasil.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-warning">
                        Buku tidak ditemukan.
                    </div>
                </div>
            `;

            return;
        }

        data.forEach(function(buku){

            let cover = buku.cover
            ?
            `
            <div style="height:280px;overflow:hidden;">
                <img src="${window.dashboardConfig.uploadUrl}/${buku.cover}"
                    class="w-100 h-100"
                    style="object-fit:contain;background:#f8f9fa;"
                    alt="${buku.judul}">
            </div>
            `
            :
            `
            <div style="height:280px;overflow:hidden;">
                <img src="${window.dashboardConfig.defaultCover}"
                    class="w-100 h-100"
                    style="object-fit:contain;background:#f8f9fa;"
                    alt="Default Cover">
            </div>
            `;

            html += `
            <div class="col-md-3 mb-4">

                <div class="card h-100 shadow-sm">

                    ${cover}

                    <div class="card-body">

                        <h6 class="fw-bold text-center">
                            ${buku.judul}
                        </h6>

                        <hr>

                        <p class="mb-1">
                            <strong>Buku Untuk :</strong>
                            ${buku.kelas ? buku.kelas.nama : '-'}
                        </p>

                        <p class="mb-1">
                            <strong>Posisi Rak Buku :</strong>
                            ${buku.rak_buku ? buku.rak_buku.nama_rak : '-'}
                        </p>

                        <p class="mb-1">
                            <strong>Pengarang :</strong>
                            ${buku.pengarang}
                        </p>

                        <p class="mb-1">
                            <strong>Penerbit :</strong>
                            ${buku.penerbit ? buku.penerbit.nama_penerbit : '-'}
                        </p>

                        <p class="mb-2">
                            <strong>Tahun :</strong>
                            ${buku.tahun}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <span class="badge bg-primary">
                                Stok : ${buku.jumlah}
                            </span>

                            <a href="${window.dashboardConfig.detailUrl}/${buku.id}"
                                class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Detail
                            </a>

                        </div>

                    </div>

                </div>

            </div>
            `;
        });

        hasil.innerHTML = html;

    }

});