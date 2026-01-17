<?php 
include 'db.php'; 
session_start();
include 'admin_auth.php';

// Aylık Satış Verilerini Çek (Son 6 Ay)
$aylar = [];
$satislar = [];
for ($i = 5; $i >= 0; $i--) {
    $tarih = date('Y-m', strtotime("-$i months"));
    $ay_isim = date('F', strtotime("-$i months"));
    
    // Türkçe Ay İsimleri
    $tr_aylar = ["January"=>"Ocak","February"=>"Şubat","March"=>"Mart","April"=>"Nisan","May"=>"Mayıs","June"=>"Haziran","July"=>"Temmuz","August"=>"Ağustos","September"=>"Eylül","October"=>"Ekim","November"=>"Kasım","December"=>"Aralık"];
    $aylar[] = $tr_aylar[$ay_isim];
    
    // Sütun adı düzeltme: siparis_tarihi -> tarih
    $sql = "SELECT SUM(toplam_tutar) as toplam FROM tbl_siparisler WHERE DATE_FORMAT(tarih, '%Y-%m') = '$tarih'";
    $res = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
    $satislar[] = $res['toplam'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>ADMİN PANELİ | FORSY GİYİM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --accent: #E84D35; --bg: #000; --panel: #111; --text: #eee; --border: #222; }
        body { background-color: var(--bg); color: var(--text); font-family: 'Roboto', sans-serif; overflow-x: hidden; }
        h1, h2, h3, h4, th { font-family: 'Oswald', sans-serif; text-transform: uppercase; letter-spacing: 1px; }
        
        .sidebar { width: 260px; height: 100vh; position: fixed; background: var(--panel); border-right: 1px solid var(--border); padding-top: 20px; z-index: 100; }
        .sidebar-brand { font-size: 24px; text-align: center; color: #fff; margin-bottom: 40px; }
        .sidebar-link { display: block; padding: 15px 30px; color: #888; text-decoration: none; transition: 0.3s; font-weight: 500; font-size: 14px; text-transform: uppercase; }
        .sidebar-link:hover, .sidebar-link.active { background: var(--bg); color: var(--accent); border-left: 4px solid var(--accent); }
        .sidebar-link i { width: 25px; }

        .content { margin-left: 260px; padding: 40px; }

        .stat-card { background: var(--panel); padding: 30px; border-radius: 0; border: 1px solid var(--border); transition: 0.3s; position: relative; overflow: hidden; }
        .stat-card:hover { transform: translateY(-5px); border-color: var(--accent); }
        .stat-card h3 { font-size: 14px; color: #888; margin-bottom: 10px; }
        .stat-card .value { font-size: 32px; font-family: 'Oswald'; font-weight: 700; color: #fff; }
        .stat-card .icon { position: absolute; right: 20px; top: 20px; font-size: 40px; color: var(--border); opacity: 0.5; }

        .chart-container { background: var(--panel); padding: 30px; border: 1px solid var(--border); margin-top: 30px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">FORSY <span style="color:var(--accent)">ADMIN</span></div>
    <a href="admin_panel.php" class="sidebar-link active"><i class="fa fa-chart-line"></i> Dashboard</a>
    <a href="admin_urunler.php" class="sidebar-link"><i class="fa fa-box"></i> Ürünler</a>
    <a href="admin_siparisler.php" class="sidebar-link"><i class="fa fa-shopping-bag"></i> Siparişler</a>
    <a href="admin_uyeler.php" class="sidebar-link"><i class="fa fa-users"></i> Üyeler</a>
    <a href="admin_kuponlar.php" class="sidebar-link"><i class="fa fa-ticket-alt"></i> Kuponlar</a>
    <a href="logout.php" class="sidebar-link mt-5"><i class="fa fa-sign-out-alt"></i> Çıkış</a>
</div>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Genel Bakış</h1>
        <div class="text-white-50">Hoş geldin, <span class="text-white fw-bold">Yönetici</span></div>
    </div>

    <div class="row g-4">
        <!-- İstatistik Kartları -->
        <div class="col-md-3">
            <div class="stat-card">
                <h3>TOPLAM ÜRÜN</h3>
                <div class="value"><?= $db->query("SELECT COUNT(*) FROM tbl_urunler")->fetchColumn(); ?></div>
                <i class="fa fa-box icon"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3>BEKLEYEN SİPARİŞ</h3>
                <div class="value text-warning"><?= $db->query("SELECT COUNT(*) FROM tbl_siparisler WHERE durum='Hazırlanıyor'")->fetchColumn(); ?></div>
                <i class="fa fa-clock icon"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3>TOPLAM ÜYE</h3>
                <div class="value"><?= $db->query("SELECT COUNT(*) FROM tbl_kullanicilar")->fetchColumn(); ?></div>
                <i class="fa fa-users icon"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3>TOPLAM CİRO</h3>
                <div class="value text-success"><?= number_format($db->query("SELECT SUM(toplam_tutar) FROM tbl_siparisler")->fetchColumn(), 2); ?> ₺</div>
                <i class="fa fa-coins icon"></i>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="chart-container">
                <h4 class="mb-4 text-white-50">SATIŞ PERFORMANSI (SON 6 AY)</h4>
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-container h-100">
                <h4 class="mb-4 text-white-50">SON SİPARİŞLER</h4>
                <?php 
                // Sütun adı düzeltme: siparis_tarihi -> tarih
                $son_siparisler = $db->query("SELECT * FROM tbl_siparisler ORDER BY tarih DESC LIMIT 5");
                while($ss = $son_siparisler->fetch(PDO::FETCH_ASSOC)):
                ?>
                <div class="d-flex justify-content-between border-bottom border-secondary pb-2 mb-2">
                    <div>
                        <!-- Sütun adı düzeltme: siparis_id -> id -->
                        <div class="fw-bold">#<?= $ss['id'] ?></div>
                        <div class="small text-white-50"><?= date('d.m H:i', strtotime($ss['tarih'])) ?></div>
                    </div>
                    <div class="text-end">
                        <div class="text-success fw-bold"><?= number_format($ss['toplam_tutar'], 0) ?> ₺</div>
                        <div class="badge bg-secondary rounded-0" style="font-size:10px;"><?= $ss['durum'] ?></div>
                    </div>
                </div>
                <?php endwhile; ?>
                <a href="admin_siparisler.php" class="btn btn-sm btn-outline-light w-100 mt-3 rounded-0">TÜMÜNÜ GÖR</a>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($aylar) ?>,
            datasets: [{
                label: 'Aylık Satış (TL)',
                data: <?= json_encode($satislar) ?>,
                borderColor: '#E84D35',
                backgroundColor: 'rgba(232, 77, 53, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    grid: { color: '#222' },
                    ticks: { color: '#888' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#888' }
                }
            }
        }
    });
</script>
</body>
</html>