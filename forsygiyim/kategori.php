<?php 
include 'db.php'; 
session_start();

$kat = $_GET['k'] ?? '';
$sira = $_GET['sira'] ?? 'yeni';

// Dinamik Sorgu Oluşturma
$sql = "SELECT * FROM tbl_urunler";
$params = [];

if ($kat) {
    $sql .= " WHERE kategori = ?";
    $params[] = $kat;
}

// Sıralama Mantığı
if ($sira == 'dusuk') $sql .= " ORDER BY fiyat ASC";
elseif ($sira == 'yuksek') $sql .= " ORDER BY fiyat DESC";
else $sql .= " ORDER BY urun_id DESC";

$sorgu = $db->prepare($sql);
$sorgu->execute($params);
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= $kat ? $kat : 'Tüm Ürünler' ?> | FORSY GİYİM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Roboto', sans-serif; margin: 0; background: #fff; }
        .filter-header { padding: 40px 50px; background: #f8f8f8; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .grid-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; padding: 50px; }
        
        .cat-card { border: none; transition: 0.3s; cursor: pointer; }
        .cat-card:hover { transform: translateY(-10px); }
        .cat-img-wrap { height: 450px; overflow: hidden; background: #eee; position: relative; }
        .cat-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .cat-card:hover img { transform: scale(1.05); }
        
        .cat-info { padding: 20px 0; text-align: center; }
        .cat-title { font-family: 'Oswald'; font-size: 18px; text-transform: uppercase; margin-bottom: 5px; }
        .cat-price { color: #555; font-weight: 300; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="filter-header">
    <div>
        <h1 style="font-size: 40px; margin:0;"><?= $kat ? mb_strtoupper($kat) : 'TÜM KOLEKSİYON' ?></h1>
        <p class="text-muted mb-0"><?= count($urunler) ?> Ürün Listeleniyor</p>
    </div>
    
    <select class="form-select w-auto rounded-0 border-dark" onchange="location.href='kategori.php?k=<?= $kat ?>&sira=' + this.value">
        <option value="yeni" <?= $sira == 'yeni' ? 'selected' : '' ?>>EN YENİLER</option>
        <option value="dusuk" <?= $sira == 'dusuk' ? 'selected' : '' ?>>FİYAT: DÜŞÜK - YÜKSEK</option>
        <option value="yuksek" <?= $sira == 'yuksek' ? 'selected' : '' ?>>FİYAT: YÜKSEK - DÜŞÜK</option>
    </select>
</div>

<div class="grid-container">
    <?php foreach($urunler as $u): ?>
        <?php 
        // Resim URL Kontrolü
        $img = $u['img_url'];
        if (!filter_var($img, FILTER_VALIDATE_URL)) {
            $img = 'gorseller/' . $img;
        }
        if (!$u['img_url']) $img = 'https://via.placeholder.com/400x600';
        ?>
        <div class="cat-card" data-aos="fade-up" onclick="location.href='urun_detay.php?id=<?= $u['urun_id'] ?>'">
            <div class="cat-img-wrap">
                <img src="<?= $img ?>" alt="<?= $u['ad'] ?>">
            </div>
            <div class="cat-info">
                <div class="cat-title"><?= $u['ad'] ?></div>
                <div class="cat-price"><?= $u['fiyat'] ?> TL</div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({once:true});</script>
</body>
</html>