$("#table").DataTable({
    ordering: false,
    ajax: {
        type: "GET",
        url: "/root/manageuser/getdata"
    },
    columns: [
        { data: "nik" },
        { data: "name" },
        { data: "email" },
        { data: "role" },
        { 
            data: null,
            render: function(data, type, row){
                return `
                    <span class="badge bg-success" onclick="resetAccount(${row.id})">RESET PWD</span>
                    <span class="badge bg-danger" onclick="blockAccount(${row.id})">BLOKIR</span>
                `;
            }
        },
    ]
});

function resetAccount(userId) {
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Password akan direset menjadi anticket123",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: `/root/manageuser/resetAccount/${userId}`,
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        ).then(() => {
                            $('#table').DataTable().ajax.reload(null, false); 
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            "Pesan: " + response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                    Swal.fire(
                        'Oops...',
                        'Terjadi kesalahan saat mereset password.',
                        'error'
                    );
                }
            });
        }
    });
}

function blockAccount(userId) {
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Akun ini akan diblokir dan tidak dapat digunakan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Blokir!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: `/root/manageuser/blockAccount/${userId}`,
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        ).then(() => {
                            $('#table').DataTable().ajax.reload(null, false); 
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            "Pesan: " + response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                    Swal.fire(
                        'Oops...',
                        'Terjadi kesalahan saat memblokir akun.',
                        'error'
                    );
                }
            });
        }
    });
}