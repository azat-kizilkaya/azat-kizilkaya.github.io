<?php
include 'db_config.php';
include 'admin_auth.php';

// Form gönderildiğinde veritabanına kayıt
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['urun_ekle'])) {
    $ad = $_POST['ad'];
    $fiyat = $_POST['fiyat'];
    $kategori = $_POST['kategori'];
    $aciklama = $_POST['aciklama'];
    
    // Resim Yükleme (Basit Versiyon)
    $resim = $_FILES['resim']['name'];
    if($resim) {
        move_uploaded_file($_FILES['resim']['tmp_name'], "gorseller/".$resim);
    }

    // Ana Ürünü Kaydet
    // Stok bilgisini de formdan alıp ekliyoruz
    // varsayılan stok: 0
    $stok = intval($_POST['stok']);
    $stmt = $conn->prepare("INSERT INTO tbl_urunler (ad, fiyat, kategori, aciklama, img_url, stok) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsssi", $ad, $fiyat, $kategori, $aciklama, $resim, $stok);
    
    if($stmt->execute()) {
        $yeni_urun_id = $conn->insert_id;

        // Renkleri Kaydet (tbl_urun_renkleri)
        if (isset($_POST['renkler'])) {
            foreach ($_POST['renkler'] as $renk_id) {
                 $renk_id = intval($renk_id);
                 $stmt_r = $conn->prepare("INSERT INTO tbl_urun_renkleri (urun_id, renk_id) VALUES (?, ?)");
                 if($stmt_r) {
                     $stmt_r->bind_param("ii", $yeni_urun_id, $renk_id);
                     $stmt_r->execute();
                 }
            }
        }
        $mesaj = "Ürün başarıyla eklendi.";
    } else {
        $hata = "Hata oluştu: " . $conn->error;
    }
}

