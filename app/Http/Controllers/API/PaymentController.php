<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
{
    try {
        $order = $request->order_id;
        $subtotal = $request->subtotal;
        $bank_code = $request->bank_code;
        $vnp_TmnCode = "VNA6LDMI"; // Mã website tại VNPAY
        $vnp_HashSecret = "IYGRVEUICTOQLKPPLPBKGIZARQXMXIHL"; // Chuỗi bí mật

        $vnp_TxnRef = $order;
        $vnp_OrderInfo = "Pay bills";
        $vnp_OrderType = "Hello Wolrd Dry Fruits";
        $vnp_Amount = $subtotal * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode = $bank_code;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $vnp_Url = $this->generateVnpayUrl($vnp_TmnCode, $vnp_Amount, $vnp_TxnRef, $vnp_OrderInfo, $vnp_OrderType, $vnp_Locale, $vnp_BankCode, $vnp_IpAddr, $vnp_HashSecret);

        $returnData = [
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        ];

        return response()->json($returnData);
    } catch (\Exception $e) {
        // Xử lý ngoại lệ theo cách phù hợp
        return response()->json(['code' => '01', 'message' => 'error', 'data' => null]);
    }
}

private function generateVnpayUrl($vnp_TmnCode, $vnp_Amount, $vnp_TxnRef, $vnp_OrderInfo, $vnp_OrderType, $vnp_Locale, $vnp_BankCode, $vnp_IpAddr, $vnp_HashSecret)
{
    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => '1 duong dan co name = redirect', // Giả sử bạn có một tuyến đường có tên là 'vnpay_return' cho URL trả về
        "vnp_TxnRef" => $vnp_TxnRef
    ];

    if (!empty($vnp_BankCode)) {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

    ksort($inputData);
    $hashData = "";
    foreach ($inputData as $key => $value) {
        $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnpSecureHash = hash_hmac('sha512', rtrim($hashData, '&'), $vnp_HashSecret);
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?" . $hashData . 'vnp_SecureHash=' . $vnpSecureHash;

    return $vnp_Url;
}

}
