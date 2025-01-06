<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets-backend/images/logo.png') }}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets-backend/images/logo-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets-backend/images/logo-dark.png') }}" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets-backend/images/logo-dark-sm.png') }}" alt="small logo">
        </span>
    </a>
    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="">
                <img src="{{ asset('assets-backend/images/users/peony-logo.jpg') }}" alt="user-image" height="42"
                    class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">
                    @if (Auth::check() && Auth::user()->name)
                        {{ Auth::user()->name }}
                    @endif
                </span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Menu</li>

            {{-- Homepage --}}
            <li class="side-nav-item">
                <a href="{{ route('client.home') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span>Website</span>
                </a>
            </li>

            {{-- Dashboard --}}
            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                    <i class="ri-dashboard-line"></i>
                    <span>Thống kê</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false"
                   aria-controls="sidebarEcommerce" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Quản lý rạp phim </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEcommerce">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.cinema.index') }}">Quản lý rạp phim</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.cinemas.rooms.index') }}">Quản lý phòng/ghế</a>
                        </li>
                    </ul>
                </div>
            </li>

{{--            <li class="side-nav-item">--}}
{{--                <a href="{{ route('admin.cinema.index') }}" class="side-nav-link">--}}
{{--                    <i class="uil-calender"></i>--}}
{{--                    <span>Quản lý rạp phim</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            {{-- quản lý phòng vé --}}
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarFilm" aria-expanded="false"
                    aria-controls="sidebarFilm" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Quản lý phim </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarFilm">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.category.index') }}">Quản lý loại phim</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.film.index') }}">Quản lý phim</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Quản lý vé/lịch chiếu --}}
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSchedule" aria-expanded="false"
                   aria-controls="sidebarSchedule" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Quản lý lịch chiếu </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSchedule">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.schedule.index') }}">Quản lý lịch chiếu</a>
                        </li>
{{--                        <li>--}}
{{--                            <a href="{{ route('admin.schedule.index') }}">Quản lý vé</a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </li>

            {{-- Quản lý vé/lịch chiếu --}}
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTicket" aria-expanded="false"
                   aria-controls="sidebarTicket" class="side-nav-link">
                    <i class="ri-ticket-line"></i>
                    <span> Quản lý vé đặt(dev*) </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTicket">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="#">Danh sách đặt vé</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.user.index') }}" class="side-nav-link">
                    <i class="ri-account-box-line"></i>
                    <span>Quản lý tài khoản</span>
                </a>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
