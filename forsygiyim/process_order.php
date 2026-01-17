<?php
session_start();
include 'db_config.php';
include 'Security.php';
include 'ErrorHandler.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Güvenlik
    if (!isset($_POST['csrf_token']) || !Security::verifyCSRFToken($_POST['csrf_token'])) {
        die("Güvenlik hatası: CSRF Token geçersiz.");
    }

    if (!isset($_SESSION['kullanici_id']) || empty($_SESSION['sepet'])) {
        header("Location: sepet.php");
        exit;
    }

    $tutar = floatval($_POST['gonderilecek_tutar'] ?? 0);
    $kullanici_id = $_SESSION['kullanici_id'];
    
    // Verileri Al
    $kart_sahibi = Security::sanitize($_POST['kart_sahibi'] ?? '');
    $adres = Security::sanitize($_POST['adres'] ?? '');
    $telefon = Security::sanitize($_POST['telefon'] ?? '');

    // Sipariş Kaydet
    $sql = "INSERT INTO tbl_siparisler (kullanici_id, toplam_tutar, durum) VALUES (?, ?, 'Hazırlanıyor')";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("id", $kullanici_id, $tutar);
        if ($stmt->execute()) {
            $siparis_id = $stmt->insert_id;
            
            // Ürünleri Kaydet
            foreach($_SESSION['sepet'] as $item) {
                // Ürün ID kontrolü: Sepet yapısına göre değişebilir, öncekinde 'id' veya 'urun_id' idi.
                $urun_id = $item['id'] ?? $item['urun_id']; 
                $adet = $item['adet'];
                $renk = $item['renk'] ?? '';
                $beden = $item['beden'] ?? '';
                $birim_fiyat = $item['fiyat'];

                $ins = $conn->prepare("INSERT INTO tbl_siparis_parcalari (siparis_id, urun_id, adet, fiyat, renk, beden) VALUES (?, ?, ?, ?, ?, ?)");
                $ins->bind_param("iiidss", $siparis_id, $urun_id, $adet, $birim_fiyat, $renk, $beden);
                $ins->execute();
            }

            // Temizlik
            unset($_SESSION['sepet']);
            unset($_SESSION['indirim_orani']);
            unset($_SESSION['kupon_kodu']);

            // Başarı sayfasına yönlendir
            header("Location: siparis_basarili.php?siparis_id=" . $siparis_id);
            exit;
        }
    }
    
    // Hata Durumu
    echo "Sipariş oluşturulurken bir hata oluştu.";
} else {
    header("Location: index.php");
}
?>
