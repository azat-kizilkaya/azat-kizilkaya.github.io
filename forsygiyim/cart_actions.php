<?php
session_start();
include 'db_config.php';
include 'Security.php';

header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Geçersiz işlem'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    // Sepet Güncelleme
    if ($action == 'update_qty') {
        $key = $_POST['key'] ?? null;
        $qty = intval($_POST['qty']);

        if ($key !== null && isset($_SESSION['sepet'][$key])) {
            if ($qty > 0) {
                $_SESSION['sepet'][$key]['adet'] = $qty;
                $response = ['status' => 'success', 'message' => 'Adet güncellendi'];
            } else {
                 $response = ['status' => 'error', 'message' => 'Adet en az 1 olabilir'];
            }
        }
    } 
    // Ürün Silme
    elseif ($action == 'remove') {
        $key = $_POST['key'] ?? null;
        if ($key !== null && isset($_SESSION['sepet'][$key])) {
            unset($_SESSION['sepet'][$key]);
            
            // Eğer sepet boşaldıysa kuponu da sil
            if(empty($_SESSION['sepet'])) {
                unset($_SESSION['indirim_orani'], $_SESSION['kupon_kodu']);
            }
            
            $response = ['status' => 'success', 'message' => 'Ürün sepetten kaldırıldı'];
        }
    }
    // Kupon Uygulama
    elseif ($action == 'apply_coupon') {
        $kod = trim($_POST['code'] ?? '');
        
        $sql = "SELECT indirim_orani FROM tbl_kuponlar WHERE kod = ? AND aktif = TRUE AND (gecerlilik_tarihi IS NULL OR gecerlilik_tarihi >= CURDATE())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $kod);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($kupon = $res->fetch_assoc()) {
            $_SESSION['indirim_orani'] = $kupon['indirim_orani'];
            $_SESSION['kupon_kodu'] = $kod;
            $response = [
                'status' => 'success', 
                'message' => "Kupon uygulandı! %{$kupon['indirim_orani']} indirim.",
                'discount_rate' => $kupon['indirim_orani']
            ];
        } else {
            unset($_SESSION['indirim_orani'], $_SESSION['kupon_kodu']);
            $response = ['status' => 'error', 'message' => 'Geçersiz veya süresi dolmuş kupon.'];
        }
    }
    
    // Toplamları Hesapla ve Döndür
    $ara_toplam = 0;
    $item_count = 0;
    if(isset($_SESSION['sepet'])) {
        foreach($_SESSION['sepet'] as $item) {
            $ara_toplam += ($item['fiyat'] * $item['adet']);
            $item_count += $item['adet'];
        }
    }

    $kampanya_limit = 2000;
    $sablon_indirim = ($ara_toplam >= $kampanya_limit) ? 300 : 0;
    $indirim_orani = $_SESSION['indirim_orani'] ?? 0;
    $kupon_indirim = $ara_toplam * ($indirim_orani / 100);
    $genel_toplam = $ara_toplam - ($sablon_indirim + $kupon_indirim);
    
    $response['data'] = [
        'subtotal' => number_format($ara_toplam, 2),
        'total' => number_format($genel_toplam, 2),
        'coupon_discount' => number_format($kupon_indirim, 2),
        'campaign_discount' => number_format($sablon_indirim, 2),
        'total_items' => $item_count,
        'has_campaign' => ($sablon_indirim > 0),
        'progress_percent' => min(($ara_toplam / $kampanya_limit) * 100, 100)
    ];
}

echo json_encode($response);
?>
