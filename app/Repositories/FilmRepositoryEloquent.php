<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FilmRepository;
use App\Models\Film;
use App\Validators\FilmValidator;

/**
 * Class FilmRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FilmRepositoryEloquent extends BaseRepository implements FilmRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Film::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FilmValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function getList($request)
    {
        return $this->model
            ->when($request->keyword, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->keyword}%");
            })->when($request->category_id, function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->orderBy($request->sort ?? 'created_at', $request->order ?? 'desc')
            ->paginate($request->limit ?? 10);
    }
}
