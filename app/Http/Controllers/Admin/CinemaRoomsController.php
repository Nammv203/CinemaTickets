<?php

namespace App\Http\Controllers\Admin;

use App\Events\CinemaRoomCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\CinemaRoomCreateRequest;
use App\Http\Requests\CinemaRoomUpdateRequest;
use App\Listeners\CinemaRoomCreatedListener;
use App\Repositories\CinemaRepository;
use App\Repositories\CinemaRoomRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CinemaRoomsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CinemaRoomsController extends Controller
{
    /**
     * @var CinemaRoomRepository
     */
    protected $repository;

    protected $cinemaRepository;


    /**
     * CinemaRoomsController constructor.
     *
     * @param CinemaRoomRepository $repository
     */
    public function __construct(
        CinemaRoomRepository $repository,
        CinemaRepository     $cinemaRepository
    )
    {
        $this->repository = $repository;
        $this->cinemaRepository = $cinemaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $cinema_id = null)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $cinemaRooms = $this->repository
            ->orderBy('id', 'desc')
            ->paginate(request('limit',10));
        $cinema = null;
        if ($cinema_id) {
            $cinemaRooms = $this->repository->getListByCinemaId($request, $cinema_id);
            $cinema = $this->cinemaRepository->find($cinema_id);
        }
        $cinemas = $this->cinemaRepository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $cinemaRooms,
            ]);
        }

        return view('backend.cinemaRooms.index', compact('cinemaRooms', 'cinemas', 'cinema'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CinemaRoomCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CinemaRoomCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $cinemaRoom = $this->repository->create($request->all());

            $response = [
                'message' => 'CinemaRoom created.',
                'data' => $cinemaRoom->toArray(),
            ];

            // dispatch event created
            event(new CinemaRoomCreatedEvent($cinemaRoom));

            DB::commit();

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            toastr()->success('Tạo thành công.');
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cinemaRoom = $this->repository->find($id);
        $cinemas = $this->cinemaRepository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $cinemaRoom,
            ]);
        }

        return view('backend.cinemaRooms.edit', compact('cinemaRoom', 'cinemas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cinemaRoom = $this->repository->find($id);

        return view('cinemaRooms.edit', compact('cinemaRoom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CinemaRoomUpdateRequest $request
     * @param string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CinemaRoomUpdateRequest $request, $id)
    {
        try {

            $cinemaRoom = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CinemaRoom updated.',
                'data' => $cinemaRoom->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            toastr()->success('Cập nhật thành công!');
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'CinemaRoom deleted.',
                'deleted' => $deleted,
            ]);
        }

        toastr()->success('Xóa thành công!');
        return redirect()->back()->with('message', 'CinemaRoom deleted.');
    }
}
