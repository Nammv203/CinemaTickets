@php
    $pageTitle = 'Thể loại phim';
    $bannerTitle = 'Tất cả thể loại';
    $bannerSearchText = '';
    if($currentCategory)
        {
            $pageTitle = 'Thể loại > '.$currentCategory->name;
            $bannerTitle = 'Thể loại: '.$currentCategory->name;
        }
    if(request('keyword')){
            $bannerSearchText = 'Từ khóa tìm kiếm: '.request('keyword');
    }
@endphp

@extends('website.layouts.bookings')

@section('page-title',$pageTitle)
@section('banner-title',$bannerTitle)
@section('banner-search-text',$bannerSearchText)
@section('page-content')

        <!-- prs mc slider wrapper Start -->
        <div class="prs_mc_slider_main_wrapper">
            @if(!request('keyword'))
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="prs_heading_section_wrapper">
                            <h2>Comming soon</h2>
                        </div>
                    </div>
                    {{--                danh sách fim sắp được publish --}}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="prs_mc_slider_wrapper">
                            <div class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="{{asset('assets-website')}}/images/content/movie_category/slider_img1.jpg"
                                         alt="about_img">
                                </div>
                                <div class="item">
                                    <img src="{{asset('assets-website')}}/images/content/movie_category/slider_img2.jpg"
                                         alt="about_img">
                                </div>
                                <div class="item">
                                    <img src="{{asset('assets-website')}}/images/content/movie_category/slider_img3.jpg"
                                         alt="about_img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="container">
                    <h3>{{$bannerSearchText}}</h3>
                </div>
            @endif
        </div>
    <!-- prs mc slider wrapper End -->
    <!-- prs mc category slidebar Start -->
    <div class="prs_mc_category_sidebar_main_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 hidden-sm hidden-xs">
                    <div class="prs_mcc_left_side_wrapper">
{{--                        <div class="prs_mcc_left_searchbar_wrapper">--}}
{{--                            <input type="text" placeholder="Tìm kiếm phim">--}}
{{--                            <button><i class="flaticon-tool"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}
                        <div class="prs_mcc_bro_title_wrapper" style="padding-top: 0 !important;">
                            <h2>thể loại</h2>
                            <style>
                                .nav-bar__menu-item.active{
                                    color: #ff4444;
                                }
                            </style>
                            <ul>
                                <li><i class="fa fa-caret-right"></i> &nbsp;&nbsp;&nbsp;
                                    <a href="{{route('client.categories')}}"
                                       class="nav-bar__menu-item {{ !request('category_id') ? 'active' : '' }}">
                                        All
                                        <span>{{$countAllFilm}}</span></a>
                                </li>
                                @foreach($list_category as $cate)
                                    <li><i class="fa fa-caret-right"></i> &nbsp;&nbsp;&nbsp;
                                        <a href="{{route('client.categories',['category_id' => $cate->id])}}"
                                           class="nav-bar__menu-item {{ request('category_id') == $cate->id ? 'active' : '' }}">
                                            {{$cate->name}}
                                            <span>{{$cate->films_count ?? 0}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="prs_mcc_event_title_wrapper">
                            <h2>Top Events</h2>
                            <img src="{{asset('assets-website')}}/images/content/movie_category/event_img.jpg"
                                 alt="event_img">
                            <h3><a href="#">Music Event in india</a></h3>
                            <p>Pune <span><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i
                                        class="fa fa-star-o"></i></span>
                            </p>
                            <h4>June 07 <span>08:00-12:00 pm</span></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="prs_mcc_right_side_wrapper">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="prs_mcc_right_side_heading_wrapper">
                                    <h2>Các bộ phim</h2>
                                    <ul class="nav nav-pills">
                                        <li class="active"><a data-toggle="pill" href="#grid"><i
                                                    class="fa fa-th-large"></i></a>
                                        </li>
                                        <li><a data-toggle="pill" href="#list"><i class="fa fa-list"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="tab-content">
                                    <div id="grid" class="tab-pane fade in active">
                                        <div class="row">

                                            @if(!$list_film->count())
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Không có sẵn</div>
                                            @endif

                                            @foreach($list_film as $film)
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 prs_upcom_slide_first">
                                                    <div class="prs_upcom_movie_box_wrapper prs_mcc_movie_box_wrapper">
                                                        <div class="prs_upcom_movie_img_box">
                                                            <img
                                                                src="{{asset('storage').'/film/'.$film->picture}}"
                                                                alt="movie_img"/>
                                                            <div class="prs_upcom_movie_img_overlay"></div>
                                                            <div class="prs_upcom_movie_img_btn_wrapper">
                                                                <ul>
                                                                    <li><a href="#">Xem Trailer</a>
                                                                    </li>
                                                                    <li><a href="{{route('client.movies.detail',['id'=>$film->id])}}">Xem Chi tiết</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="prs_upcom_movie_content_box">
                                                            <div class="prs_upcom_movie_content_box_inner">
                                                                <h2><a href="#">{{$film->name}}</a></h2>
                                                                <p>{{$film->category?->name}}</p>    <i
                                                                    class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                            </div>
                                                            <div class="prs_upcom_movie_content_box_inner_icon">
                                                                <ul>
                                                                    <li><a href="{{route('client.movies.booking',['id' => $film->id])}}"><i
                                                                                class="flaticon-cart-of-ecommerce"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="pager_wrapper gc_blog_pagination">
{{--                                                    <ul class="pagination">--}}
{{--                                                        <li><a href="#"><i class="flaticon-left-arrow"></i></a>--}}
{{--                                                        </li>--}}
{{--                                                        <li><a href="#">1</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li><a href="#">2</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="prs_third_page"><a href="#">3</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="hidden-xs"><a href="#">4</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li><a href="#"><i class="flaticon-right-arrow"></i></a>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
                                                    {{$list_film->links()}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="list" class="tab-pane fade">
                                        <div class="row">
                                            @foreach($list_film as $film)
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="prs_mcc_list_movie_main_wrapper">
                                                        <div class="prs_mcc_list_movie_img_wrapper">
                                                            <img
                                                                src="{{asset('storage').'/film/'.$film->picture}}"
                                                                alt="categoty_img">
                                                        </div>
                                                        <div class="prs_mcc_list_movie_img_cont_wrapper">
                                                            <div class="prs_mcc_list_left_cont_wrapper">
                                                                <h2>{{$film->name}}</h2>
                                                                <p>{{$film->category?->nam}} &nbsp;&nbsp;&nbsp;<i
                                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                                        class="fa fa-star"></i><i
                                                                        class="fa fa-star-o"></i><i
                                                                        class="fa fa-star-o"></i>
                                                                </p>
                                                                <h4>Đạo diễn - {{$film->derector}}</h4>
                                                            </div>
                                                            <div class="prs_mcc_list_right_cont_wrapper"><a href="#"><i
                                                                        class="flaticon-cart-of-ecommerce"></i></a>
                                                            </div>
                                                            <div class="prs_mcc_list_bottom_cont_wrapper">
                                                                <p>{{$film->description}}</p>
                                                                <ul>
                                                                    <li><a href="#">Xem Trailer</a>
                                                                    </li>
                                                                    <li><a href="{{route('client.movies.detail',['id'=>$film->id])}}">Xem Chi tiết</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="pager_wrapper gc_blog_pagination">
{{--                                                    <ul class="pagination">--}}
{{--                                                        <li><a href="#"><i class="flaticon-left-arrow"></i></a>--}}
{{--                                                        </li>--}}
{{--                                                        <li><a href="#">1</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li><a href="#">2</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="prs_third_page"><a href="#">3</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li class="hidden-xs"><a href="#">4</a>--}}
{{--                                                        </li>--}}
{{--                                                        <li><a href="#"><i class="flaticon-right-arrow"></i></a>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
            {{$list_film->links()}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 visible-sm visible-xs">
                    {{get_sidebar()}}
                </div>
            </div>
        </div>
    </div>
    <!-- prs mc category slidebar End -->
    <!-- prs theater Slider Start -->
    {{get_top_movies_slider()}}
    <!-- prs theater Slider End -->
@endsection
