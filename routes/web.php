<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CinemasController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Website\CategoriesController as CategoriesWebsiteController;
use App\Http\Controllers\Website\OrdersController as OrderWebsiteController;
use App\Http\Controllers\Website\UsersController as UserWebsiteController;
use App\Http\Controllers\Admin\FilmsController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Admin\CinemaRoomsController;
use App\Http\Controllers\Admin\CinemaRoomChairsController;
use App\Http\Controllers\Admin\SchedulePublishFilmsController;
use App\Http\Controllers\Website\SchedulePublishFilmsController as SchedulePublishFilmsWebsiteController;

Route::group([
    'prefix' => '/'
], function () {
    Route::name('client.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/movie-categories', [CategoriesWebsiteController::class, 'index'])->name('categories');
        Route::get('/movie-detail/{id}', [CategoriesWebsiteController::class, 'showDetail'])->name('movies.detail');
        Route::get('/movie-booking/{id}', [SchedulePublishFilmsWebsiteController::class, 'showBookingPage'])->name('movies.booking');
        Route::get('/movie-booking/{schedule_id}/seat', [SchedulePublishFilmsWebsiteController::class, 'showSeatBookingPage'])->name('movies.seat_booking');

        // post checkout btn
        Route::post('/checkout',[\App\Http\Controllers\Website\TicketsController::class, 'checkAuthAfterCheckout'])->name('postCheckout');
    });
});

Route::group([
    'middleware' => 'guest',
    'prefix' => 'auth'
], function () {
    Route::name('auth.')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
        Route::post('/login', [LoginController::class, 'postLogin'])->name('postLogin');
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('showRegistrationForm');
        Route::post('/register', [RegisterController::class, 'postRegister'])->name('postRegister');
    });
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'auth'
], function () {
    Route::name('auth.')->group(function () {
        Route::post('/logout-post', [LogoutController::class, 'postLogout'])->name('postLogout');

        // profile
        Route::get('/profile', [UserWebsiteController::class, 'index'])->name('profile');
        Route::patch('/profile', [UserWebsiteController::class, 'update'])->name('profile.update');
        Route::patch('/profile/change-password', [UserWebsiteController::class, 'updatePassword'])->name('profile.change-password');

        // booking
        Route::name('client.')->group(function () {
            Route::get('/movie-booking/payment', [OrderWebsiteController::class, 'showPagePaymentTicket'])->name('movies.show.payment');
            Route::get('/movie-booking/confirm-payment', [OrderWebsiteController::class, 'showPageConfirmPayment'])->name('movies.show.confirm-payment');
            Route::post('/movie-booking/payment', [\App\Http\Controllers\Website\OrdersController::class,'saveTicketOrder'])->name('movies.postCheckoutPayment');
        });

        // forgot password
//        Route::get('forgot-password', [AuthController::class, 'getForgotPassword'])->name('getForgotPassword');
//        Route::post('forgot-password', [AuthController::class, 'postForgotPassword'])->name('postForgotPassword');
//        Route::get('change-password/{id}', [AuthController::class, 'getChangePassword'])->name('getChangePassword');
//        Route::post('change-password/{id}', [AuthController::class, 'postChangePassword'])->name('postChangePassword');
    });
});

Route::group([
    'middleware' => 'auth.admin',
    'prefix' => 'admin'
], function () {
    Route::name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
        Route::resource('category', CategoriesController::class);
        Route::resource('film', FilmsController::class);
        Route::resource('cinema', CinemasController::class);
        Route::resource('order', \App\Http\Controllers\Admin\OrdersController::class);

        // cinema rooms
        Route::prefix('cinemas')->group(function () {
            Route::get('/cinema-rooms',[ CinemaRoomsController::class,'index'])->name('cinemas.rooms.index');
            Route::post('/cinema-rooms',[ CinemaRoomsController::class,'store'])->name('cinemas.rooms.store');
            Route::put('/cinema-rooms/{room_id}',[ CinemaRoomsController::class,'update'])->name('cinemas.rooms.update');
            Route::get('/cinema-rooms/{room_id}',[ CinemaRoomsController::class,'show'])->name('cinemas.rooms.show');
            Route::delete('/cinema-rooms/{room_id}',[ CinemaRoomsController::class,'destroy'])->name('cinemas.rooms.destroy');
            // get rooms by cinema_id (api | web)
            Route::get('/{cinema_id}/cinema-rooms', [CinemaRoomsController::class,'index'])->name('cinema-rooms.index');
        });

        // room_chairs
        Route::prefix('/cinema-rooms/{room_id}/chairs')->name('rooms-chairs.')->group(function () {
            Route::get('/',[ CinemaRoomChairsController::class,'index'])->name('index');
        });

        // schedule publish films
        Route::prefix('schedule-publish-films')->group(function () {
            Route::get('/',[ SchedulePublishFilmsController::class,'index'])->name('schedule.index');
            Route::post('/',[ SchedulePublishFilmsController::class,'store'])->name('schedule.store');
            Route::get('/list',[ SchedulePublishFilmsController::class,'create'])->name('schedule.create');
            Route::put('/{schedule_id}',[ SchedulePublishFilmsController::class,'update'])->name('schedule.update');
            Route::get('/{schedule_id}',[ SchedulePublishFilmsController::class,'show'])->name('schedule.show');
            Route::delete('/{schedule_id}',[ SchedulePublishFilmsController::class,'destroy'])->name('schedule.destroy');

            Route::get('/room-map/{schedule_id}',[ SchedulePublishFilmsController::class,'showRoomMap'])->name('schedule.room.map');
        });

        Route::get('get-district-with-province/{id}', [CinemasController::class, 'getDistrictWithProvince']);

        Route::prefix('user')->name('user.')->group(function() {
            Route::get('create', [UsersController::class, 'create'])->name('create');
            Route::post('/', [UsersController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [UsersController::class, 'update'])->name('update');
            Route::delete('/{id}', [UsersController::class, 'destroy'])->name('destroy');

            Route::get('/{role?}', [UsersController::class, 'index'])->name('index');
        });
    });
});