// Renkleri Çek
$renklerResult = $conn->query("SELECT * FROM tbl_renkler ORDER BY ad ASC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>ÜRÜNLER - FORSY PANEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root { --accent: #E84D35; --bg: #000; --panel: #111; --text: #eee; --border: #222; }
        body { background-color: var(--bg); color: var(--text); font-family: 'Roboto', sans-serif; }
        h1, h2, h3, h4, th { font-family: 'Oswald', sans-serif; text-transform: uppercase; letter-spacing: 1px; }
        
        .sidebar { width: 260px; height: 100vh; position: fixed; background: var(--panel); border-right: 1px solid var(--border); padding-top: 20px; }
        .sidebar-brand { font-size: 24px; text-align: center; color: #fff; margin-bottom: 40px; }
        .sidebar-link { display: block; padding: 15px 30px; color: #888; text-decoration: none; transition: 0.3s; font-weight: 500; font-size: 14px; text-transform: uppercase; }
        .sidebar-link:hover, .sidebar-link.active { background: var(--bg); color: var(--accent); border-left: 4px solid var(--accent); }
        .sidebar-link i { width: 25px; }

        .content { margin-left: 260px; padding: 40px; }

        .admin-card { background: var(--panel); border: 1px solid var(--border); padding: 30px; border-radius: 0; }
        .form-control, .form-select { background: #050505; border: 1px solid var(--border); color: #fff; border-radius: 0; padding: 12px; }
        .form-control:focus { background: #050505; color: #fff; border-color: var(--accent); box-shadow: none; }
        .btn-forsy { background: var(--accent); color: #fff; border: none; padding: 15px 30px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; width: 100%; font-family: 'Oswald'; }
        .btn-forsy:hover { background: #c0392b; color: #fff; }
        label { color: #888; font-size: 12px; text-transform: uppercase; margin-bottom: 5px; font-weight: bold; letter-spacing: 1px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">FORSY <span style="color:var(--accent)">ADMIN</span></div>
    <a href="admin_panel.php" class="sidebar-link"><i class="fa fa-chart-line"></i> Dashboard</a>
    <a href="admin_urunler.php" class="sidebar-link active"><i class="fa fa-box"></i> Ürünler</a>
    <a href="admin_siparisler.php" class="sidebar-link"><i class="fa fa-shopping-bag"></i> Siparişler</a>
    <a href="admin_uyeler.php" class="sidebar-link"><i class="fa fa-users"></i> Üyeler</a>
    <a href="admin_kuponlar.php" class="sidebar-link"><i class="fa fa-ticket-alt"></i> Kuponlar</a>
    <a href="logout.php" class="sidebar-link mt-5"><i class="fa fa-sign-out-alt"></i> Çıkış</a>
</div>

<div class="content">
    <h2 class="mb-4">ÜRÜN YÖNETİMİ</h2>
    
    <div class="row">
        <!-- Ürün Ekleme -->
        <div class="col-lg-8">
            <h5 class="text-secondary mb-3">YENİ ÜRÜN EKLE</h5>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="admin-card">
                            <div class="mb-3">
                                <label>Ürün Adı</label>
                                <input type="text" name="ad" class="form-control" placeholder="ÜRÜN ADI GİRİNİZ" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Fiyat (TL)</label>
                                    <input type="number" step="0.01" name="fiyat" class="form-control" placeholder="0.00" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Stok Adedi</label>
                                    <input type="number" name="stok" class="form-control" placeholder="Stoğa kaç adet girecek?" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="T-Shirt">T-Shirt</option>
                                    <option value="Hoodie">Hoodie</option>
                                    <option value="Pantolon">Pantolon</option>
                                    <option value="Aksesuar">Aksesuar</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Ürün Açıklaması</label>
                                <textarea name="aciklama" class="form-control" rows="4" placeholder="Ürün detaylarını buraya yazın..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Ana Resim</label>
                                <input type="file" name="resim" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="admin-card">
                            <label class="mb-3 text-white">MEVCUT RENKLER</label>
                            <div class="bg-dark p-3 border border-secondary" style="max-height: 300px; overflow-y: auto;">
                                <?php if($renklerResult->num_rows > 0): ?>
                                    <?php while($r = $renklerResult->fetch_assoc()): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input bg-dark border-secondary" type="checkbox" name="renkler[]" value="<?= $r['renk_id'] ?>" id="renk<?= $r['renk_id'] ?>">
                                        <label class="form-check-label small text-white-50" for="renk<?= $r['renk_id'] ?>">
                                            <span style="display:inline-block; width:12px; height:12px; background-color:<?= $r['hex_kodu'] ?? '#fff' ?>; border:1px solid #555; margin-right:5px; vertical-align:middle;"></span>
                                            <?= $r['ad'] ?>
                                        </label>
                                    </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <div class="text-white-50 small">Hiç renk tanımlanmamış.</div>
                                <?php endif; ?>
                            </div>
                            <div class="mt-3 small text-white-50 fst-italic">
                                * Beden seçenekleri standart olarak (S/M/L) sunulacaktır.
                            </div>
                            
                            <hr class="border-secondary my-4">
                            
                            <button type="submit" name="urun_ekle" class="btn btn-forsy">KAYDET</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Mevcut Ürün Listesi (Kısa) -->
        <div class="col-lg-4">
            <h5 class="text-secondary mb-3">SON EKLENENLER</h5>
            <div class="admin-card p-0">
                <table class="table table-dark table-striped mb-0 small">
                    <thead>
                        <tr>
                            <th class="ps-3">Ürün</th>
                            <th>Stok</th>
                            <th>Fiyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $son_urunler = $conn->query("SELECT * FROM tbl_urunler ORDER BY urun_id DESC LIMIT 10");
                        while($u = $son_urunler->fetch_assoc()): 
                        ?>
                        <tr>
                            <td class="ps-3"><?= $u['ad'] ?></td>
                            <td class="<?= $u['stok'] < 10 ? 'text-danger' : 'text-success' ?>"><?= $u['stok'] ?></td>
                            <td><?= $u['fiyat'] ?> ₺</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Varyasyon scripti iptal edildi
    <?php if(isset($mesaj)): ?>
        Swal.fire({
            icon: 'success',
            title: 'Harika!',
            text: '<?= $mesaj ?>',
            background: '#111',
            color: '#fff',
            confirmButtonColor: '#E84D35'
        });
    <?php endif; ?>
    
    <?php if(isset($hata)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Hata!',
            text: '<?= $hata ?>',
            background: '#111',
            color: '#fff'
        });
    <?php endif; ?>
</script>
</body>
</html>