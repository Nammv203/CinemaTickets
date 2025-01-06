<?php

if(!function_exists('get_all_category')){
    function get_all_category($limit = null){
        $categoryRepository = \Illuminate\Support\Facades\App::make(\App\Repositories\CategoryRepository::class);
        return $categoryRepository
            ->when($limit, function ($query, $limit) {
                return $query->limit($limit)->get();
            }, function ($query) {
                return $query->get();
            });
    }
}

if(!function_exists('get_films_with_category')){
    function get_films_with_category(){
        $categoryRepository = \Illuminate\Support\Facades\App::make(\App\Repositories\CategoryRepository::class);
        return $categoryRepository->take(4)->with('films')->get();
    }
}

if(!function_exists('get_sidebar')){
    function get_sidebar(){
        $categoryRepository = \Illuminate\Support\Facades\App::make(\App\Repositories\CategoryRepository::class);
        $filmRepository = \Illuminate\Support\Facades\App::make(\App\Repositories\FilmRepository::class);
        $countAllFilm = $filmRepository->count();
        $list_category = $categoryRepository->withCount(['films'])->all();

        return view('website.partials.sidebar', compact('countAllFilm', 'list_category'));
    }
}

if(!function_exists('get_top_movies_slider')){
    function get_top_movies_slider(){
        return view('website.partials.top_movies');
    }
}

if(!function_exists('get_date_d')){
    function get_date_d($date){
        $datetime = new DateTime($date);
        $dayAbbreviation = strtoupper($datetime->format('D')); // 'D' trả về ký tự viết tắt
        return $dayAbbreviation; // Output: MON (Thứ Hai)
    }
}

if(!function_exists('getChairTypeText')){
    function getChairTypeText($code)
    {
        $mapping = [
            0 => 'A',
            1 => 'B',
            2 => 'C',
        ];

        return $mapping[$code] ?? 'D';
    }
}

if(!function_exists('top_film_hot')){
    function top_film_hot(){
        $filmRepository = \Illuminate\Support\Facades\App::make(\App\Repositories\FilmRepository::class);
        return $filmRepository->getFilmHot(10);
    }
}

if(!function_exists('resend_email_verify')){
    function resend_email_verify($token){
        $register =  \Illuminate\Support\Facades\App::make(\App\Http\Controllers\Auth\RegisterController::class);

        return $register->resendEmailVerify($token);
    }
}
