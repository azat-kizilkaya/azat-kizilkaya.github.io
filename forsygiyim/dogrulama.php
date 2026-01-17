<?php
// 1. Hataları görmek için bu satırları en üste ekle (Çalışınca silebilirsin)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_config.php'; // Veritabanı bağlantısının ($conn) doğru olduğundan emin ol

// Eğer kayıt sayfasından gelinmemişse geri gönder
if (!isset($_SESSION['onay_eposta'])) {
    header("Location: kayit_ol.php");
    exit;
}

$mesaj = "";
$mesaj_turu = ""; // danger veya success

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kod = trim($_POST['kod']);
    $email = $_SESSION['onay_eposta'];

    // Kodu kontrol et
    $sorgu = $conn->prepare("SELECT kullanici_id FROM tbl_kullanicilar WHERE eposta = ? AND dogrulama_kodu = ?");
    $sorgu->bind_param("ss", $email, $kod);
    $sorgu->execute();
    $sonuc = $sorgu->get_result();

    if ($sonuc->num_rows > 0) {
        // Kod doğru: Durumu 1 (aktif) yap ve kodu temizle
        $onayla = $conn->prepare("UPDATE tbl_kullanicilar SET durum = 1, dogrulama_kodu = NULL WHERE eposta = ?");
        $onayla->bind_param("s", $email);
        
        if ($onayla->execute()) {
            $mesaj = "HESABINIZ BAŞARIYLA AKTİF EDİLDİ! GİRİŞE YÖNLENDİRİLİYORSUNUZ...";
            $mesaj_turu = "success";
            unset($_SESSION['onay_eposta']); // Başarılıysa session'ı temizle
            echo "<script>setTimeout(() => { window.location.href='login.php'; }, 2500);</script>";
        } else {
            $mesaj = "BİR HATA OLUŞTU, LÜTFEN TEKRAR DENEYİN.";
            $mesaj_turu = "danger";
        }
    } else {
        $mesaj = "GİRDİĞİNİZ DOĞRULAMA KODU HATALI!";
        $mesaj_turu = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>DOĞRULAMA | FORSY GİYİM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #fff; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: Arial; }
        .verify-card { background: #050505; border: 1px solid #111; padding: 40px; width: 400px; text-align: center; }
        .input-code { background: transparent !important; border: none; border-bottom: 2px solid #333; color: #fff !important; font-size: 24px; text-align: center; letter-spacing: 10px; border-radius: 0; margin-bottom: 20px; }
        .input-code:focus { border-bottom-color: #E84D35; box-shadow: none; }
        .btn-verify { background: #fff; color: #000; font-weight: 900; border: none; padding: 15px; width: 100%; letter-spacing: 2px; }
        .btn-verify:hover { background: #E84D35; color: #fff; }
    </style>
</head>
<body>
<div class="verify-card">
    <h3 class="mb-4">KODU ONAYLA</h3>
    <p class="small text-secondary mb-4"><?php echo $_SESSION['onay_eposta']; ?> ADRESİNE GÖNDERİLEN 6 HANELİ KODU GİRİN.</p>
    
    <?php if ($mesaj): ?>
        <div class="alert alert-<?php echo $mesaj_turu; ?> small"><?php echo $mesaj; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="kod" class="form-control input-code" maxlength="6" placeholder="000000" required>
        <button type="submit" class="btn-verify">HESABI AKTİF ET</button>
    </form>
</div>
</body>
</html>