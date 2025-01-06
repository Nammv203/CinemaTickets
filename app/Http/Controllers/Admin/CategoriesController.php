<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Repositories\CategoryRepository;
use App\Validators\CategoryValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CategoriesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @var CategoryValidator
     */
    protected $validator;

    /**
     * CategoriesController constructor.
     *
     * @param CategoryRepository $repository
     * @param CategoryValidator $validator
     */
    public function __construct(CategoryRepository $repository, CategoryValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $categories = $this->repository->getList($request);


        if (request()->wantsJson()) {

            return response()->json([
                'data' => $categories,
            ]);
        }

        return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CategoryCreateRequest $request)
    {
        try {
            $data = $request->all();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $picture = $request->file('picture');
            $filePath = $picture->store('category', 'public');
            $fileName = basename($filePath);

            $data['picture'] = $fileName;
            $category = $this->repository->create($data);

            $response = [
                'message' => 'Category created.',
                'data'    => $category->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            toastr()->success('Thêm loại phim thành công');
            return redirect()->route('admin.category.index');
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
        $category = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $category,
            ]);
        }

        return view('backend.categories.index');
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
        $category = $this->repository->find($id);

        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            if ($request->hasFile('picture')) {
                $picture = $request->file('picture');
                $category = $this->repository->find($id);

                // delete img saved in storage
                $checkFileIsset = Storage::exists(config('filesystems.folder_storage_admin.category') . $category->picture);
                if ($checkFileIsset) {
                    Storage::delete(config('filesystems.folder_storage_admin.category') . $category->picture);
                }

                // save new img
                $filePath = $picture->store('category', 'public');
                $fileName = basename($filePath);
                $data['picture'] = $fileName;
            }

            // update
            $category = $this->repository->update($data, $id);

            $response = [
                'message' => 'Category updated.',
                'data'    => $category->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            DB::commit();
            toastr()->success('Cập nhật loại phim thành công');
            return redirect()->route('admin.category.index');
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
        $category = $this->repository->find($id);

        $checkFileIsset = Storage::exists(config('filesystems.folder_storage_admin.category') . $category->picture);
        if ($checkFileIsset) {
            Storage::delete(config('filesystems.folder_storage_admin.category') . $category->picture);
        }

        $deleted = $category->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Category deleted.',
                'deleted' => $deleted,
            ]);
        }
        toastr()->success('Xóa loại phim thành công');

        return redirect()->back();
    }
}
