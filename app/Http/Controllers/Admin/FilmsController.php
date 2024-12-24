<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\FilmCreateRequest;
use App\Http\Requests\FilmUpdateRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\FilmRepository;
use App\Validators\FilmValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class FilmsController.
 *
 * @package namespace App\Http\Controllers;
 */
class FilmsController extends Controller
{
    /**
     * @var FilmRepository
     */
    protected $repository;
    protected $categoryRepository;

    /**
     * @var FilmValidator
     */
    protected $validator;

    /**
     * FilmsController constructor.
     *
     * @param FilmRepository $repository
     * @param FilmValidator $validator
     */
    public function __construct(
        FilmRepository $repository,
        FilmValidator $validator,
        CategoryRepository $categoryRepository
    ) {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $films = $this->repository->getList($request);
        $categories = $this->categoryRepository->all();

        if (request()->wantsJson()) {
            return response()->json([
                'films' => $films,
            ]);
        }

        return view('backend.films.index', compact('films','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FilmCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();

        return view('backend.films.create', compact('categories'));
    }

    public function store(FilmCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $picture = $request->file('picture');
            $filePath = $picture->store('film', 'public');
            $fileName = basename($filePath);

            $data['picture'] = $fileName;

            $film = $this->repository->create($data);

            $response = [
                'message' => 'Film created.',
                'data'    => $film->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            DB::commit();
            toastr()->success('Thêm phim thành công');
            return redirect()->route('admin.film.index');
        } catch (ValidatorException $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            if ($request->wantsJson()) {
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
        $film = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $film,
            ]);
        }

        return view('films.show', compact('film'));
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
        $film = $this->repository->with('category')->find($id);
        $categories = $this->categoryRepository->all();

        return view('backend.films.edit', compact('film', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FilmUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FilmUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            if ($request->hasFile('picture')) {
                $picture = $request->file('picture');
                $film = $this->repository->find($id);

                // delete img saved in storage
                $checkFileIsset = Storage::exists(config('filesystems.folder_storage_admin.film') . $film->picture);
                if ($checkFileIsset) {
                    Storage::delete(config('filesystems.folder_storage_admin.film') . $film->picture);
                }

                // save new img
                $filePath = $picture->store('film', 'public');
                $fileName = basename($filePath);
                $data['picture'] = $fileName;
            }

            $film = $this->repository->update($data, $id);

            $response = [
                'message' => 'Film updated.',
                'data'    => $film->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            DB::commit();
            toastr()->success('Cập nhật phim thành công');

            return redirect()->route('admin.film.index');
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
        $film = $this->repository->find($id);

        $checkFileIsset = Storage::exists(config('filesystems.folder_storage_admin.film') . $film->picture);
        if ($checkFileIsset) {
            Storage::delete(config('filesystems.folder_storage_admin.film') . $film->picture);
        }

        $deleted = $film->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Film deleted.',
                'deleted' => $deleted,
            ]);
        }

        toastr()->success('Xóa phim thành công');

        return redirect()->back()->with('message', 'Film deleted.');
    }
}
