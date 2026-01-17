<?php
session_start();
include 'db_config.php';
include 'Security.php';

$sepet = $_SESSION['sepet'] ?? [];
$indirim_orani = $_SESSION['indirim_orani'] ?? 0;
$kupon_kodu = $_SESSION['kupon_kodu'] ?? '';

// Başlangıç Hesaplamaları
$ara_toplam = 0;
$sepet_sayisi = 0;
foreach($sepet as $item) {
    // Resim URL Kontrolü
    $item_img = $item['img'] ?? $item['gorsel'] ?? '';
    // add_to_cart.php 'img' olarak kaydediyor ama eski sepetler 'gorsel' olabilir.
    
    // URL Check
    $resim = $item_img;
    
    $ara_toplam += ($item['fiyat'] * $item['adet']);
    $sepet_sayisi += $item['adet'];
}

$kampanya_limit = 2000;
$sablon_indirim = ($ara_toplam >= $kampanya_limit) ? 300 : 0;
$ilerleme_yuzde = min(($ara_toplam / $kampanya_limit) * 100, 100);

$kupon_indirim = $ara_toplam * ($indirim_orani / 100);
$genel_toplam = $ara_toplam - ($sablon_indirim + $kupon_indirim);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEPET | FORSY STUDIO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&family=Syncopate:wght@400;700&display=swap');
        
        :root { --accent: #E84D35; --dark-bg: #050505; --panel: #111; --border: #222; }
        
        body { background: var(--dark-bg); color: #fff; font-family: 'Space Grotesk', sans-serif; padding-top: 20px; }
        
        h1, h2, h3, h4 { font-family: 'Syncopate', sans-serif; letter-spacing: 2px; text-transform: uppercase; }
        
        .cart-container { max-width: 1200px; margin: 50px auto; padding: 0 20px; }
        
        /* Ürün Satırı */
        .cart-item { background: var(--panel); border: 1px solid var(--border); margin-bottom: 20px; padding: 20px; display: flex; align-items: center; justify-content: space-between; transition: 0.3s; position: relative; overflow: hidden; }
        .cart-item:hover { border-color: var(--accent); transform: translateX(5px); }
        
        .item-img-box { width: 100px; height: 120px; overflow: hidden; background: #222; position: relative; flex-shrink: 0; }
        .item-img-box img { width: 100%; height: 100%; object-fit: cover; }
        
        .item-details { flex-grow: 1; padding: 0 20px; }
        .item-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 5px; color: #fff; text-decoration: none; display: block; }
        .item-meta { color: #888; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 5px; }
        .item-price { font-family: 'Syncopate'; font-weight: 700; color: var(--accent); }
        
        .qty-box { display: flex; align-items: center; background: #000; border: 1px solid var(--border); }
        .qty-btn { background: none; border: none; color: #fff; padding: 5px 15px; cursor: pointer; transition: 0.2s; }
        .qty-btn:hover { color: var(--accent); }
        .qty-val { width: 40px; text-align: center; font-weight: bold; }
        
        .btn-remove { background: none; border: none; color: #555; font-size: 1.2rem; cursor: pointer; transition: 0.3s; margin-left: 20px; }
        .btn-remove:hover { color: #fe2a2a; transform: rotate(90deg); }
        
        /* Özet Kartı */
        .summary-card { background: var(--panel); border: 1px solid var(--border); padding: 40px; position: sticky; top: 100px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; color: #aaa; font-size: 0.9rem; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border); font-size: 1.3rem; font-weight: 700; color: #fff; font-family: 'Syncopate'; }
        
        .btn-checkout { background: #fff; color: #000; width: 100%; padding: 20px; border: none; font-weight: 800; text-transform: uppercase; font-family: 'Syncopate'; letter-spacing: 2px; margin-top: 30px; transition: 0.3s; cursor: pointer; display: block; text-align: center; text-decoration: none; }
        .btn-checkout:hover { background: var(--accent); color: #fff; box-shadow: 0 10px 30px rgba(232, 77, 53, 0.4); }
        
        .coupon-box { display: flex; margin-top: 20px; gap: 10px; }
        .coupon-input { background: transparent; border: 1px solid var(--border); color: #fff; padding: 10px; flex-grow: 1; text-transform: uppercase; }
        .btn-apply { background: #333; color: #fff; border: none; padding: 0 20px; font-weight: bold; cursor: pointer; }
        .btn-apply:hover { background: var(--accent); }

        /* Kampanya Barı */
        .campaign-bar { margin-bottom: 40px; padding: 20px; border: 1px solid #333; background: linear-gradient(90deg, rgba(232,77,53,0.1) 0%, rgba(0,0,0,0) 100%); }
        .progress-track { height: 4px; background: #333; margin-top: 10px; width: 100%; }
        .progress-fill { height: 100%; background: var(--accent); width: <?= $ilerleme_yuzde ?>%; transition: width 1s ease; box-shadow: 0 0 10px var(--accent); }

        @media(max-width: 768px) {
            .cart-item { flex-wrap: wrap; }
            .item-img-box { width: 80px; height: 100px; }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="cart-container">
    <div class="row">
        <!-- SOL: ÜRÜNLER -->
        <div class="col-lg-8" data-aos="fade-right">
            <h2 class="mb-4">ALIŞVERİŞ SEPETİ <span style="color:#555">(<?= $sepet_sayisi ?>)</span></h2>
            
            <!-- Kampanya İlerlemesi -->
            <div class="campaign-bar">
                <div class="d-flex justify-content-between x-small fw-bold">
                    <span><?= $sablon_indirim > 0 ? "KAMPANYA AKTİF!" : "2000 TL ÜZERİ 300 TL İNDİRİM" ?></span>
                    <span><?= number_format($ara_toplam, 2) ?> / 2,000 TL</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill"></div>
                </div>
            </div>

            <?php if(empty($sepet)): ?>
                <div class="text-center py-5 border border-dashed border-secondary opacity-50">
                    <i class="fa fa-shopping-bag fa-3x mb-3"></i>
                    <h3>SEPETİNİZ BOŞ</h3>
                    <a href="index.php" class="text-white text-decoration-underline">Koleksiyonu Keşfet</a>
                </div>
            <?php else: ?>
                <?php foreach($sepet as $key => $item): 
                    // Resim Mantığı:
                    // 1. URL mi? (http...)
                    // 2. Zaten 'gorseller/' ile mi başlıyor? (urun_detay.php'den tam yol gelmiş olabilir)
                    // 3. Hiçbiri değilse sadece dosya ismidir, başına gorseller/ ekle.
                    
                    $ham_resim = $item['img'] ?? $item['gorsel'] ?? '';
                    
                    if (strpos($ham_resim, 'http') === 0) {
                        $resim = $ham_resim;
                    } elseif (strpos($ham_resim, 'gorseller/') === 0) {
                        $resim = $ham_resim; // Zaten path var
                    } elseif ($ham_resim) {
                        $resim = 'gorseller/' . $ham_resim; 
                    } else {
                        $resim = 'https://via.placeholder.com/100?text=Resim+Yok';
                    }
                ?>
                <div class="cart-item" id="item-<?= $key ?>">
                    <div class="d-flex w-100 align-items-center">
                        <div class="item-img-box">
                            <img src="<?= $resim ?>" alt="">
                        </div>
                        <div class="item-details">
                            <a href="urun_detay.php?id=<?= $item['id'] ?? ($item['urun_id'] ?? 0) ?>" class="item-title"><?= $item['ad'] ?></a>
                            <div class="item-meta"><?= $item['renk'] ?> // <?= $item['beden'] ?></div>
                            <div class="item-price"><?= number_format($item['fiyat'], 2) ?> TL</div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="qty-box">
                                <button class="qty-btn" onclick="updateQty('<?= $key ?>', -1)">-</button>
                                <div class="qty-val" id="qty-<?= $key ?>"><?= $item['adet'] ?></div>
                                <button class="qty-btn" onclick="updateQty('<?= $key ?>', 1)">+</button>
                            </div>
                            <button class="btn-remove" onclick="removeItem('<?= $key ?>')" title="Sil">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- SAĞ: ÖZET -->
        <div class="col-lg-4" data-aos="fade-left">
            <div class="summary-card">
                <h3 class="mb-4" style="font-size:1.5rem">SİPARİŞ ÖZETİ</h3>
                
                <div class="summary-row">
                    <span>ARA TOPLAM</span>
                    <span id="subtotal"><?= number_format($ara_toplam, 2) ?> TL</span>
                </div>
                
                <div class="summary-row text-success" id="campaignRow" style="<?= $sablon_indirim > 0 ? '' : 'display:none' ?>">
                    <span>KAMPANYA İNDİRİMİ</span>
                    <span id="campaignDiscount">-<?= number_format($sablon_indirim, 2) ?> TL</span>
                </div>

                <div class="summary-row text-success" id="couponRow" style="<?= $indirim_orani > 0 ? '' : 'display:none' ?>">
                    <span>KUPON İNDİRİMİ</span>
                    <span id="couponDiscount">-<?= number_format($kupon_indirim, 2) ?> TL</span>
                </div>

                <div class="summary-row">
                    <span>KARGO</span>
                    <span class="text-white">ÜCRETSİZ</span>
                </div>

                <div class="summary-total">
                    <span>TOPLAM</span>
                    <span id="total"><?= number_format($genel_toplam, 2) ?> TL</span>
                </div>

                <div class="coupon-box">
                    <input type="text" id="couponCode" class="coupon-input" placeholder="KUPON KODU" value="<?= $kupon_kodu ?>">
                    <button class="btn-apply" onclick="applyCoupon()">OK</button>
                </div>

                <?php if(isset($_SESSION['kullanici_id'])): ?>
                    <form action="odeme.php" method="POST">
                         <!-- Toplam tutarı hidden olarak göndermeye gerek yok, odeme.php sessiondan çekmeli ama uyumluluk için gönderiyoruz -->
                         <input type="hidden" name="toplam_tutar" id="hiddenTotal" value="<?= $genel_toplam ?>">
                         <button type="submit" class="btn-checkout">ÖDEMEYE GEÇ</button>
                    </form>
                <?php else: ?>
                    <a href="login.php" class="btn-checkout" style="background:#555;">GİRİŞ YAP</a>
                <?php endif; ?>
                
                <div class="mt-4 d-flex justify-content-center gap-3 text-secondary fs-4">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-amex"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init();
    
    // Para formatı
    function formatMoney(amount) {
        return parseFloat(amount).toFixed(2) + ' TL';
    }

    function updateCartUI(data) {
        console.log(data);
        $('#subtotal').text(formatMoney(data.subtotal.replace(',',''))); // Basit replace, aslında localeString kullanılabilir
        $('#total').text(data.total + ' TL');
        $('#hiddenTotal').val(data.total.replace(',','')); // Numeric format
        
        if(parseFloat(data.campaign_discount) > 0) {
            $('#campaignRow').show();
            $('#campaignDiscount').text('-' + data.campaign_discount + ' TL');
        } else {
            $('#campaignRow').hide();
        }

        if(parseFloat(data.coupon_discount) > 0) {
            $('#couponRow').show();
            $('#couponDiscount').text('-' + data.coupon_discount + ' TL');
        } else {
            $('#couponRow').hide();
        }
        
        // Progress bar
        $('.progress-fill').css('width', data.progress_percent + '%');
    }

    function updateQty(key, change) {
        let currentQty = parseInt($('#qty-' + key).text());
        let newQty = currentQty + change;
        
        if (newQty < 1) return;

        $.ajax({
            url: 'cart_actions.php',
            method: 'POST',
            data: { action: 'update_qty', key: key, qty: newQty },
            dataType: 'json',
            success: function(res) {
                if(res.status === 'success') {
                    $('#qty-' + key).text(newQty);
                    updateCartUI(res.data);
                } else {
                    Swal.fire('Hata', res.message, 'error');
                }
            }
        });
    }

    function removeItem(key) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Ürün sepetten çıkarılacak.",
            icon: 'warning',
            background: '#111',
            color: '#fff',
            showCancelButton: true,
            confirmButtonColor: '#E84D35',
            cancelButtonColor: '#333',
            confirmButtonText: 'Evet, çıkar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'cart_actions.php',
                    method: 'POST',
                    data: { action: 'remove', key: key },
                    dataType: 'json',
                    success: function(res) {
                        if(res.status === 'success') {
                            $('#item-' + key).slideUp(300, function(){ $(this).remove(); });
                            updateCartUI(res.data);
                            Swal.fire({
                                icon: 'success',
                                title: 'Silindi', 
                                showConfirmButton: false, 
                                timer: 1000,
                                background: '#111', 
                                color: '#fff'
                            });
                            // Sepet boşaldıysa sayfayı yenile (boş state'i görmek için)
                            if(res.data.total_items == 0) setTimeout(() => location.reload(), 1000);
                        }
                    }
                });
            }
        })
    }

    function applyCoupon() {
        let code = $('#couponCode').val();
        if(!code) return;

        $.ajax({
            url: 'cart_actions.php',
            method: 'POST',
            data: { action: 'apply_coupon', code: code },
            dataType: 'json',
            success: function(res) {
                if(res.status === 'success') {
                    Swal.fire({
                        icon: 'success', 
                        title: 'Kupon Uygulandı!', 
                        text: res.message,
                        background: '#111', 
                        color: '#fff',
                        confirmButtonColor: '#E84D35'
                    });
                    updateCartUI(res.data);
                } else {
                    Swal.fire({
                        icon: 'error', 
                        title: 'Hata', 
                        text: res.message,
                        background: '#111',
                        color: '#fff',
                        confirmButtonColor: '#E84D35'
                    });
                    // Hatalıysa inputu temizle veya eski haline getir
                    updateCartUI(res.data); // Veri tutarlılığı için
                }
            }
        });
    }
</script>
</body>
</html>