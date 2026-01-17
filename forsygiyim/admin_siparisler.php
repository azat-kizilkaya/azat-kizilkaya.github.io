<?php
include 'db_config.php';
include 'admin_auth.php';

// Sipariş Durumu Güncelleme
if (isset($_POST['durum_guncelle'])) {
    $siparis_id = $_POST['siparis_id'];
    $yb_durum = $_POST['yeni_durum'];
    // Düzeltildi: siparis_id -> id
    $stmt = $conn->prepare("UPDATE tbl_siparisler SET durum = ? WHERE id = ?");
    $stmt->bind_param("si", $yb_durum, $siparis_id);
    $stmt->execute();
    $mesaj = "Sipariş #$siparis_id durumu güncellendi: $yb_durum";
}

// Tüm Siparişleri Çek
// Düzeltildi: siparis_tarihi -> tarih
$sql = "SELECT s.*, k.ad as kullanici_ad, k.eposta FROM tbl_siparisler s 
        LEFT JOIN tbl_kullanicilar k ON s.kullanici_id = k.kullanici_id 
        ORDER BY s.tarih DESC";
$resresult = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>SİPARİŞLER - FORSY PANEL</title>
    <!-- Bootstrap 5 Dark Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --accent: #E84D35; --bg: #000; --panel: #111; --text: #eee; --border: #222; }
        body { background-color: var(--bg); color: var(--text); font-family: 'Roboto', sans-serif; }
        h1, h2, h3, h4, th { font-family: 'Oswald', sans-serif; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Sidebar (Admin Panel ile Uyumlu Olacak Şekilde Harici CSS'e Alınabilir) */
        .sidebar { width: 260px; height: 100vh; position: fixed; background: var(--panel); border-right: 1px solid var(--border); padding-top: 20px; }
        .sidebar-brand { font-size: 24px; text-align: center; color: #fff; margin-bottom: 40px; }
        .sidebar-link { display: block; padding: 15px 30px; color: #888; text-decoration: none; transition: 0.3s; font-weight: 500; font-size: 14px; text-transform: uppercase; }
        .sidebar-link:hover, .sidebar-link.active { background: var(--bg); color: var(--accent); border-left: 4px solid var(--accent); }
        .sidebar-link i { width: 25px; }

        .content { margin-left: 260px; padding: 40px; }

        /* Tablo Tasarımı */
        .table-dark-custom { background: var(--panel); border: 1px solid var(--border); color: #ccc; }
        .table-dark-custom th { background: #050505; color: var(--accent); border-bottom: 2px solid var(--accent); padding: 15px; }
        .table-dark-custom td { border-bottom: 1px solid var(--border); padding: 15px; vertical-align: middle; }
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { color: #888 !important; margin-bottom: 20px; }
        .page-item.active .page-link { background-color: var(--accent); border-color: var(--accent); }
        
        /* Badge */
        .badge-status { padding: 5px 10px; font-size: 11px; letter-spacing: 1px; }
        .bg-hazirlaniyor { background: #ffc107; color: #000; }
        .bg-kargolandı { background: #0dcaf0; color: #000; }
        .bg-teslim { background: #198754; color: #fff; }
        .bg-iptal { background: #dc3545; color: #fff; }

        /* Modal */
        .modal-content { background: var(--panel); border: 1px solid var(--border); color: #fff; }
        .modal-header { border-bottom: 1px solid var(--border); }
        .modal-footer { border-top: 1px solid var(--border); }
        .btn-close { filter: invert(1); }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">FORSY <span style="color:var(--accent)">ADMIN</span></div>
    <a href="admin_panel.php" class="sidebar-link"><i class="fa fa-chart-line"></i> Dashboard</a>
    <a href="admin_urunler.php" class="sidebar-link"><i class="fa fa-box"></i> Ürünler</a>
    <a href="admin_siparisler.php" class="sidebar-link active"><i class="fa fa-shopping-bag"></i> Siparişler</a>
    <a href="admin_uyeler.php" class="sidebar-link"><i class="fa fa-users"></i> Üyeler</a>
    <a href="admin_kuponlar.php" class="sidebar-link"><i class="fa fa-ticket-alt"></i> Kuponlar</a>
    <a href="logout.php" class="sidebar-link mt-5"><i class="fa fa-sign-out-alt"></i> Çıkış</a>
</div>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sipariş Yönetimi</h2>
        <div class="text-secondary small">TOPLAM <?= $resresult->num_rows ?> SİPARİŞ</div>
    </div>

    <?php if(isset($mesaj)): ?>
        <div class="alert alert-success bg-gradient border-0 text-white mb-4"><i class="fa fa-check-circle me-2"></i> <?= $mesaj ?></div>
    <?php endif; ?>

    <div class="card bg-dark border-0 shadow-lg p-3">
        <table id="orderTable" class="table table-dark-custom table-hover w-100">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Müşteri</th>
                    <th>Tutar</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $resresult->fetch_assoc()): ?>
                <tr>
                    <td>#<?= $row['id'] ?></td>
                    <td>
                        <div class="fw-bold"><?= $row['kullanici_ad'] ?></div>
                        <div class="small text-muted"><?= $row['eposta'] ?></div>
                    </td>
                    <td class="fw-bold text-success"><?= number_format($row['toplam_tutar'], 2) ?> ₺</td>
                    <td><?= date('d.m.Y H:i', strtotime($row['tarih'])) ?></td>
                    <td>
                        <?php 
                        $badgeClass = 'bg-secondary';
                        if($row['durum'] == 'Hazırlanıyor') $badgeClass = 'bg-hazirlaniyor';
                        elseif($row['durum'] == 'Kargolandı') $badgeClass = 'bg-kargolandı';
                        elseif($row['durum'] == 'Teslim Edildi') $badgeClass = 'bg-teslim';
                        ?>
                        <span class="badge border rounded-0 <?= $badgeClass ?>"><?= mb_strtoupper($row['durum']) ?></span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-light rounded-0" onclick="openDetail(<?= $row['id'] ?>)">
                            <i class="fa fa-eye"></i> Detay
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SİPARİŞ DETAYI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <div class="text-center py-5"><div class="spinner-border text-danger"></div></div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#orderTable').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/tr.json" },
            order: [[ 0, "desc" ]]
        });
    });

    function openDetail(id) {
        var modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
        
        // AJAX ile detay çekme simülasyonu (Normalde ayrı bir php dosyasına istek atılır,
        // burada pratiklik için JS ile HTML oluşturmuyorum, AJAX yapacağım)
        $('#modalContent').load('admin_siparis_detay_ajax.php?id=' + id);
    }
</script>
</body>
</html>
