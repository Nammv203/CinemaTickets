<?php

namespace App\Http\Controllers\Admin;

use App\Events\CinemaCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\CinemaCreateRequest;
use App\Http\Requests\CinemaUpdateRequest;
use App\Repositories\CinemaRepository;
use App\Repositories\LocationDistrictRepository;
use App\Repositories\LocationProvinceRepository;
use App\Validators\CinemaValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CinemasController.
 *
 * @package namespace App\Http\Controllers;
 */
class CinemasController extends Controller
{
    /**
     * @var CinemaRepository
     */
    protected $repository;

    /**
     * @var CinemaValidator
     */
    protected $validator;

    /**
     * CinemasController constructor.
     *
     * @param CinemaRepository $repository
     * @param CinemaValidator $validator
     */

    protected $provinceRepository;
    protected $districtRepository;

    public function __construct(
        CinemaRepository $repository,
        CinemaValidator $validator,
        LocationProvinceRepository $provinceRepository,
        LocationDistrictRepository $districtRepository,
    )
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $cinemas = $this->repository->getList($request);

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $cinemas,
            ]);
        }

        return view('backend.cinemas.index', compact('cinemas'));
    }

    public function create(){

        $provinces = $this->provinceRepository->with('location_districts')->all();

        return view('backend.cinemas.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CinemaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CinemaCreateRequest $request)
    {

        DB::beginTransaction();
        try {
            $data = $request->all();
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $picture = $request->file('picture');
            $filePath = $picture->store('cinema', 'public');
            $fileName = basename($filePath);

            $data['picture'] = $fileName;

            $cinema = $this->repository->create($data);

            $response = [
                'message' => 'Cinema created.',
                'data'    => $cinema->toArray(),
            ];

            // dispatch event
            event(new CinemaCreatedEvent($cinema));

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            DB::commit();
            toastr()->success('Thêm rạp phim thành công');

            return redirect()->route('admin.cinema.index');
            } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                DB::rollBack();
                Log::error($e->getMessage());

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            toastr()->error('Lỗi! Hãy liên hệ người quản lý');
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
        $cinema = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $cinema,
            ]);
        }

        return view('cinemas.show', compact('cinema'));

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
        $cinema = $this->repository->with(['location_district', 'location_province'])->find($id);

        $provinces = $this->provinceRepository->with('location_districts')->all();

        $districtWithCinema = $this->provinceRepository->with('location_districts')->findByField('id', $cinema->location_district->province_id);

        return view('backend.cinemas.edit', compact('cinema', 'provinces', 'districtWithCinema'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CinemaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CinemaUpdateRequest $request, $id)
    {

        DB::beginTransaction();
        try {
            $data = $request->all();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            if ($request->hasFile('picture')) {
                $picture = $request->file('picture');
                $cinema = $this->repository->find($id);

                // delete img saved in storage
                $checkFileIsset = Storage::exists(config('filesystems.folder_storage_admin.cinema') . $cinema->picture);
                if ($checkFileIsset) {
                    Storage::delete(config('filesystems.folder_storage_admin.cinema') . $cinema->picture);
                }

                // save new img
                $filePath = $picture->store('cinema', 'public');
                $fileName = basename($filePath);
                $data['picture'] = $fileName;
            }

            $cinema = $this->repository->update($data, $id);

            $response = [
                'message' => 'Cinema updated.',
                'data'    => $cinema->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            DB::commit();
            toastr()->success('Cập nhật rạp phim thành công');


            return redirect()->route('admin.cinema.index');
        } catch (ValidatorException $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }


            toastr()->error('Lỗi! Hãy liên hệ admin');
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

        $cinema = $this->repository->find($id);

        $checkFileIsset = Storage::exists(config('filesystems.folder_storage_admin.cinema') . $cinema->picture);
        if ($checkFileIsset) {
            Storage::delete(config('filesystems.folder_storage_admin.cinema') . $cinema->picture);
        }

        $deleted = $cinema->delete();

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Cinema deleted.',
                'deleted' => $deleted,
            ]);
        }

        toastr()->success('Xóa rạp phim thành công');

        return redirect()->back()->with('message', 'Cinema deleted.');    }

  
        public function getDistrictWithProvince($id){
        $data = $this->provinceRepository->with('location_districts')->find($id);

        return response()->json($data);
    }
}
