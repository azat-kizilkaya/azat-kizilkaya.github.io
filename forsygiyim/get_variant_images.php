<?php
include 'db.php';

if(isset($_POST['urun_renk_id'])) {
    $urun_renk_id = intval($_POST['urun_renk_id']);
    
    // Önce ana resmi al
    $ana_resim_sorgu = $db->prepare("SELECT renk_ana_img FROM tbl_urun_renkleri WHERE urun_renk_id = ?");
    $ana_resim_sorgu->execute([$urun_renk_id]);
    $ana_resim = $ana_resim_sorgu->fetchColumn();

    $gorseller = [];

    // Ana resim varsa ekle
    if($ana_resim) {
         // URL kontrolü
        if (!filter_var($ana_resim, FILTER_VALIDATE_URL)) {
             $gorseller[] = 'gorseller/' . $ana_resim;
        } else {
             $gorseller[] = $ana_resim;
        }
    }

    // Ek görselleri al
    $ek_sorgu = $db->prepare("SELECT gorsel_url FROM tbl_urun_gorselleri WHERE urun_renk_id = ? ORDER BY sira ASC");
    $ek_sorgu->execute([$urun_renk_id]);
    
    while($row = $ek_sorgu->fetch(PDO::FETCH_ASSOC)) {
        $img = $row['gorsel_url'];
        if (!filter_var($img, FILTER_VALIDATE_URL)) {
            $img = 'gorseller/' . $img;
        }
        $gorseller[] = $img;
    }

    echo json_encode($gorseller);
}
?>
