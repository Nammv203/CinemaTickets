<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\FilmReviewCreateRequest;
use App\Http\Requests\FilmReviewUpdateRequest;
use App\Repositories\FilmRepository;
use App\Repositories\FilmReviewRepository;
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
class FilmReviewController extends Controller
{
    protected $repository;
    protected $filmRepository;

    public function __construct(
        FilmReviewRepository $repository,
        FilmRepository $filmRepository
    ) {
        $this->repository = $repository;
        $this->filmRepository = $filmRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $filmReviews = $this->repository->getList($request);
        $films = $this->filmRepository->all();

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $filmReviews,
            ]);
        }

        return view('backend.filmReviews.index', compact('filmReviews', 'films'));
    }

    public function create()
    {
        $films = $this->filmRepository->all();

        return view('backend.filmReviews.create', compact('films'));
    }

    public function store(FilmReviewCreateRequest $request)
    {
        try {
            // $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $filmReview = $this->repository->create($request->all());

            $response = [
                'message' => 'filmReview created.',
                'data'    => $filmReview->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            toastr()->success('Thêm đánh giá phim thành công');
            return redirect()->route('admin.film-reviews.index');
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
        // $category = $this->repository->find($id);

        // if (request()->wantsJson()) {

        //     return response()->json([
        //         'data' => $category,
        //     ]);
        // }

        // return view('backend.categories.index');
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
        $filmReview = $this->repository->find($id);
        $films = $this->filmRepository->all();

        return view('backend.filmReviews.edit', compact('filmReview', 'films'));
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
    public function update(FilmReviewUpdateRequest $request, $id)
    {
        try {
            // $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $filmReview = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Category updated.',
                'data'    => $filmReview->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            toastr()->success('Cập nhật đánh giá phim thành công');
            return redirect()->route('admin.film-reviews.index');
        } catch (ValidatorException $e) {
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
        $filmReview = $this->repository->find($id);
        $deleted = $filmReview->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Category deleted.',
                'deleted' => $deleted,
            ]);
        }
        toastr()->success('Xóa đánh giá phim thành công');

        return redirect()->back();
    }
}