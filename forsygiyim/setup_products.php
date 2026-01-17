<?php
include 'db.php';

// Hata Raporlama
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>Forsy Giyim - Otomatik İçerik Yükleyici</h3>";

// Eklenecek Premium Ürün Listesi (Unsplash Görselleri ile)
// Kategoriler: Hoodie, Ceket, Şort, Aksesuar, T-Shirt, Eşofman Altı
$urunler = [
    // HOODIE KATEGORİSİ
    ['Hoodie', 'Oversize Siyah Street Hoodie', 'Kalın pamuklu kumaş, kapüşonlu, bol kesim.', 1299.90, 50, 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=2070&auto=format&fit=crop'],
    ['Hoodie', 'Bej Minimalist Hoodie', 'Toprak tonlarında, rahat kesim basic hoodie.', 1150.00, 45, 'https://images.unsplash.com/photo-1578768079052-aa76e52ff62e?q=80&w=1974&auto=format&fit=crop'],
    ['Hoodie', 'Urban Grafik Baskılı Hoodie', 'Sırt baskılı, sokak modasına uygun tasarım.', 1350.00, 30, 'https://images.unsplash.com/photo-1620799140408-ed5341cd2431?q=80&w=2072&auto=format&fit=crop'],
    ['Hoodie', 'Reflektörlü Techwear Hoodie', 'Gece parlayan detaylar, teknik kumaş.', 1500.00, 20, 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=2070&auto=format&fit=crop'],

    // CEKET KATEGORİSİ
    ['Ceket', 'Siyah Denim Ceket', 'Klasik kesim, metal düğmeli siyah kot ceket.', 1899.90, 25, 'https://images.unsplash.com/photo-1516257984-b1b4d8c9230e?q=80&w=1974&auto=format&fit=crop'],
    ['Ceket', 'Haki Bomber Ceket', 'İçi turuncu astarlı, klasik bomber pilot ceketi.', 1750.00, 35, 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop'],
    ['Ceket', 'Deri Görünümlü Biker Ceket', 'Suni deri, fermuarlı detaylar.', 2200.00, 15, 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?q=80&w=1995&auto=format&fit=crop'],
    ['Ceket', 'Krem Rengi Kolej Ceketi', 'Nakış detaylı, kolej tarzı ceket.', 1600.00, 40, 'https://images.unsplash.com/photo-1559551409-dadc959f76b8?q=80&w=2072&auto=format&fit=crop'],

    // ŞORT KATEGORİSİ
    ['Şort', 'Kargo Cepli Siyah Şort', 'Bol cepli, rahat kesim yazlık şort.', 650.00, 60, 'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?q=80&w=2070&auto=format&fit=crop'],
    ['Şort', 'Grimelanj Sweat Şort', 'Evde ve sokakta rahatlık için pamuklu şort.', 450.00, 80, 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?q=80&w=2071&auto=format&fit=crop'],
    ['Şort', 'Desenli Yüzme Şortu', 'Hızlı kuruyan kumaş, modern desenler.', 550.00, 55, 'https://images.unsplash.com/photo-1563630423918-b58f07336ac9?q=80&w=1974&auto=format&fit=crop'],

    // AKSESUAR KATEGORİSİ
    ['Aksesuar', 'Siyah Bucket Şapka', '90lar stili balıkçı şapkası.', 250.00, 100, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=1974&auto=format&fit=crop'],
    ['Aksesuar', 'Çapraz Çanta (Crossbody)', 'Günlük kullanım için pratik siyah çanta.', 350.00, 45, 'https://images.unsplash.com/photo-1547949003-9792a18a2601?q=80&w=2070&auto=format&fit=crop'],
    ['Aksesuar', 'Forsy Logo Çorap (3\'lü)', 'Yüksek bilekli, logolu spor çorap.', 150.00, 200, 'https://images.unsplash.com/photo-1586525198428-225f6f12cff5?q=80&w=1974&auto=format&fit=crop'],
    ['Aksesuar', 'Metal Zincir Kolye', 'Paslanmaz çelik, kalın zincir kolye.', 180.00, 60, 'https://images.unsplash.com/photo-1611085583191-a3b181a88401?q=80&w=2070&auto=format&fit=crop'],

    // T-SHIRT YENİLER
    ['T-Shirt', 'Vintage Wash Gri Tshirt', 'Yıkanmış efektli, eskitme görünümlü.', 450.00, 70, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=1974&auto=format&fit=crop'],
    ['T-Shirt', 'Arkası Baskılı Beyaz Oversize', 'Minimalist ön, büyük arka baskı.', 480.00, 65, 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=1964&auto=format&fit=crop'],
];

$eklenen = 0;
foreach ($urunler as $u) {
    $kategori = $u[0];
    $ad = $u[1];
    $aciklama = $u[2];
    $fiyat = $u[3];
    $stok = $u[4];
    $img = $u[5];

    // Ürün var mı kontrol et (Adına göre)
    $kontrol = $db->prepare("SELECT COUNT(*) FROM tbl_urunler WHERE ad = ?");
    $kontrol->execute([$ad]);
    
    if ($kontrol->fetchColumn() == 0) {
        // Yoksa ekle
        $stmt = $db->prepare("INSERT INTO tbl_urunler (ad, aciklama, kategori, fiyat, stok, img_url) VALUES (?, ?, ?, ?, ?, ?)");
        if($stmt->execute([$ad, $aciklama, $kategori, $fiyat, $stok, $img])) {
            $eklenen++;
            echo "<div style='color:green'>Eklendi: $ad</div>";
        } else {
            echo "<div style='color:red'>Hata: $ad kaydı yapılamadı.</div>";
        }
    } else {
        echo "<div style='color:gray'>Mevcut: $ad</div>";
    }
}

echo "<br><hr><h3>Toplam $eklenen yeni ürün başarıyla veritabanına eklendi!</h3>";
echo "<a href='index.php'>Ana Sayfaya Dön</a>";
?>
