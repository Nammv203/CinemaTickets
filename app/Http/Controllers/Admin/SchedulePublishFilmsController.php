<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\SchedulePublishFilmCreateRequest;
use App\Http\Requests\SchedulePublishFilmUpdateRequest;
use App\Models\Cinema;
use App\Models\CinemaRoom;
use App\Models\Film;
use App\Repositories\SchedulePublishFilmRepository;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class SchedulePublishFilmsController.
 *
 * @package namespace App\Http\Controllers;
 */
class SchedulePublishFilmsController extends Controller
{
    /**
     * @var SchedulePublishFilmRepository
     */
    protected $repository;

    /**
     * SchedulePublishFilmsController constructor.
     *
     * @param SchedulePublishFilmRepository $repository
     */
    public function __construct(SchedulePublishFilmRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $schedulePublishFilms = $this->repository
            ->when($request->cinema_id, function ($query) use ($request) {
                $query->whereHas('cinemaRoom', function ($query) use ($request) {
                    $query->where('cinema_id', $request->cinema_id);
                });
            })
            ->when($request->cinema_room_id, function ($query) use ($request) {
                $query->where('cinema_room_id', $request->cinema_room_id);
            })
            ->orderBy('id','desc')
            ->paginate(20);
        $cinemas = Cinema::all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $schedulePublishFilms,
            ]);
        }

        return view('backend.schedulePublishFilms.index', compact('schedulePublishFilms','cinemas'));
    }

    public function create()
    {
        $films = Film::all();
        $cinemas = Cinema::all();
        $cinemaRooms = CinemaRoom::all();

        return view('backend.schedulePublishFilms.create', compact('films','cinemas','cinemaRooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SchedulePublishFilmCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(SchedulePublishFilmCreateRequest $request)
    {
        try {

            $schedulePublishFilm = $this->repository->create($request->all());

            $response = [
                'message' => 'SchedulePublishFilm created.',
                'data'    => $schedulePublishFilm->toArray(),
            ];
            toastr()->success('Tạo thành công.');
            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->route('admin.schedule.index');
        } catch (ValidatorException $e) {
            toastr()->error('Tạo thất bại.');
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedulePublishFilm = $this->repository->find($id);
        $films = Film::all();
        $cinemas = Cinema::all();
        $cinemaRooms = CinemaRoom::all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $schedulePublishFilm,
            ]);
        }

        return view('backend.schedulePublishFilms.edit', compact('schedulePublishFilm','films','cinemas','cinemaRooms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedulePublishFilm = $this->repository->find($id);

        return view('schedulePublishFilms.edit', compact('schedulePublishFilm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SchedulePublishFilmUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(SchedulePublishFilmUpdateRequest $request, $id)
    {
        try {

            $schedulePublishFilm = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'SchedulePublishFilm updated.',
                'data'    => $schedulePublishFilm->toArray(),
            ];
            toastr()->success('Cập nhật thành công.');
            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            toastr()->error('Cập nhật thất bại.');
            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'SchedulePublishFilm deleted.',
                'deleted' => $deleted,
            ]);
        }

        toastr()->success('Xóa thành công.');

        return redirect()->back()->with('message', 'SchedulePublishFilm deleted.');
    }
}
