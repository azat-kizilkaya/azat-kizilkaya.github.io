<?php
include 'db.php';
if(isset($_POST['urun_renk_id'])){
    $rid = $_POST['urun_renk_id'];
    $images = [];
    
    // Ana resim
    $ana = $db->prepare("SELECT renk_ana_img FROM tbl_urun_renkleri WHERE urun_renk_id = ?");
    $ana->execute([$rid]);
    $images[] = $ana->fetchColumn();

    // Detay resimleri
    $detay = $db->prepare("SELECT gorsel_url FROM tbl_urun_gorselleri WHERE urun_renk_id = ?");
    $detay->execute([$rid]);
    while($row = $detay->fetch(PDO::FETCH_ASSOC)){
        $images[] = $row['gorsel_url'];
    }
    
    echo json_encode($images);
}
?>