function refreshCaptcha() {
    $.get('/auth/refresh_captcha', function(data) {
        $('#captcha_container').html(data);
    });
}

function submit() {
    let nik = $("#nik").val();
    let password = $("#password").val();
    let captcha = $("#captcha").val();

    $.ajax({
        type: "POST",
        url: "/auth/b_login",
        data: {
            nik: nik,
            password: password,
            captcha: captcha
        },
        success: function(response) {
            let res = JSON.parse(response);
            if(res.status === 'success') {
                Swal.fire({
                    title: 'Berhasil',
                    text: res.message,
                    icon: 'success',
                    allowOutsideClick: false,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let role = res.role;

                        if(role == 'blocked'){
                            return window.location.href = "/blocked";
                        } 

                        window.location.href = "/"+role+"/dashboard";
                    }
                });
            } else {
                if (res.errors) {
                    let errorMsg = '';
                    for (let field in res.errors) {
                        errorMsg += res.errors[field] + '<br>';
                    }
                    Swal.fire('Gagal' ,errorMsg, 'error');
                } else {
                    Swal.fire('Berhasil', res.message, 'success');
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            Swal.fire('Error', 'Terjadi kesalahan saat login.', 'error');
        }
    });
}