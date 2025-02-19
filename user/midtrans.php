<?php
require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SERVER_KEY';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

// Ambil data dari form yang dikirim melalui method POST
$first_name = $_POST['first_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$order_id = $_POST['order_id'];
$gross_amount = $_POST['gross_amount'];
$id_transaki = $_POST['id_transaksi'];

$params = array(
    'transaction_details' => array(
        'order_id' => $order_id,
        'gross_amount' => $gross_amount,
    ),
    'customer_details' => array(
        'first_name' => $first_name,
        'email' => $email,
        'phone' => $phone,
    ),
);

try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo json_encode(array('token' => $snapToken));
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>
