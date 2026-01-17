<?php
include 'db_config.php';
include 'admin_auth.php';

// Kupon Silme
if(isset($_GET['sil_id'])) {
    $sil_id = intval($_GET['sil_id']);
    $conn->query("DELETE FROM tbl_kuponlar WHERE id = $sil_id");
    header("Location: admin_kuponlar.php?msg=deleted");
    exit;
}

// Yeni Kupon Ekleme
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kupon_ekle'])) {
    $kod = strtoupper(trim($_POST['kod']));
    $oran = intval($_POST['oran']);
    $tarih = $_POST['tarih'];
    
    $stmt = $conn->prepare("INSERT INTO tbl_kuponlar (kod, indirim_orani, gecerlilik_tarihi, aktif) VALUES (?, ?, ?, 1)");
    $stmt->bind_param("sis", $kod, $oran, $tarih);
    $stmt->execute();
    $mesaj = "Kupon başarıyla oluşturuldu!";
}

$kuponlar = $conn->query("SELECT * FROM tbl_kuponlar ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>KUPONLAR - FORSY PANEL</title>
    <!-- Bootstrap 5 Dark Theme -->
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

        .form-control, .form-select { background: #050505; border: 1px solid var(--border); color: #fff; border-radius: 0; padding: 12px; }
        .form-control:focus { background: #050505; color: #fff; border-color: var(--accent); box-shadow: none; }
        .btn-forsy { background: var(--accent); color: #fff; border: none; padding: 12px 30px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
        .btn-forsy:hover { background: #c0392b; color: #fff; }

        .coupon-card { background: #1a1a1a; border: 1px dashed var(--accent); padding: 20px; position: relative; overflow: hidden; }
        .coupon-card::before { content: ''; position: absolute; top: -10px; left: -10px; width: 20px; height: 20px; background: var(--bg); border-radius: 50%; }
        .coupon-card::after { content: ''; position: absolute; bottom: -10px; right: -10px; width: 20px; height: 20px; background: var(--bg); border-radius: 50%; }
        .coupon-code { font-size: 24px; font-family: 'Oswald'; color: var(--accent); letter-spacing: 2px; }
        .coupon-discount { font-size: 40px; font-weight: bold; line-height: 1; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">FORSY <span style="color:var(--accent)">ADMIN</span></div>
    <a href="admin_panel.php" class="sidebar-link"><i class="fa fa-chart-line"></i> Dashboard</a>
    <a href="admin_urunler.php" class="sidebar-link"><i class="fa fa-box"></i> Ürünler</a>
    <a href="admin_siparisler.php" class="sidebar-link"><i class="fa fa-shopping-bag"></i> Siparişler</a>
    <a href="admin_uyeler.php" class="sidebar-link"><i class="fa fa-users"></i> Üyeler</a>
    <a href="admin_kuponlar.php" class="sidebar-link active"><i class="fa fa-ticket-alt"></i> Kuponlar</a>
    <a href="logout.php" class="sidebar-link mt-5"><i class="fa fa-sign-out-alt"></i> Çıkış</a>
</div>

<div class="content">
    <div class="row">
        <!-- Kupon Ekleme Formu -->
        <div class="col-md-4">
            <h4 class="mb-4">YENİ KUPON OLUŞTUR</h4>
            <div class="card bg-dark border-0 p-4 shadow-lg">
                <form method="POST">
                    <div class="mb-3">
                        <label class="text-secondary small mb-1">KUPON KODU</label>
                        <input type="text" name="kod" class="form-control" placeholder="ÖRN: YAZ2025" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary small mb-1">İNDİRİM ORANI (%)</label>
                        <input type="number" name="oran" class="form-control" placeholder="10" min="1" max="100" required>
                    </div>
                    <div class="mb-4">
                        <label class="text-secondary small mb-1">SON KULLANMA TARİHİ</label>
                        <input type="date" name="tarih" class="form-control" required>
                    </div>
                    <button type="submit" name="kupon_ekle" class="btn btn-forsy w-100">OLUŞTUR</button>
                </form>
            </div>
        </div>

        <!-- Kupon Listesi -->
        <div class="col-md-8">
            <h4 class="mb-4">AKTİF KUPONLAR</h4>
            <div class="row g-3">
                <?php while($k = $kuponlar->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="coupon-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="coupon-code"><?= $k['kod'] ?></div>
                                <div class="text-secondary small mt-1">Bitiş: <?= date('d.m.Y', strtotime($k['gecerlilik_tarihi'])) ?></div>
                            </div>
                            <div class="text-end">
                                <div class="coupon-discount">%<?= $k['indirim_orani'] ?></div>
                                <a href="admin_kuponlar.php?sil_id=<?= $k['id'] ?>" class="text-danger small text-decoration-none mt-2 d-block"><i class="fa fa-trash"></i> SİL</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<script>
    <?php if(isset($mesaj)): ?>
    Swal.fire({
        icon: 'success',
        title: 'Başarılı!',
        text: '<?= $mesaj ?>',
        background: '#111',
        color: '#fff',
        confirmButtonColor: '#E84D35'
    });
    <?php endif; ?>

    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('msg') === 'deleted') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            background: '#111',
            color: '#fff',
            timerProgressBar: true
        })
        Toast.fire({
            icon: 'success',
            title: 'Kupon silindi'
        })
    }
</script>
</body>
</html>
