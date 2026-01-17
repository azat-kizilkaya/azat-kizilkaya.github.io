<?php
session_start();
if(!isset($_SESSION['kullanici_id'])) { echo "login"; exit; }

if($_POST){
    $uid = $_POST['urun_id'];
    $beden = $_POST['beden'];
    $renk = $_POST['renk'];
    
    // Varyasyon Anahtarı: ÜrünID_Renk_Beden (Aynı ürünün farklı bedenleri ayrı satır olur)
    $key = $uid . "_" . $renk . "_" . $beden;

    if(!isset($_SESSION['sepet'])) { $_SESSION['sepet'] = []; }

    if(isset($_SESSION['sepet'][$key])){
        $_SESSION['sepet'][$key]['adet']++;
    } else {
        $_SESSION['sepet'][$key] = [
            'id' => $uid,
            'ad' => $_POST['ad'],
            'fiyat' => $_POST['fiyat'],
            'beden' => $beden,
            'renk' => $renk,
            'img' => $_POST['img'],
            'adet' => 1
        ];
    }
    echo "success";
}
?>