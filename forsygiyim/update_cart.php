<?php
session_start();

// Hangi ürünün (key) ve hangi işlemin (action) yapılacağını alıyoruz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $urun_key = $_POST['urun_key']; // Sepetteki benzersiz anahtar (varyasyon dahil)
    $action = $_POST['action'];     // 'update' veya 'delete'

    if (isset($_SESSION['sepet'][$urun_key])) {
        
        // 1. ÜRÜN SİLME İŞLEMİ
        if ($action == 'delete') {
            unset($_SESSION['sepet'][$urun_key]);
        }
        
        // 2. ADET GÜNCELLEME İŞLEMİ (+ veya - butonları)
        elseif ($action == 'update') {
            $yeni_adet = intval($_POST['adet']);
            
            // Adet 0'dan büyükse güncelle, değilse ürünü sil
            if ($yeni_adet > 0) {
                $_SESSION['sepet'][$urun_key]['adet'] = $yeni_adet;
            } else {
                unset($_SESSION['sepet'][$urun_key]);
            }
        }
    }
}

// İşlem bittikten sonra kullanıcıyı tekrar sepet sayfasına geri gönder
header("Location: sepet.php");
exit;
?>