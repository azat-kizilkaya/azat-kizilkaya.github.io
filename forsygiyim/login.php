<?php 
include 'db.php'; 
session_start();
if(isset($_SESSION['kullanici_id'])) { header("Location: index.php"); exit; }

if($_POST){
    $eposta = $_POST['eposta'];
    $sifre = $_POST['sifre'];
    
    $sorgu = $db->prepare("SELECT * FROM tbl_kullanicilar WHERE eposta = ?");
    $sorgu->execute([$eposta]);
    $user = $sorgu->fetch(PDO::FETCH_ASSOC);
    
    if($user && ($sifre == $user['sifre'] || password_verify($sifre, $user['sifre']))){
        if($user['durum'] == 0){
            $hata = "Lütfen önce e-posta adresinizi doğrulayın.";
        } else {
            $_SESSION['kullanici_id'] = $user['kullanici_id'];
            $_SESSION['ad'] = $user['ad'];
            header("Location: index.php");
        }
    } else {
        $hata = "E-posta veya şifre hatalı.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap | FORSY GİYİM</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { width: 400px; padding: 40px; border: 1px solid #ebedee; text-align: center; }
        .logo { font-family: 'Oswald', sans-serif; font-size: 32px; letter-spacing: -1px; margin-bottom: 30px; }
        h2 { text-transform: uppercase; font-size: 24px; margin-bottom: 20px; }
        input { width: 100%; padding: 15px; margin-bottom: 15px; border: 1px solid #999; box-sizing: border-box; font-size: 16px; }
        button { width: 100%; padding: 15px; background: #000; color: #fff; border: none; font-weight: bold; cursor: pointer; text-transform: uppercase; transition: 0.3s; }
        button:hover { background: #333; }
        .links { margin-top: 20px; font-size: 14px; }
        .links a { color: #000; font-weight: 700; text-decoration: none; border-bottom: 1px solid #000; }
        .error { color: red; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">FORSY GİYİM</div>
        <h2>GİRİŞ YAP</h2>
        <?php if(isset($hata)) echo "<div class='error'>$hata</div>"; ?>
        <form method="POST">
            <input type="email" name="eposta" placeholder="E-posta Adresi" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <button type="submit">GİRİŞ YAP</button>
        </form>
        <div class="links">
            Hesabın yok mu? <a href="kayit_ol.php">ŞİMDİ KAYDOL</a>
        </div>
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <a href="admin_login.php" style="color: #999; text-decoration: none; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">YÖNETİCİ GİRİŞİ</a>
        </div>
    </div>
</body>
</html>