<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Repositories\CategoryRepository;
use App\Repositories\FilmRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoriesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CategoriesController extends Controller
{
    protected $categoryRepository;
    protected $filmRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        FilmRepository $filmRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->filmRepository = $filmRepository;
    }

    public function index(Request $request)
    {
        // search & filter
        $keywordSearch = $request->get('keyword');
        $filterCategoryId = $request->get('category_id');

        $countAllFilm = $this->filmRepository->count();
        $list_category = $this->categoryRepository->withCount(['films'])->all();
        $list_film = Film::when($filterCategoryId, function ($q) use ($filterCategoryId) {
                            $q->where('category_id', $filterCategoryId);
                        })
                        ->when($keywordSearch, function ($q) use ($keywordSearch) {
                            $q->where('name','like', '%'. $keywordSearch. '%');
                        })
                        ->paginate(10);

        $currentCategory = null;
        if($filterCategoryId){
            $currentCategory = $this->categoryRepository->find($filterCategoryId);
        }

        return view('website.pages.movie_category', compact('list_category', 'list_film','countAllFilm', 'currentCategory'));
    }

    public function showDetail($id)
    {
        $film = $this->filmRepository->find($id);
        if(!$film){
            throw new NotFoundHttpException();
        }
        return view('website.pages.movie_single', compact('film'));
    }
}
