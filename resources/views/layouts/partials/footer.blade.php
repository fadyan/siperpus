<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">Anything you want</div>
    <strong>Copyright &copy; 2026 <a href="#">Perpustakaan DDI Cambalagi</a>.</strong>
</footer>

<script src="{{ asset('assets/js/adminlte.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/ai.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
});
</script>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Konfirmasi Logout
    const btnLogout = document.getElementById('btnLogout');

    if(btnLogout){
        btnLogout.addEventListener('click', function(e){

            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result)=>{
                if(result.isConfirmed){
                    document.getElementById('logout-form').submit();
                }
            });

        });
    }

    // Konfirmasi Hapus
    document.querySelectorAll('.delete-form').forEach(function(form){

        form.addEventListener('submit', function(e){

            e.preventDefault();

            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result)=>{

                if(result.isConfirmed){
                    form.submit();
                }

            });

        });

    });

});
</script>
<script>
    // Inisialisasi OverlayScrollbars agar tampilan sidebar halus
    // const sidebarWrapper = document.querySelector('.sidebar-wrapper');
    // if (sidebarWrapper) {
    //     OverlayScrollbars(sidebarWrapper, {
    //         scrollbars: { theme: 'os-theme-light', autoHide: 'never' },
    //     });
    // }
</script>