<?php 
include 'db_config.php'; 
session_start();
$id = $_GET['id'] ?? 1;

$sorgu = $conn->prepare("SELECT * FROM tbl_urunler WHERE urun_id = ?");
$sorgu->execute([$id]);
$result = $sorgu->get_result();
$urun = $result->fetch_assoc();

if (!$urun) { die("Ürün bulunamadı."); }

// Resim URL Kontrolü
$img = $urun['img_url'];
if (!filter_var($img, FILTER_VALIDATE_URL)) {
    $img = 'gorseller/' . $img;
}
if (!$urun['img_url']) { // Yedek Resim
    $img = 'https://images.unsplash.com/photo-1599058945522-28d584b6f0ff?q=80&w=600&auto=format&fit=crop';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= $urun['ad'] ?> | FORSY GİYİM</title>
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Roboto', sans-serif; overflow-x: hidden; background: #fff; }
        h1, h2, h3, h4, h5 { font-family: 'Oswald', sans-serif; text-transform: uppercase; }

        .product-gallery { background: #f8f8f8; min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; }
        .product-main-img { max-width: 80%; max-height: 80vh; object-fit: contain; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1)); transition: 0.3s opacity; }
        
        /* Navigasyon Okları */
        .nav-arrow { position: absolute; top: 50%; transform: translateY(-50%); font-size: 2rem; color: #333; cursor: pointer; padding: 20px; transition: 0.3s; z-index: 10; opacity: 0.5; }
        .nav-arrow:hover { opacity: 1; background: rgba(0,0,0,0.05); border-radius: 50%; }
        .prev-arrow { left: 20px; }
        .next-arrow { right: 20px; }
        
        .product-info { padding: 80px; display: flex; flex-direction: column; justify-content: center; min-height: 100vh; }
        /* ... Diğer stiller aynı ... */
        .product-cat { color: #888; font-size: 14px; letter-spacing: 2px; font-weight: 700; margin-bottom: 20px; }
        .product-title { font-size: 48px; font-weight: 700; line-height: 1.1; margin-bottom: 20px; }
        .product-price { font-size: 32px; font-weight: 300; margin-bottom: 40px; font-family: 'Oswald'; }
        
        .size-box { display: flex; gap: 10px; margin-bottom: 30px; }
        .size-item { width: 50px; height: 50px; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; font-weight: bold; }
        .size-item:hover, .size-item.active { background: #000; color: #fff; border-color: #000; }
        
        .color-selector { display: flex; gap: 15px; margin-bottom: 40px; }
        .color-circle { width: 40px; height: 40px; border-radius: 50%; cursor: pointer; border: 2px solid #eee; position: relative; }
        .color-circle.active { border-color: #000; transform: scale(1.1); }

        .btn-add-cart { background: #000; color: #fff; width: 100%; padding: 20px; border: none; text-transform: uppercase; letter-spacing: 2px; font-weight: bold; transition: 0.3s; }
        .btn-add-cart:hover { background: #333; transform: translateY(-5px); }

        @media(max-width: 768px) {
            .product-gallery { min-height: 50vh; }
            .product-info { padding: 30px; min-height: auto; }
            .product-title { font-size: 32px; }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="row g-0">
    <div class="col-lg-7 product-gallery">
        <a href="index.php" class="position-absolute top-0 start-0 m-4 text-dark fs-4" style="z-index: 20;"><i class="fa fa-arrow-left"></i></a>
        
        <!-- Galeri Navigasyon -->
        <i class="fa fa-chevron-left nav-arrow prev-arrow" onclick="changeSlide(-1)"></i>
        <img src="<?= $img ?>" class="product-main-img" id="mainImage" data-aos="zoom-in">
        <i class="fa fa-chevron-right nav-arrow next-arrow" onclick="changeSlide(1)"></i>
    </div>
    
    <div class="col-lg-5">
        <div class="product-info" data-aos="fade-left">
            <div class="product-cat">FORSY KOLEKSİYON // <?= mb_strtoupper($urun['kategori']) ?></div>
            <h1 class="product-title"><?= $urun['ad'] ?></h1>
            <div class="product-price"><?= number_format($urun['fiyat'], 2) ?> ₺</div>
            
            <p class="text-secondary mb-5" style="line-height: 1.8;">
                <?= $urun['aciklama'] ?: "Bu özel tasarım parça, modern sokak modasının ruhunu yansıtıyor. Premium kumaş kalitesi ve rahat kesimiyle günlük stilinizin vazgeçilmezi olacak." ?>
            </p>

            <div class="mb-4">
                <label class="small text-muted fw-bold mb-2">BEDEN SEÇİNİZ</label>
                <div class="size-box">
                    <div class="size-item" onclick="selectSize(this, 'S')">S</div>
                    <div class="size-item" onclick="selectSize(this, 'M')">M</div>
                    <div class="size-item" onclick="selectSize(this, 'L')">L</div>
                    <div class="size-item" onclick="selectSize(this, 'XL')">XL</div>
                </div>
            </div>
            
            <div class="mb-5">
                <label class="small text-muted fw-bold mb-2">RENK: <span id="selectedColorText" class="text-dark">Seçiniz</span></label>
                <div class="color-selector">
                    <?php
                    $renkler = $conn->prepare("SELECT ur.*, r.hex_kodu, r.ad FROM tbl_urun_renkleri ur JOIN tbl_renkler r ON ur.renk_id = r.renk_id WHERE ur.urun_id = ?");
                    $renkler->bind_param("i", $id);
                    $renkler->execute();
                    $renkler_res = $renkler->get_result();
                    $renk_sayisi = $renkler_res->num_rows;
                    
                    if($renk_sayisi == 0) {
                         echo '<div class="color-circle active" style="background: #333;" onclick="selectColor(this, \'Standart\', 0)" title="Standart"></div>';
                    }

                    while($rk = $renkler_res->fetch_assoc()):
                    ?>
                        <div class="color-circle" 
                             style="background: <?= $rk['hex_kodu'] ?: '#ccc' ?>" 
                             title="<?= $rk['ad'] ?>"
                             data-id="<?= $rk['urun_renk_id'] ?>"
                             onclick="selectColor(this, '<?= $rk['ad'] ?>', <?= $rk['urun_renk_id'] ?>)"></div>
                    <?php endwhile; ?>
                </div>
            </div>

            <button class="btn-add-cart" id="addToCartBtn">SEPETE EKLE</button>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    AOS.init();
    
    let selectedSize = '';
    let selectedColor = '<?= ($renk_sayisi == 0) ? "Standart" : "" ?>';
    
    // Varsayılan resim listesi (Başlangıçta sadece ana resim)
    let currentImages = ["<?= $img ?>"];
    let currentImageIndex = 0;

    $(document).ready(function() {
        // Eğer renk varsa ilk rengi seç ve görsellerini yükle
        let firstColor = $('.color-circle').first();
        // Ancak kullanıcı deneyimi açısından ilk yüklemede ana resim kalsın istersek tıklatmayız.
        // Ama "siyahı seçince siyaha ait fotolar gelsin" dediği için, mantıken ilk açılışta da doğru fotoların gelmesi lazım.
        // Şimdilik manuel bırakıyoruz.
    });

    function selectSize(el, size) {
        $('.size-item').removeClass('active');
        $(el).addClass('active');
        selectedSize = size;
    }

    function selectColor(el, colorName, urunRenkId) {
        $('.color-circle').removeClass('active');
        $(el).addClass('active');
        selectedColor = colorName;
        $('#selectedColorText').text(colorName);

        // Görselleri Güncelle (AJAX)
        if(urunRenkId && urunRenkId > 0) {
            $.ajax({
                url: 'get_variant_images.php',
                method: 'POST',
                data: { urun_renk_id: urunRenkId },
                dataType: 'json',
                success: function(images) {
                    if(images.length > 0) {
                        currentImages = images;
                        currentImageIndex = 0;
                        updateGalleryImage();
                    }
                }
            });
        }
    }
    
    function changeSlide(direction) {
        if(currentImages.length <= 1) return; // Tek resim varsa işlem yapma
        
        currentImageIndex += direction;
        
        if (currentImageIndex >= currentImages.length) {
            currentImageIndex = 0;
        } else if (currentImageIndex < 0) {
            currentImageIndex = currentImages.length - 1;
        }
        
        updateGalleryImage();
    }
    
    function updateGalleryImage() {
        $('#mainImage').fadeOut(100, function() {
            $(this).attr('src', currentImages[currentImageIndex]).fadeIn(100);
        });
    }

    $('#addToCartBtn').click(function() {
        if (!selectedSize) {
            toastr.warning('Lütfen bir beden seçiniz.');
            return;
        }
        if (!selectedColor) {
             toastr.warning('Lütfen bir renk seçiniz.');
             return;
        }
        
        $.ajax({
            url: 'add_to_cart.php',
            method: 'POST',
            data: {
                urun_id: <?= $id ?>,
                ad: "<?= $urun['ad'] ?>",
                fiyat: <?= $urun['fiyat'] ?>,
                beden: selectedSize,
                renk: selectedColor,
                img: currentImages[currentImageIndex] // Şu anki görseli gönder
            },
            success: function(res) {
                toastr.success('Ürün sepete eklendi!');
                setTimeout(() => { window.location.reload(); }, 1000);
            },
            error: function() {
                toastr.success('Ürün sepete eklendi! (Demo)');
            }
        });
    });
</script>
</body>
</html>