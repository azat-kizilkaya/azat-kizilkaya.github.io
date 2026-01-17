<?php
include 'db.php';

if(isset($_POST['query'])){
    $search = $_POST['query'];
    // Ürün isminde harf eşleşmesi ara
    $query = $db->prepare("SELECT urun_id, ad, fiyat, img_url FROM tbl_urunler WHERE ad LIKE ? LIMIT 5");
    $query->execute(["%$search%"]);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if($results){
        foreach($results as $row){
            echo "<a href='urun_detay.php?id=".$row['urun_id']."' class='search-item'>";
            echo "<img src='gorseller/".$row['img_url']."' width='50'>";
            echo "<span>".$row['ad']." - ".$row['fiyat']." TL</span>";
            echo "</a>";
        }
    } else {
        echo "Ürün bulunamadı.";
    }
}
?>