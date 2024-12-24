<?php

namespace App\Services;

use App\Models\Film;
use App\Models\SchedulePublishFilm;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;

class SchedulePublishFilmService
{

    public function getDataBookingPage($movieId)
    {
        // get list schedules <= 15 next days
        $after7days = Carbon::now()->addDays(15)->format('Y-m-d');
        $currentDays = Carbon::now()->format('Y-m-d');
        $schedules = SchedulePublishFilm::with(['cinemaRoom' => function ($query) {
            $query->select('id', 'room_code','cinema_id')
                ->with(['cinema'])
                ->get();
        }])
            ->where('film_id', $movieId)
            ->where('show_date','<=', $after7days)
            ->where('show_date','>=', $currentDays)
            ->where('status', 1)
            ->orderBy('show_date','asc')
            ->get();

//        $data = [];
        // format data theo date
//        foreach ($schedules as $schedule) {
//            $data[$schedule->show_date][] = $schedule;
//        }
        $data = $schedules->groupBy('show_date');

        // format show_date > cinema > show_time
        $result = collect($data)->map(function ($schedules) {
            return collect($schedules)->groupBy(function ($schedule) {
                return $schedule['cinemaRoom']['cinema']['name']; // Group by cinema name
            })->map(function ($cinemaSchedules) {
                return $cinemaSchedules->groupBy('show_time'); // Group by show_time
            });
        });
//dd($result);
        return $result ?? [];
    }
}
