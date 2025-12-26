<!DOCTYPE html>
<html>
<head>
    <title>Ticket Scheduled!</title>
</head>
<body>
    <p>Halo <?php echo htmlspecialchars($name); ?>,</p>
    <p>Ticket anda baru saja dijadwalkan akan dieksekusi pada <?php echo date('Y-m-d H:i', $execution_date); ?> oleh <?php echo htmlspecialchars($developer_name); ?>.</p>
    <p>Terimakasih...</p>

    <p>Salam,<br><em>Anticket</em></p>
</body>
</html>