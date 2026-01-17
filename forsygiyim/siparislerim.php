<?php
session_start();
include 'db_config.php';

// Oturum Kontrolü
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['kullanici_id'];
$sorgu = $conn->prepare("SELECT * FROM tbl_siparisler WHERE kullanici_id = ? ORDER BY id DESC");
$sorgu->bind_param("i", $uid);
$sorgu->execute();
$siparisler = $sorgu->get_result();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>SİPARİŞ GEÇMİŞİM | FORSY STUDIO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&family=Syncopate:wght@400;700&display=swap');
        
        :root { --accent: #E84D35; --bg: #000; --panel: #111; --border: #222; }
        body { background: var(--bg); color: #fff; font-family: 'Space Grotesk', sans-serif; padding-top: 20px; }
        h2 { font-family: 'Syncopate'; font-weight: 700; letter-spacing: 2px; }

        .order-card { background: var(--panel); border: 1px solid var(--border); margin-bottom: 20px; transition: 0.3s; }
        .order-card:hover { border-color: var(--accent); }
        
        .order-header { padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; cursor: pointer; }
        .order-body { padding: 20px; display: none; background: #0a0a0a; }
        
        .status-badge { padding: 5px 12px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .status-wa { background: #E67E22; color: #fff; } /* Bekliyor */
        .status-ok { background: #27AE60; color: #fff; } /* Tamamlandı */
        .status-er { background: #C0392B; color: #fff; } /* İptal */
        
        .item-row { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid #222; padding-bottom: 15px; }
        .item-img { width: 60px; height: 80px; object-fit: cover; background: #222; }
        
        .toggle-icon { transition: 0.3s; }
        .active .toggle-icon { transform: rotate(180deg); }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <h2 class="mb-5 text-center">SİPARİŞ GEÇMİŞİM</h2>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <?php if ($siparisler->num_rows == 0): ?>
                <div class="text-center py-5 border border-dashed border-secondary opacity-50">
                    <i class="fa fa-box-open fa-3x mb-3"></i>
                    <h4>HENÜZ SİPARİŞİNİZ YOK.</h4>
                    <a href="index.php" class="text-white text-decoration-underline">Alışverişe Başla</a>
                </div>
            <?php else: ?>
                <?php while($sip = $siparisler->fetch_assoc()): 
                    $tarih = date("d.m.Y H:i", strtotime($sip['tarih']));
                    $durum_renk = 'status-wa';
                    if($sip['durum'] == 'Tamamlandı' || $sip['durum'] == 'Kargolandı') $durum_renk = 'status-ok';
                    if($sip['durum'] == 'İptal') $durum_renk = 'status-er';
                ?>
                <div class="order-card">
                    <div class="order-header" onclick="toggleOrder(this)">
                        <div class="d-flex align-items-center gap-4">
                            <div>
                                <div class="text-white-50 x-small">SİPARİŞ NO</div>
                                <div class="fw-bold">#<?= $sip['id'] ?></div>
                            </div>
                            <div>
                                <div class="text-white-50 x-small">TARİH</div>
                                <div><?= $tarih ?></div>
                            </div>
                            <div>
                                <div class="text-white-50 x-small">TUTAR</div>
                                <div class="text-accent fw-bold"><?= number_format($sip['toplam_tutar'], 2) ?> TL</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="status-badge <?= $durum_renk ?>"><?= mb_strtoupper($sip['durum']) ?></span>
                            <i class="fa fa-chevron-down toggle-icon"></i>
                        </div>
                    </div>
                    <div class="order-body">
                        <?php
                        $detay_sql = "SELECT sp.*, u.ad as urun_adi, u.img_url FROM tbl_siparis_parcalari sp JOIN tbl_urunler u ON sp.urun_id = u.urun_id WHERE sp.siparis_id = ?";
                        $stmt = $conn->prepare($detay_sql);
                        $stmt->bind_param("i", $sip['id']);
                        $stmt->execute();
                        $detaylar = $stmt->get_result();
                        
                        while($d = $detaylar->fetch_assoc()):
                             $img = $d['img_url'];
                             if (!filter_var($img, FILTER_VALIDATE_URL)) $img = 'gorseller/' . $img;
                        ?>
                        <div class="item-row">
                            <img src="<?= $img ?>" class="item-img" onerror="this.src='https://via.placeholder.com/60'">
                            <div>
                                <div class="fw-bold"><?= $d['urun_adi'] ?></div>
                                <div class="text-white-50 small"><?= $d['renk'] ?> // <?= $d['beden'] ?> // <?= $d['adet'] ?> Adet</div>
                                <div class="small text-accent"><?= number_format($d['fiyat'], 2) ?> TL</div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleOrder(header) {
        $(header).toggleClass('active');
        $(header).next('.order-body').slideToggle(300);
    }
</script>

</body>
</html>
