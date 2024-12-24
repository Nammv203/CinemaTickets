<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Repositories\TicketOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VnPayController extends Controller
{
    protected $ticketOrderRepository;
    public function __construct(
        TicketOrderRepository $ticketOrderRepository
    )
    {
        $this->ticketOrderRepository = $ticketOrderRepository;
    }

    public function vnpayReturn(Request $request)
    {
        try {
            $vnp_SecureHash = $request->vnp_SecureHash;
            $inputData = $request->all();
            $orderId = $request->route('order_id');
            $order = $this->ticketOrderRepository->find($orderId);

            if(!$order){
                return redirect()->route('client.home');
            }

            $ticketString = $order->ticketOrderItems?->map(function ($item) {
                return $item->chair_code."(".getChairTypeText($item->chair_type).")";
            })->implode(',');

            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $hashData = "";
            foreach ($inputData as $key => $value) {
                $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
            }
            $hashData = rtrim($hashData, '&');

            $secureHash = hash_hmac('sha512', $hashData, config('vnpay.vnp_HashSecret'));

            // check redirect homepage
            if (session()->has('payment_viewed')) {
                // Nếu đã xem page này, redirect về trang chủ
                return redirect()->route('client.home');
            }

            // Đánh dấu là đã xem trang success
            session(['payment_viewed' => true]);

//            if ($secureHash === $vnp_SecureHash) {
                if ($request->vnp_ResponseCode == '00') {
                    // Thanh toán thành công

                    // update status order to payment success
                    $order->status = 1;
                    $order->save();

                    toastr()->success('Đặt vé thành công!');
                    return view('website.pages.confirmation_payment', compact('order','ticketString'));
                } else {
                    // Thanh toán không thành công
                    return view('errors.payment_failed');
                }
//            } else {
//                // Dữ liệu không hợp lệ
//                return view('errors.404');
//            }
        }catch (\Throwable $th) {
            Log::error($th->getMessage());
            return view('errors.404');
        }
    }
}