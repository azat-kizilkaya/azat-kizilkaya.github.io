<nav style="background:#fff; border-bottom:1px solid #eee; position:sticky; top:0; z-index:1000;">
    <div style="display:flex; justify-content:space-between; align-items:center; padding:15px 50px;">
        <div class="forsy-logo" onclick="location.href='index.php'" style="font-family:'Oswald'; font-size:30px; font-weight:900; cursor:pointer;">
            FORSY <span style="background:#000; color:#fff; padding:0 10px;">GİYİM</span>
        </div>
        <div style="display:flex; gap:30px;">
            <a href="index.php" style="text-decoration:none; color:#000; font-weight:bold; text-transform:uppercase;">KOLEKSİYON</a>
            <a href="kategori.php?k=T-Shirt" style="text-decoration:none; color:#000; font-weight:bold; text-transform:uppercase;">T-SHIRT</a>
            <a href="kategori.php?k=Eşofman Altı" style="text-decoration:none; color:#000; font-weight:bold; text-transform:uppercase;">EŞOFMAN</a>
            <a href="kategori.php?k=Aksesuar" style="text-decoration:none; color:#000; font-weight:bold; text-transform:uppercase;">AKSESUAR</a>
        </div>
        <div style="display:flex; gap:20px; align-items: center; font-size:18px;">
            <?php if(isset($_SESSION['admin_id'])): ?>
                <a href="admin_panel.php" style="color:#E84D35; font-weight:bold; text-decoration:none; font-size:14px; text-transform:uppercase;">ADMİN PANELİ</a>
            <?php endif; ?>

            <?php if(isset($_SESSION['kullanici_id'])): ?>
                <div class="dropdown" style="display:inline-block;">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" style="text-decoration:none; color:#000; font-weight:bold; font-size:14px; text-transform:uppercase;">
                        MERHABA, <?= mb_strtoupper(explode(' ', $_SESSION['ad'])[0]) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end rounded-0 border-dark bg-white mt-2">
                        <li><a class="dropdown-item fw-bold small py-2" href="siparislerim.php">SİPARİŞLERİM</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger fw-bold small py-2" href="logout.php">ÇIKIŞ YAP</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="login.php" style="color:#000;"><i class="fa-regular fa-user"></i></a>
            <?php endif; ?>
            
            <?php 
            $sepet_adet = 0;
            if(isset($_SESSION['sepet'])) {
                foreach($_SESSION['sepet'] as $i) { $sepet_adet += $i['adet']; }
            }
            ?>
            <a href="sepet.php" style="color:#000; position:relative; display:inline-block;">
                <i class="fa-solid fa-bag-shopping"></i>
                <?php if(isset($sepet_adet) && $sepet_adet > 0): ?>
                    <span style="position:absolute; top:-8px; right:-12px; background:#E84D35; color:#fff; border-radius:50%; min-width:18px; height:18px; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:bold; border:1px solid #fff;"><?= $sepet_adet ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</nav>