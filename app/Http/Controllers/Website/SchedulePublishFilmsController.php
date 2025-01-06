<?php

namespace App\Http\Controllers\Website;

use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Repositories\CinemaRoomChairRepository;
use App\Repositories\FilmRepository;
use App\Repositories\SchedulePublishFilmRepository;
use App\Services\SchedulePublishFilmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SchedulePublishFilmsController extends Controller
{
    protected $filmRepository;
    protected $filmService;
    protected $scheduleRepository;
    protected $chairRepository;

    public function __construct(
        SchedulePublishFilmService $filmService,
        FilmRepository $filmRepository,
        SchedulePublishFilmRepository $scheduleRepository,
        CinemaRoomChairRepository $chairRepository
    )
    {
        $this->filmRepository = $filmRepository;
        $this->filmService = $filmService;
        $this->scheduleRepository = $scheduleRepository;
        $this->chairRepository = $chairRepository;
    }

    // fetch data & show page movies booking
    public function showBookingPage($movieId)
    {
        $schedules = $this->filmService->getDataBookingPage($movieId);
        $film = $this->filmRepository->find($movieId);

        if(!$film){
            throw new NotFoundHttpException();
        }

        return view('website.pages.movie_booking',compact('film','schedules'));
    }

    public function showSeatBookingPage($scheduleId)
    {
        // check current order !== $scheduleId => forget session order
        $this->checkIsAvailableCurrentOrder($scheduleId);

        $schedule = $this->scheduleRepository->find($scheduleId);

        if(!$schedule){
            throw new NotFoundHttpException();
        }
        // group chair type
        $chairs = $schedule->cinemaRoom?->cinemaRoomChairs;
        $chairs = [
            $chairs->slice(0, 20)->values(),  // Collection 0: 20 items đầu
            $chairs->slice(20, 20)->values(), // Collection 1: 20 items tiếp theo
            $chairs->slice(40, 10)->values(), // Collection 2: 10 items
            $chairs->slice(50)->values(),     // Collection 3: Các items còn lại
        ];

        // get totalPriceTicket from current session order
        $totalTicketPrice = 0;
        if(Session::has('order')){
            $order = Session::get('order');
            $totalTicketPrice += $schedule->ticket_price * count($order['cb']);
            $order = Session::get('order');

            foreach($order['cb'] as $chairId){
                $chair = $this->chairRepository->find($chairId);
                $totalTicketPrice += (int)$this->getChairTypePrice($chair->chair_type);
            }
        }
        $chairsBooked = $schedule->ticketOrderItems?->pluck('cinema_room_chair_id')?->toArray() ?? [];

        return view('website.pages.seat_booking', compact('schedule','chairs', 'totalTicketPrice' ,'chairsBooked'));
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

    private function checkIsAvailableCurrentOrder($scheduleId)
    {
        if(Session::has('order')){
            $order = Session::get('order');

            if($scheduleId != $order['schedule_id']){
                Session::forget('order');
            }
        }
    }
}
