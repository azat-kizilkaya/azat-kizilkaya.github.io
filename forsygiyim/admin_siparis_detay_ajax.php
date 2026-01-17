<?php
include 'db_config.php';
include 'admin_auth.php';

if (!isset($_GET['id'])) exit('ID Gerekli');

$id = intval($_GET['id']);

// Sipariş Bilgileri
// Düzeltildi: siparis_id -> id
$sorgu = $conn->query("SELECT * FROM tbl_siparisler WHERE id = $id");
$siparis = $sorgu->fetch_assoc();

// Ürünler
$urunler = $conn->query("SELECT p.*, u.ad as urun_adi, u.img_url as ana_resim 
                         FROM tbl_siparis_parcalari p 
                         LEFT JOIN tbl_urunler u ON p.urun_id = u.urun_id 
                         WHERE p.siparis_id = $id");
?>
<div class="row mb-4 border-bottom border-secondary pb-3">
    <div class="col-md-6">
        <h6 class="text-muted">TESLİMAT BİLGİLERİ</h6>
        <!-- Gerçek projede adres tablosu olmadığı için temsili -->
        <p class="mb-0">Kullanıcı ID: <strong><?= $siparis['kullanici_id'] ?></strong></p>
        <p>Sipariş Tarihi: <?= $siparis['tarih'] ?></p>
    </div>
    <div class="col-md-6 text-end">
        <h6 class="text-muted">ÖDEME TOPLAMI</h6>
        <h3 class="text-success"><?= number_format($siparis['toplam_tutar'], 2) ?> TL</h3>
    </div>
</div>

<h6 class="text-muted mb-3">SEPET İÇERİĞİ</h6>
<table class="table table-dark table-sm table-striped">
    <thead>
        <tr>
            <th>Ürün</th>
            <th>Varyasyon</th>
            <th>Adet</th>
            <th>Fiyat</th>
            <th>Tutar</th>
        </tr>
    </thead>
    <tbody>
        <?php while($u = $urunler->fetch_assoc()): ?>
        <tr>
            <td>
                <?php if($u['ana_resim']): ?>
                <img src="gorseller/<?= $u['ana_resim'] ?>" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                <?php endif; ?>
                <?= $u['urun_adi'] ?>
            </td>
            <td><?= $u['renk'] ?> / <?= $u['beden'] ?></td>
            <td><?= $u['adet'] ?></td>
            <td><?= number_format($u['fiyat'], 2) ?></td>
            <td><?= number_format($u['fiyat'] * $u['adet'], 2) ?> TL</td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<form method="POST" action="admin_siparisler.php" class="mt-4 p-3 bg-black border border-secondary">
    <label class="mb-2 text-warning fw-bold">SİPARİŞ DURUMU GÜNCELLE</label>
    <div class="input-group">
        <input type="hidden" name="siparis_id" value="<?= $id ?>">
        <select name="yeni_durum" class="form-select bg-dark text-white rounded-0">
            <option value="Hazırlanıyor" <?= $siparis['durum']=='Hazırlanıyor'?'selected':'' ?>>Hazırlanıyor</option>
            <option value="Kargolandı" <?= $siparis['durum']=='Kargolandı'?'selected':'' ?>>Kargolandı</option>
            <option value="Teslim Edildi" <?= $siparis['durum']=='Teslim Edildi'?'selected':'' ?>>Teslim Edildi</option>
            <option value="İptal Edildi" <?= $siparis['durum']=='İptal Edildi'?'selected':'' ?>>İptal Edildi</option>
        </select>
        <button type="submit" name="durum_guncelle" class="btn btn-outline-warning rounded-0">GÜNCELLE</button>
    </div>
</form>
