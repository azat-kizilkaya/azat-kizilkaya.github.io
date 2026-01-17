<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>SİPARİŞ ALINDI | FORSY STUDIO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&family=Syncopate:wght@400;700&display=swap');
        body { background: #000; color: #fff; font-family: 'Space Grotesk', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; text-align: center; }
        .success-icon { font-size: 5rem; color: #E84D35; margin-bottom: 20px; }
        h1 { font-family: 'Syncopate'; margin-bottom: 20px; }
        .order-id { font-size: 1.2rem; margin-bottom: 40px; color: #888; }
        .btn-home { background: #fff; color: #000; padding: 15px 40px; text-decoration: none; font-weight: bold; font-family: 'Syncopate'; transition: 0.3s; }
        .btn-home:hover { background: #E84D35; color: #fff; }
    </style>
</head>
<body>
    <div class="animate__animated animate__fadeInUp">
        <div class="success-icon animate__animated animate__bounceIn delay-1s">
            ✔
        </div>
        <h1>SİPARİŞ OKAY!</h1>
        <div class="order-id">SİPARİŞ NO: #<?= $_GET['siparis_id'] ?? '000' ?></div>
        <p class="mb-5 text-white-50">Siparişiniz başarıyla oluşturuldu.<br>Hazırlanmaya başladığında size haber vereceğiz.</p>
        
        <a href="index.php" class="btn-home">ANA SAYFAYA DÖN</a>
    </div>
</body>
</html>
