<?php

namespace App\Http\Controllers\Website;

use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveTicketOrderRequest;
use App\Repositories\CinemaRoomChairRepository;
use App\Repositories\SchedulePublishFilmRepository;
use App\Repositories\TicketOrderItemRepository;
use App\Repositories\TicketOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    protected $scheduleRepository;

    protected $cinemaRoomChairRepository;

    protected $ticketOrderRepository;
    protected $ticketOrderItemRepository;
    public function __construct(
        SchedulePublishFilmRepository $scheduleRepository,
        CinemaRoomChairRepository $cinemaRoomChairRepository,
        TicketOrderRepository $ticketOrderRepository,
        TicketOrderItemRepository $ticketOrderItemRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->cinemaRoomChairRepository = $cinemaRoomChairRepository;
        $this->ticketOrderRepository = $ticketOrderRepository;
        $this->ticketOrderItemRepository = $ticketOrderItemRepository;
    }

    public function showPagePaymentTicket()
    {
        $order = Session::get('order');
        if(empty($order)){
            toastr()->error('Không có vé nào được đặt!');
            return redirect()->route('client.home');
        }

        // get data
        $schedule = $this->scheduleRepository->find($order['schedule_id']);
        $orderDetail = [];

        foreach ($order['cb'] as $chairId)
        {
            if($this->cinemaRoomChairRepository->find($chairId)){
                $orderDetail[] = $this->cinemaRoomChairRepository->find($chairId);
            }
        }

        $ticketString = collect($orderDetail)->map(function ($item) {
            return $item->chair_code."(".$this->getChairTypeText($item->chair_type).")";
        })->implode(',');
        $totalTicket = collect($orderDetail)->pluck('chair_code')->count() ?? 0;
        $sumChairTypePrice = collect($orderDetail)->reduce(function ($carry, $item) {
            return $carry + $this->getChairTypePrice($item->chair_type);
        },0);
        $netPrice = ($schedule->ticket_price * $totalTicket) + $sumChairTypePrice; // ticket_price * total_ticket

        return view('website.pages.payment_ticket', compact('schedule','ticketString','totalTicket','netPrice','sumChairTypePrice'));
    }
    public function saveTicketOrder(SaveTicketOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = Session::get('order');
            if(empty($order) || !auth()->check()){
                return redirect()->route('client.home');
            }
            // save data to table ticket_orders
            $schedule = $this->scheduleRepository->find($order['schedule_id']);
            $ticketOrder = $this->ticketOrderRepository->create([
                'schedule_id' => $order['schedule_id'],
                'user_id' => auth()->id(),
                'grand_total' => $request['grand_total'],
            ]);
            if(!$ticketOrder || !$schedule)
            {
                toastr()->error('Đặt vé thất bại!');
                return redirect()->back();
            }
            // save to ticket_order_items
            foreach ($order['cb'] as $chairId)
            {
                $chair = $this->cinemaRoomChairRepository->find($chairId);
                $this->ticketOrderItemRepository->create([
                    'ticket_order_id' => $ticketOrder->id,
                    'cinema_room_chair_id' => $chairId,
                    'chair_type' => $chair->chair_type,
                    'chair_code' => $chair->chair_code,
                    'chair_type_price' => $this->getChairTypePrice($chair->chair_type),
                    'ticket_item_price' => $schedule->ticket_price + $this->getChairTypePrice($chair->chair_type),
                ]);
            }
            DB::commit();
            // forget session order
            Session::forget('order');
            toastr()->success('Đặt vé thành công!');
            // send flash session to confirm payment page
            return redirect()->route('auth.client.movies.show.confirm-payment')->with([
                'flashDataOrder' => $order,
                'ticketOrder' => $ticketOrder
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            toastr()->error('Đặt vé thất bại!');
            return redirect()->route('client.home');
        }
    }

    public function showPageConfirmPayment()
    {
        try {
            $order = Session::get('flashDataOrder');
            if(empty($order)){
                return redirect()->route('client.home');
            }
            // get data
            $schedule = $this->scheduleRepository->find($order['schedule_id']);
            $orderDetail = [];
            foreach ($order['cb'] as $chairId)
            {
                if($this->cinemaRoomChairRepository->find($chairId)){
                    $orderDetail[] = $this->cinemaRoomChairRepository->find($chairId);
                }
            }
            $ticketString = collect($orderDetail)->map(function ($item) {
                return $item->chair_code."(".$this->getChairTypeText($item->chair_type).")";
            })->implode(',');
            $totalTicket = collect($orderDetail)->pluck('chair_code')->count() ?? 0;
            $sumChairTypePrice = collect($orderDetail)->reduce(function ($carry, $item) {
                return $carry + $this->getChairTypePrice($item->chair_type);
            },0);
            $netPrice = ($schedule->ticket_price * $totalTicket) + $sumChairTypePrice; // ticket_price * total_ticket
            return view('website.pages.confirmation_payment', compact('schedule','ticketString','totalTicket','netPrice'));
        }catch (\Throwable $exception){
            logger($exception->getMessage());
            return redirect()->route('client.home');
        }
    }
    private function getChairTypePrice($code)
    {
        $mapping = [
            0 => Constants::PRICE_CHAIR_TYPE_A,
            1 => Constants::PRICE_CHAIR_TYPE_B,
            2 => Constants::PRICE_CHAIR_TYPE_C,
        ];

        return $mapping[$code] ?? Constants::PRICE_CHAIR_TYPE_D;
    }
    private function getChairTypeText($code)
    {
       
        $mapping = [
            0 => 'A',
            1 => 'B',
            2 => 'C',
        ];
        return $mapping[$code] ?? 'D';
    }
}
