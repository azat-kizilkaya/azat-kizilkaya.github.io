<?php
include 'db.php';
if(isset($_POST['urun_renk_id'])){
    $rid = $_POST['urun_renk_id'];
    // Seçilen rengin ana resmi
    $ana = $db->prepare("SELECT renk_ana_img FROM tbl_urun_renkleri WHERE urun_renk_id = ?");
    $ana->execute([$rid]);
    $ana_resim = $ana->fetchColumn();
    
    echo "<img src='gorseller/$ana_resim'>";

    // Seçilen rengin detay resimleri
    $detay = $db->prepare("SELECT gorsel_url FROM tbl_urun_gorselleri WHERE urun_renk_id = ?");
    $detay->execute([$rid]);
    while($row = $detay->fetch(PDO::FETCH_ASSOC)){
        echo "<img src='gorseller/".$row['gorsel_url']."'>";
    }
}
?>