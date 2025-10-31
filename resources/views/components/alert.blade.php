@if (session('success'))
<script>
    // Ambil pesan success dari session
    let message = "{{ session('success') }}";

    // Tampilkan SweetAlert
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: message,
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if (session('error'))
<script>
    // Contoh untuk pesan error
    let message = "{{ session('error') }}";

    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: message,
    });
</script>
@endif
