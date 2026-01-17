<?php
include 'db_config.php';
include 'admin_auth.php';

// Üye Silme
if(isset($_GET['sil_id'])) {
    $sil_id = intval($_GET['sil_id']);
    $conn->query("DELETE FROM tbl_kullanicilar WHERE kullanici_id = $sil_id");
    header("Location: admin_uyeler.php?msg=deleted");
    exit;
}

// Üye Durumu Değiştirme (Aktif/Pasif)
if(isset($_GET['durum_id'])) {
    $durum_id = intval($_GET['durum_id']);
    // Mevcut durumu tersine çevir (1->0, 0->1)
    $conn->query("UPDATE tbl_kullanicilar SET durum = NOT durum WHERE kullanici_id = $durum_id");
    header("Location: admin_uyeler.php?msg=updated");
    exit;
}

$uyeler = $conn->query("SELECT * FROM tbl_kullanicilar ORDER BY kullanici_id DESC");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>ÜYELER - FORSY PANEL</title>
    <!-- Bootstrap 5 Dark Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
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

        .table-dark-custom { background: var(--panel); border: 1px solid var(--border); color: #ccc; }
        .table-dark-custom th { background: #050505; color: var(--accent); border-bottom: 2px solid var(--accent); padding: 15px; }
        .table-dark-custom td { border-bottom: 1px solid var(--border); padding: 15px; vertical-align: middle; }
        
        .avatar-circle { width: 40px; height: 40px; background: #333; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-family: 'Oswald'; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">FORSY <span style="color:var(--accent)">ADMIN</span></div>
    <a href="admin_panel.php" class="sidebar-link"><i class="fa fa-chart-line"></i> Dashboard</a>
    <a href="admin_urunler.php" class="sidebar-link"><i class="fa fa-box"></i> Ürünler</a>
    <a href="admin_siparisler.php" class="sidebar-link"><i class="fa fa-shopping-bag"></i> Siparişler</a>
    <a href="admin_uyeler.php" class="sidebar-link active"><i class="fa fa-users"></i> Üyeler</a>
    <a href="admin_kuponlar.php" class="sidebar-link"><i class="fa fa-ticket-alt"></i> Kuponlar</a>
    <a href="logout.php" class="sidebar-link mt-5"><i class="fa fa-sign-out-alt"></i> Çıkış</a>
</div>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Üye Listesi</h2>
        <div class="text-secondary small">Kayıtlı toplam <?= $uyeler->num_rows ?> üye</div>
    </div>

    <div class="card bg-dark border-0 shadow-lg p-3">
        <table id="usersTable" class="table table-dark-custom table-hover w-100">
            <thead>
                <tr>
                    <th>Üye</th>
                    <th>E-posta</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while($u = $uyeler->fetch_assoc()): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-3"><?= strtoupper(substr($u['ad'], 0, 1)) ?></div>
                            <span class="fw-bold"><?= $u['ad'] ?></span>
                        </div>
                    </td>
                    <td><?= $u['eposta'] ?></td>
                    <td>
                        <?php if($u['durum'] == 1): ?>
                            <span class="badge bg-success rounded-0">AKTİF</span>
                        <?php else: ?>
                            <span class="badge bg-danger rounded-0">PASİF/ONAYSIZ</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="admin_uyeler.php?durum_id=<?= $u['kullanici_id'] ?>" class="btn btn-sm btn-outline-warning rounded-0" title="Durumu Değiştir">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        <button onclick="deleteMember(<?= $u['kullanici_id'] ?>)" class="btn btn-sm btn-outline-danger rounded-0" title="Sil">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/tr.json" }
        });
    });

    function deleteMember(id) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu üyeyi silmek veri kaybına neden olabilir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E84D35',
            cancelButtonColor: '#333',
            confirmButtonText: 'Evet, SİL!',
            background: '#111',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'admin_uyeler.php?sil_id=' + id;
            }
        })
    }

    // URL'deki mesaj parametresine göre bildirim
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('msg') === 'deleted') {
        Swal.fire({icon: 'success', title: 'Silindi!', background: '#111', color:'#fff', showConfirmButton: false, timer: 1500});
    } else if(urlParams.get('msg') === 'updated') {
        Swal.fire({icon: 'success', title: 'Durum Güncellendi!', background: '#111', color:'#fff', showConfirmButton: false, timer: 1500});
    }
</script>
</body>
</html>
