function submit() {
    let name = $("#name").val();
    let email = $("#email").val();
    let nik = $("#nik").val();
    let password = $("#password").val();

    $.ajax({
        type: "POST",
        url: "/auth/b_register",
        data: {
            name: name,
            email: email,
            nik: nik,
            password: password 
        },
        success: function(response) {
            let res = JSON.parse(response);
            if(res.status === 'success') {
                alert(res.message);
                window.location.href = "/auth/login";
            } else {
                if (res.errors) {
                    let errorMsg = '';
                    for (let field in res.errors) {
                        errorMsg += res.errors[field] + '<br>';
                    }
                    Swal.fire('Gagal',errorMsg,'error');
                } else {
                    alert(res.message);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("Terjadi kesalahan saat registrasi.");
        }
    });
}