$('#profileForm').on('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const userId = $('#user_id').val();

    if (!userId) {
        Swal.fire('Error!', 'Data pengguna tidak ditemukan.', 'error');
        return;
    }

    $.ajax({
        url: '/profile/update',
        type: 'POST',
        data: formData,
        processData: false, 
        contentType: false, 
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire('Berhasil!', response.message, 'success');
                if ($('#password').val()) {
                    location.reload();
                }
            } else {
                Swal.fire('Gagal!', response.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
            Swal.fire('Oops...', 'Terjadi kesalahan pada server.', 'error');
        }
    });
});