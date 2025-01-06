<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\CinemaRoomChairCreateRequest;
use App\Http\Requests\CinemaRoomChairUpdateRequest;
use App\Repositories\CinemaRoomChairRepository;
use App\Repositories\CinemaRoomRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CinemaRoomChairsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CinemaRoomChairsController extends Controller
{
    /**
     * @var CinemaRoomChairRepository
     */
    protected $repository;

    protected $cinemaRoomRepository;

    /**
     * CinemaRoomChairsController constructor.
     *
     * @param CinemaRoomChairRepository $repository
     */
    public function __construct(
        CinemaRoomChairRepository $repository,
        CinemaRoomRepository $cinemaRoomRepository
    )
    {
        $this->repository = $repository;
        $this->cinemaRoomRepository = $cinemaRoomRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($roomId)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $cinemaRoomChairs = $this->repository->getChairsByRoomId($roomId);
        $cinemaRoomChairs = [
            $cinemaRoomChairs->slice(0, 20)->values(),  // Collection 0: 20 items đầu
            $cinemaRoomChairs->slice(20, 20)->values(), // Collection 1: 20 items tiếp theo
            $cinemaRoomChairs->slice(40, 10)->values(), // Collection 2: 10 items
            $cinemaRoomChairs->slice(50)->values(),     // Collection 3: Các items còn lại
        ];
        $cinemaRoom = $this->cinemaRoomRepository->getCinemaRoomWithCinemaById($roomId);
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $cinemaRoomChairs,
            ]);
        }

        return view('backend.cinemaRoomChairs.index', compact('cinemaRoomChairs','cinemaRoom'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CinemaRoomChairCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CinemaRoomChairCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $cinemaRoomChair = $this->repository->create($request->all());

            $response = [
                'message' => 'CinemaRoomChair created.',
                'data'    => $cinemaRoomChair->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
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
        $cinemaRoomChair = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $cinemaRoomChair,
            ]);
        }

        return view('cinemaRoomChairs.show', compact('cinemaRoomChair'));
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
        $cinemaRoomChair = $this->repository->find($id);

        return view('cinemaRoomChairs.edit', compact('cinemaRoomChair'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CinemaRoomChairUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CinemaRoomChairUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $cinemaRoomChair = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CinemaRoomChair updated.',
                'data'    => $cinemaRoomChair->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

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
                'message' => 'CinemaRoomChair deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CinemaRoomChair deleted.');
    }
}
