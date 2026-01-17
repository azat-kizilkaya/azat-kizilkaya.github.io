<?php
include 'db.php';
if(isset($_POST['query'])){
    $q = "%".$_POST['query']."%";
    $s = $db->prepare("SELECT * FROM tbl_urunler WHERE ad LIKE ? LIMIT 5");
    $s->execute([$q]);
    $res = $s->fetchAll(PDO::FETCH_ASSOC);

    if($res){
        foreach($res as $r){
            echo "<a href='urun_detay.php?id=".$r['urun_id']."' style='display:flex; align-items:center; padding:10px; text-decoration:none; color:black; border-bottom:1px solid #eee;'>";
            echo "<img src='gorseller/".$r['img_url']."' style='width:50px; height:50px; object-fit:cover; margin-right:15px;'>";
            echo "<div><div style='font-size:13px; font-weight:bold;'>".$r['ad']."</div><div style='font-size:12px;'>".$r['fiyat']." TL</div></div>";
            echo "</a>";
        }
    } else {
        echo "<div style='padding:15px; font-size:13px;'>Sonuç bulunamadı.</div>";
    }
}
?>