<?php
session_start();
// Veritabanı bağlantısı (MySQLi yapısı)
include 'db_config.php'; 
// Mail gönderme fonksiyonunu içeren dosya
include 'mail_handler.php'; 

$hata_mesaji = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini al ve temizle
    $ad = trim($_POST['ad']);
    $eposta = trim($_POST['eposta']);
    $sifre = $_POST['sifre'];
    
    if (empty($ad) || empty($eposta) || empty($sifre)) {
        $hata_mesaji = "LÜTFEN TÜM ALANLARI DOLDURUN.";
    } elseif (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        $hata_mesaji = "GEÇERSİZ E-POSTA ADRESİ.";
    } else {
        // 1. E-posta kontrolü
        $stmt = $conn->prepare("SELECT kullanici_id FROM tbl_kullanicilar WHERE eposta = ?");
        $stmt->bind_param("s", $eposta);
        $stmt->execute();
        $sonuc = $stmt->get_result();

        if ($sonuc->num_rows > 0) {
            $hata_mesaji = "BU E-POSTA ADRESİ ZATEN KAYITLI.";
        } else {
            // 2. Güvenlik ve Kod Üretimi
            $hashed_sifre = password_hash($sifre, PASSWORD_BCRYPT);
            $dogrulama_kodu = strval(rand(100000, 999999));
            
            // 3. Mail Gönderme Denemesi (KOD GİTMEZSE KAYIT YAPMAZ)
            if (sendVerificationMail($eposta, $dogrulama_kodu)) {
                
                // 4. Mail Gittiyse Veritabanına Kaydet (durum=0)
                $ekle = $conn->prepare("INSERT INTO tbl_kullanicilar (ad, eposta, sifre, dogrulama_kodu, durum) VALUES (?, ?, ?, ?, 0)");
                $ekle->bind_param("ssss", $ad, $eposta, $hashed_sifre, $dogrulama_kodu);
                
                if ($ekle->execute()) {
                    $_SESSION['onay_eposta'] = $eposta;
                    header("Location: dogrulama.php");
                    exit;
                } else {
                    $hata_mesaji = "VERİTABANI KAYIT HATASI OLUŞTU.";
                }
                
            } else {
                // Mail sunucusu hatası veya yanlış şifre durumu
                $hata_mesaji = "E-POSTA GÖNDERİLEMEDİ. LÜTFEN BİLGİLERİNİZİ VEYA İNTERNET BAĞLANTINIZI KONTROL EDİN.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAYIT OL | FORSY GİYİM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --accent: #E84D35; --bg: #000; }
        body { 
            background: var(--bg); 
            color: #fff; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: 'Roboto', sans-serif; 
            margin: 0;
        }
        .register-card { 
            background: #050505; 
            border: 1px solid #111; 
            padding: 50px; 
            width: 450px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .logo-area {
            font-family: 'Oswald', sans-serif;
            font-size: 28px;
            font-weight: 900;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }
        .logo-area span {
            background: #fff;
            color: #000;
            padding: 0 8px;
        }
        .input-minimal { 
            background: transparent !important; 
            border: none; 
            border-bottom: 1px solid #1a1a1a; 
            color: #fff !important; 
            margin-bottom: 25px; 
            border-radius: 0; 
            box-shadow: none !important; 
            padding: 12px 5px;
        }
        .input-minimal:focus {
            border-bottom: 1px solid var(--accent);
        }
        .btn-forsy { 
            background: #fff; 
            color: #000; 
            font-weight: 900; 
            border: none; 
            padding: 18px; 
            width: 100%; 
            letter-spacing: 3px; 
            text-transform: uppercase; 
            transition: 0.3s;
        }
        .btn-forsy:hover { 
            background: var(--accent); 
            color: #fff; 
        }
        .alert-custom {
            background: rgba(232, 77, 53, 0.1);
            border: 1px solid var(--accent);
            color: var(--accent);
            font-size: 13px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="logo-area">FORSY <span>GİYİM</span></div>
    
    <h4 class="text-center mb-4 fw-light" style="letter-spacing: 4px;">HESAP OLUŞTUR</h4>
    
    <?php if ($hata_mesaji): ?>
        <div class="alert alert-custom py-2 mb-4"><?= $hata_mesaji ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
        <input type="text" name="ad" class="form-control input-minimal" placeholder="AD SOYAD" required>
        <input type="email" name="eposta" class="form-control input-minimal" placeholder="E-POSTA ADRESİ" required>
        <input type="password" name="sifre" class="form-control input-minimal" placeholder="ŞİFRE" required>
        
        <button type="submit" class="btn-forsy">KAYIT OL VE DOĞRULA</button>
    </form>

    <div class="text-center mt-4">
        <a href="login.php" class="text-secondary small text-decoration-none">ZATEN ÜYE MİSİNİZ? <span style="color:#fff">GİRİŞ YAPIN</span></a>
    </div>
</div>

</body>
</html>