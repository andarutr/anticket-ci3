<!DOCTYPE html>
<html>
<head>
    <title>Berhasil Registrasi!</title>
</head>
<body>
    <h2>Selamat Datang, <?= htmlspecialchars($name); ?>!</h2>
    <p>Terima kasih telah mendaftar di aplikasi kami. Akun Anda telah berhasil dibuat.</p>
    <p>Email Anda: <strong><?= htmlspecialchars($email); ?></strong></p>
    <p>Silahkan ganti password default anda agar lebih aman.Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
    <p>Salam,<br><em>Anticket</em></p>
</body>
</html>