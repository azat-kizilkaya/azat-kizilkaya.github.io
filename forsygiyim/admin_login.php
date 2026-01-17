<?php
session_start();
include 'db_config.php';
// Zaten giriş yapmışsa panele yolla
if(isset($_SESSION['admin_id'])) {
    header("Location: admin_panel.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Veritabanından Yönetici Kontrolü
    // tbl_yoneticiler tablosunda: id, kullanici_ad, eposta, sifre
    // Kullanıcı adı veya e-posta ile giriş yapılabilir
    $stmt = $conn->prepare("SELECT * FROM tbl_yoneticiler WHERE kullanici_ad = ? OR eposta = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && $password === $admin['sifre']) { // Not: Güvenlik için password_verify kullanılmalı ama SQL'de düz metin 123456 var
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['kullanici_ad'];
        header("Location: admin_panel.php");
        exit;
    } else {
        $error = "Hatalı kullanıcı adı veya şifre!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetici Girişi | FORSY</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Roboto', sans-serif; 
            background: #000; 
            color: #fff; 
            height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            margin: 0; 
        }
        .login-box { 
            width: 350px; 
            padding: 40px; 
            border: 1px solid #333; 
            background: #111;
            text-align: center; 
        }
        .logo { 
            font-family: 'Oswald', sans-serif; 
            font-size: 28px; 
            margin-bottom: 30px; 
            letter-spacing: 2px;
        }
        input { 
            width: 100%; 
            padding: 15px; 
            margin-bottom: 15px; 
            background: #000;
            border: 1px solid #333; 
            color: #fff;
            box-sizing: border-box; 
            font-size: 14px; 
        }
        input:focus {
            outline: none;
            border-color: #fff;
        }
        button { 
            width: 100%; 
            padding: 15px; 
            background: #fff; 
            color: #000; 
            border: none; 
            font-weight: bold; 
            cursor: pointer; 
            text-transform: uppercase; 
            transition: 0.3s; 
            letter-spacing: 1px;
        }
        button:hover { 
            background: #ccc; 
        }
        .error { 
            color: #ff4d4d; 
            margin-bottom: 20px; 
            font-size: 14px; 
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
            font-size: 12px;
        }
        .back-link:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">FORSY ADMIN</div>
        <?php if($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="KULLANICI ADI" required autocomplete="off">
            <input type="password" name="password" placeholder="ŞİFRE" required>
            <button type="submit">GİRİŞ YAP</button>
        </form>
        <a href="login.php" class="back-link">← Mağaza Girişine Dön</a>
    </div>
</body>
</html>
