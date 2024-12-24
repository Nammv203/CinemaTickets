@php
    $categories = get_all_category();
    $filmWithCategory = get_films_with_category();
@endphp

<div class="prs_navigation_main_wrapper">
    <div class="container-fluid">
        <div id="search_open" class="gc_search_box">
            <input type="text" placeholder="Search here">
            <button><i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </div>
        <div class="prs_navi_left_main_wrapper">
            <div class="prs_logo_main_wrapper">
                <a href="{{route('client.home')}}">
                    <img src="{{ asset('assets-website') }}/images/header/logo.png" alt="logo" />
                </a>
            </div>
            <div class="prs_menu_main_wrapper">
                <nav class="navbar navbar-default">
                    <div id="dl-menu" class="xv-menuwrapper responsive-menu">
                        <button class="dl-trigger">
                            <img src="{{ asset('assets-website') }}/images/header/bars.png" alt="bar_png">
                        </button>
                        <div class="prs_mobail_searchbar_wrapper" id="search_button"> <i class="fa fa-search"></i>
                        </div>
                        <div class="clearfix"></div>
                        <ul class="dl-menu">
                            <li class="parent"><a href="{{route('client.home')}}">Trang chủ</a>
                            </li>
                            <li class="parent megamenu"><a href="{{route('client.categories')}}">Phim</a>
                                <ul class="lg-submenu">

                                    @foreach ($filmWithCategory as $category)
                                        <li><a>{{ $category->name }}</a>
                                            <ul class="lg-submenu">

                                                @foreach ($category->films as $film)
                                                    <li class="ar_left">
                                                        <i class="fa fa-film"></i>
                                                        <a href="{{route('client.movies.detail', $film->id )}}">{{ $film->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach

{{--                                    <li>--}}
{{--                                        <div class="prs_navi_slider_wraper">--}}
{{--                                            <div class="owl-carousel owl-theme">--}}
{{--                                                <div class="item">--}}
{{--                                                    <img src="{{ asset('assets-website') }}/images/content/up1.jpg"--}}
{{--                                                        alt="navi_img">--}}
{{--                                                </div>--}}
{{--                                                <div class="item">--}}
{{--                                                    <img src="{{ asset('assets-website') }}/images/content/up2.jpg"--}}
{{--                                                        alt="navi_img">--}}
{{--                                                </div>--}}
{{--                                                <div class="item">--}}
{{--                                                    <img src="{{ asset('assets-website') }}/images/content/up3.jpg"--}}
{{--                                                        alt="navi_img">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
                                </ul>
                            </li>

                            {{-- nav category film --}}
                            <li class="parent"><a href="{{route('client.categories')}}">Thể loại phim</a>
                                <ul class="lg-submenu">
                                    @foreach ($categories as $category)
                                        <li><a href="{{route('client.categories',['category_id' => $category->id])}}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /dl-menuwrapper -->
                </nav>
            </div>
        </div>
        <div class="prs_navi_right_main_wrapper">
            <div class="prs_slidebar_wrapper">
                <button class="second-nav-toggler" type="button">
                    <img src="{{ asset('assets-website') }}/images/header/bars.png" alt="bar_png">
                </button>
            </div>
            <div class="prs_top_login_btn_wrapper">

                <div class="prs_animate_btn1">
                    <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-lg dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tài khoản
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @if(!auth()->check())
                                <li>
                                    <a href="{{route('auth.showRegistrationForm')}}">Đăng ký</a>
                                </li>
                                <li>
                                    <a href="{{route('auth.showLoginForm')}}">Đăng nhập</a>
                                </li>
                            @elseif(auth()->check() && auth()->user()->role_id !== 0 )
                                <li>
                                    <a href="{{route('admin.dashboard')}}" target="_blank">Trang Admin</a>
                                </li>
                                <li>
                                    <a href="{{ route('auth.profile') }}">Tài khoản</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('auth.profile') }}">Tài khoản</a>
                                </li>
                            @endif

                            @if(auth()->check())

                                @if(Illuminate\Support\Facades\Session::has('order'))
                                        <li>
                                            <a href="{{ route('auth.client.movies.show.payment') }}">Tiếp tục thanh toán</a>
                                        </li>
                                @endif

                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="">
                                        <form action="{{ route('auth.postLogout') }}" method="POST">
                                            @csrf
                                            @method('POST')

                                            <button type="submit" class="btn btn-link text-dark p-0" data-text="Đăng xuất">
                                                <span class="text-dark">Đăng xuất</span>
                                            </button>
                                        </form>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                {{-- <div class="prs_animate_btn1">
                    <ul>
                        @if(!auth()->check())
                            <li>
                                <a href="{{route('auth.showRegistrationForm')}}" class="button button--tamaya" data-text="Đăng ký"><span>Đăng ký</span>
                                </a>
                            </li>
                        @elseif(auth()->check() && auth()->user()->role_id !== 0 )
                            <li>
                                <a href="{{route('admin.dashboard')}}" class="button button--tamaya" data-text="Trang Admin" target="_blank">
                                    <span>Trang Admin</span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="#" class="button button--tamaya" data-text="Tài khoản"><span>Tài khoản</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div> --}}
            </div>
            <div class="product-heading">
                <form action="{{ route('client.categories') }}" method="GET" class="con">
                    <select name="category_id">
                        <option value="">Tất cả</option>
                        @foreach ($categories as $category)
                            <option {{request('category_id') == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <input type="search" name="keyword" placeholder="Tìm kiếm phim" required>
                    <button type="submit"><i class="flaticon-tool"></i>
                    </button>
                </form>
            </div>
        </div>
        <div id="mobile-nav" data-prevent-default="true" data-mouse-events="true">
            <div class="mobail_nav_overlay"></div>
            <div class="mobile-nav-box">
                <div class="mobile-logo">
                    <a href="index.html" class="mobile-main-logo">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="46.996px"
                            height="40px" viewBox="0 0 46.996 40" enable-background="new 0 0 46.996 40"
                            xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M39.919,19.833C39.919,8.88,30.984,0,19.959,0C8.937,0,0,8.88,0,19.833
                                        c0,10.954,8.937,19.834,19.959,19.834C30.984,39.666,39.919,30.787,39.919,19.833z M35.675,14.425
                                        c0.379,0,0.686,0.307,0.686,0.683s-0.305,0.683-0.686,0.683c-0.38,0-0.688-0.307-0.688-0.683S35.295,14.425,35.675,14.425z
                                        M34.482,20.461c0,0.491-0.025,0.976-0.071,1.452l-11.214-4.512l6.396-7.733C32.592,12.311,34.482,16.167,34.482,20.461z
                                        M19.083,2.277c0.379,0,0.687,0.305,0.687,0.682c0,0.378-0.306,0.684-0.687,0.684c-0.378,0-0.686-0.306-0.686-0.684
                                        C18.396,2.584,18.704,2.277,19.083,2.277z M19.959,6.031c1.916,0,3.743,0.372,5.416,1.042l-6.335,7.662l-6.252-6.82
                                        C14.906,6.718,17.351,6.031,19.959,6.031z M3.128,16.473c-0.378,0-0.687-0.306-0.687-0.684c0-0.377,0.307-0.682,0.687-0.682
                                        c0.38,0,0.686,0.305,0.686,0.682C3.814,16.167,3.508,16.473,3.128,16.473z M5.535,22.119c-0.063-0.545-0.098-1.098-0.098-1.658
                                        c0-3.612,1.339-6.911,3.547-9.444l6.502,7.095L5.535,22.119z M10.462,35.354c-0.379,0-0.687-0.306-0.687-0.683
                                        s0.307-0.682,0.687-0.682c0.379,0,0.687,0.305,0.687,0.682S10.842,35.354,10.462,35.354z M6.925,26.828l10.4-4.186l0.239,12.052
                                        C12.88,33.921,8.956,30.922,6.925,26.828z M19.513,22.326c-1.529,0-2.771-1.232-2.771-2.752c0-1.521,1.241-2.753,2.771-2.753
                                        c1.53,0,2.771,1.232,2.771,2.753C22.284,21.096,21.043,22.326,19.513,22.326z M29.939,33.99c-0.378,0-0.686-0.308-0.686-0.683
                                        c0-0.377,0.307-0.683,0.686-0.683s0.688,0.306,0.688,0.683C30.626,33.683,30.319,33.99,29.939,33.99z M22.482,34.672
                                        l-0.246-12.388l10.846,4.365C31.098,30.799,27.177,33.854,22.482,34.672z M35.314,34.585c-1.837,1.531-6.061,4.306-6.061,4.306
                                        C37.652,36.448,45.953,40,45.953,40l1.043-8.658C41.41,30.454,38.125,32.244,35.314,34.585z" />
                                </g>
                            </g>
                        </svg><span>Movie Pro</span>
                    </a>
                    <a href="#" class="manu-close"><i class="fa fa-times"></i></a>
                </div>
                <ul class="mobile-list-nav">
                    <li><a href="about.html">OVERVIEW</a>
                    </li>
                    <li><a href="movie_single.html">MOVIE</a>
                    </li>
                    <li><a href="event_single.html">EVENT</a>
                    </li>
                    <li><a href="gallery.html">GALLERY</a>
                    </li>
                    <li><a href="blog_single.html">BLOG</a>
                    </li>
                    <li><a href="contact.html">CONTACT</a>
                    </li>
                </ul>
                <div class="product-heading prs_slidebar_searchbar_wrapper">
                    <div class="con">
                        <select>
                            <option>Tất cả</option>
                            @foreach ($categories as $category)
                                <option>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" placeholder="Tìm kiếm phim">
                        <button type="submit"><i class="flaticon-tool"></i>
                        </button>
                    </div>
                </div>
                <div class="achivement-blog">
                    <ul class="flat-list">
                        <li>
                            <a href="#"> <i class="fa fa-facebook"></i>
                                <h6>Facebook</h6>
                                <span class="counter">12546</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"> <i class="fa fa-twitter"></i>
                                <h6>Twiter</h6>
                                <span class="counter">12546</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"> <i class="fa fa-pinterest"></i>
                                <h6>Pinterest</h6>
                                <span class="counter">12546</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="prs_top_login_btn_wrapper prs_slidebar_searchbar_btn_wrapper">
                    <div class="prs_animate_btn1">
                        <ul>
                            <li><a href="#" class="button button--tamaya" data-text="sign up"
                                    data-toggle="modal" data-target="#myModal"><span>sign up</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
