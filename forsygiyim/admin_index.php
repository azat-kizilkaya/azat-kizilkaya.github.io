<?php
include 'db_config.php';
include 'admin_auth.php'; // Yetki kontrolü

// Toplam istatistikleri çekelim
$toplam_kazanc = $conn->query("SELECT SUM(toplam_tutar) FROM tbl_siparisler")->fetch_row()[0] ?? 0;
$siparis_sayisi = $conn->query("SELECT COUNT(*) FROM tbl_siparisler")->fetch_row()[0] ?? 0;

// Siparişleri ve detaylarını çekelim
$sql = "SELECT s.*, k.ad as musteri_ad 
        FROM tbl_siparisler s 
        JOIN tbl_kullanicilar k ON s.kullanici_id = k.kullanici_id 
        ORDER BY s.siparis_id DESC";
$siparisler = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>FORSY ADMIN | CONTROL PANEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&display=swap');
        body { background: #000; color: #fff; font-family: 'Segoe UI', sans-serif; }
        .sidebar { background: #050505; height: 100vh; border-right: 1px solid #111; padding: 30px; }
        .admin-card { background: #0a0a0a; border: 1px solid #111; padding: 25px; margin-bottom: 20px; }
        .stat-val { font-family: 'Syncopate'; color: #E84D35; font-size: 24px; font-weight: bold; }
        .table { color: #fff; border-color: #111; }
        .badge-status { background: #E84D35; color: #fff; font-size: 10px; text-transform: uppercase; padding: 5px 10px; border-radius: 0; }
        .detail-row { font-size: 12px; color: #888; border-top: 1px solid #111; padding-top: 10px; margin-top: 5px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <h4 class="mb-5" style="font-family:'Syncopate'; letter-spacing:3px;">FORSY <br><span style="color:#E84D35">ADMIN</span></h4>
            <nav class="nav flex-column gap-3">
                <a href="admin_index.php" class="nav-link text-white active">SİPARİŞLER</a>
                <a href="admin_urunler.php" class="nav-link text-secondary">ÜRÜNLER</a>
                <a href="admin_kuponlar.php" class="nav-link text-secondary">KUPONLAR</a>
                <a href="logout.php" class="nav-link text-danger mt-5">ÇIKIŞ YAP</a>
            </nav>
        </div>

        <div class="col-md-10 p-5">
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="admin-card">
                        <small class="text-secondary">TOPLAM KAZANÇ</small>
                        <div class="stat-val"><?= number_format($toplam_kazanc, 2) ?> TL</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-card">
                        <small class="text-secondary">SİPARİŞ ADEDİ</small>
                        <div class="stat-val"><?= $siparis_sayisi ?></div>
                    </div>
                </div>
            </div>

            <h5 class="mb-4" style="font-family:'Syncopate';">GÜNCEL SİPARİŞLER</h5>
            <div class="admin-card">
                <table class="table">
                    <thead>
                        <tr class="text-secondary small">
                            <th>ID</th>
                            <th>MÜŞTERİ</th>
                            <th>TOPLAM TUTAR</th>
                            <th>TARİH</th>
                            <th>DURUM</th>
                            <th>DETAYLAR (ÜRÜN - RENK - BEDEN)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($s = $siparisler->fetch_assoc()): ?>
                        <tr>
                            <td>#<?= $s['siparis_id'] ?></td>
                            <td class="fw-bold"><?= $s['musteri_ad'] ?></td>
                            <td><?= number_format($s['toplam_tutar'], 2) ?> TL</td>
                            <td class="small text-secondary"><?= $s['tarih'] ?></td>
                            <td><span class="badge-status"><?= $s['durum'] ?></span></td>
                            <td>
                                <?php 
                                // Siparişe ait ürün parçalarını (varyasyonlarla) çekelim
                                $p_sql = "SELECT sp.*, u.ad 
                                          FROM tbl_siparis_parcalari sp 
                                          JOIN tbl_urunler u ON sp.urun_id = u.urun_id 
                                          WHERE sp.siparis_id = " . $s['siparis_id'];
                                $parcalar = $conn->query($p_sql);
                                while($p = $parcalar->fetch_assoc()):
                                ?>
                                <div class="detail-row">
                                    <strong><?= $p['ad'] ?></strong> x <?= $p['adet'] ?> Adet 
                                    <span class="ms-2">[<?= $p['renk'] ?> / <?= $p['beden'] ?>]</span>
                                </div>
                                <?php endwhile; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>