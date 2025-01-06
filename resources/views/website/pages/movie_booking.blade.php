@extends('website.layouts.bookings')
@section('page-title','Movie Booking')
@section('banner-title','Movie Booking')
@section('page-content')

    <style>
        .btn-show-detail {
            background-color: black !important;
        }

        .custom-modal-size {
            width: 90%;
            max-width: 1200px;
        }

        .modal-body iframe {
            width: 100%;
            height: 600px;
        }

        .st_video_slider_inner_wrapper {
            /*  */
        }
    </style>

<!-- prs video top Start -->
<div class="prs_booking_main_div_section_wrapper">
	<div class="prs_top_video_section_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="st_video_slider_inner_wrapper float_left"
                         style="background-image: url('{{ asset(config('filesystems.folder_storage_user.film') . $film->picture) }}')">
                        <div class="st_video_slider_overlay"></div>
                        <div class="st_video_slide_sec float_left">
                            <button type="button" class="btn btn-lg btn-show-detail" data-toggle="modal"
                                    data-target="#modal-show-detail">
                                <img src="{{ asset('assets-website') }}/images/index_III/icon.png" alt="img"
                                     class="text-black">
                            </button>
                            <h3>{{ $film->name }}</h3>
                            <h4>{{$film->category?->name}}</h4>
                        </div>
                        <div class="st_video_slide_social float_left">
                            <div class="st_video_slide_social_right float_left">
                                <ul>
                                    <li data-animation="animated fadeInUp" class="">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($film->publish_at)->format('d/m/Y') }}
                                    </li>

                                    <li data-animation="animated fadeInUp" class="">
                                        <i class="far fa-clock"></i>
                                        {{ $film->time_duration }} phút
                                    </li>
                                </ul>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- prs video top End -->
	<!-- st slider rating wrapper Start -->
	<div class="st_slider_rating_main_wrapper float_left">
		<div class="container">
			<div class="st_calender_tabs">
				<ul class="nav nav-tabs">

                    @php $key = 0; @endphp
                    @foreach($schedules as $date => $schedule)

                        <li class="{{$key == 0 ? 'active' : ''}}">
                            <a data-toggle="tab" href="#tab-{{$key}}">
                                <span>{{get_date_d($date)}}</span>
                                <br> {{ \Carbon\Carbon::parse($date)->format('d-m') }}
                            </a>
                        </li>

                        @php $key ++ @endphp
                    @endforeach

				</ul>
{{--                <ul class="nav nav-tabs">--}}
{{--                    <li class="active"> <a data-toggle="tab" href="#home"><span>WED</span> <br> 19</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a data-toggle="tab" href="#menu1"> <span>THU</span>--}}
{{--                            <br>20</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a data-toggle="tab" href="#menu2"> <span>FRI</span>--}}
{{--                            <br>21</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a data-toggle="tab" href="#menu3"> <span>SAT</span>--}}
{{--                            <br>22</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a data-toggle="tab" href="#menu4"> <span>SUN</span>--}}
{{--                            <br>23</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
			</div>
		</div>
	</div>
	<!-- st slider rating wrapper End -->
	<!-- st slider sidebar wrapper Start -->
	<div class="st_slider_index_sidebar_main_wrapper st_slider_index_sidebar_main_wrapper_booking float_left">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<div class="st_indx_slider_main_container float_left">
						<div class="row">
							<div class="col-md-12">
								<div class="tab-content">
                                    @if(!count($schedules))
                                        Phim chưa lên lịch chiếu
                                    @endif
{{--                                    mapping lich chieu theo ngay --}}
                                    @php $key = 0; @endphp
                                    @foreach($schedules as $date => $schedule)

									    <div id="tab-{{$key}}" class="tab-pane {{$key === 0 ? 'active' : ''}}">
										<div class="st_calender_contant_main_wrapper float_left">

{{--                                            mapping lich chieu theo gio trong ngay --}}
                                            @foreach($schedule as $cinemaName => $schs)
                                                <div class="st_calender_row_cont float_left">
                                                    <div class="st_calender_asc">
                                                        <div class="st_calen_asc_heart">
                                                            <a href="#">
                                                                <i class="fa fa-heart"></i>
                                                            </a>
                                                        </div>
                                                        <div class="st_calen_asc_heart_cont">
                                                            <h3>{{ $cinemaName }}</h3>
                                                            <ul>
                                                                <li>
                                                                    <img src="{{asset('assets-website')}}/images/content/fast-food.png">
                                                                </li>
                                                                <li>
                                                                    <img src="{{asset('assets-website')}}/images/content/bill.png">
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="st_calen_asc_tecket_time_select">
                                                        <ul>

                                                            @foreach($schs as $sch)
                                                                <li>
                                                                <span>
                                                                    <h4>{{$sch[0]?->ticket_price ? number_format($sch[0]?->ticket_price) : 0}} đ</h4>
                                                                    <p class="asc_pera1">Giá vé (chưa cộng hạng ghế)</p>
                                                                    <p class="asc_pera2">Filling Fast</p>
                                                                </span>
                                                                    <a href="{{route('auth.client.movies.seat_booking',['schedule_id'=>$sch[0]?->id])}}">{{$sch[0]?->show_time}}</a>
                                                                </li>
                                                            @endforeach

                                                        </ul>
                                                    </div>
                                                </div>

                                            @endforeach

										</div>
									</div>

                                        @php $key ++ @endphp
                                    @endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    {{get_sidebar()}}
				</div>
			</div>
		</div>
	</div>
	</div>

    <!-- Large modal show trailer-->
    <div class="modal fade" id="modal-show-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog custom-modal-size" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe width="100%" height="100%"
                            src="{{ str_replace('watch?v=', 'embed/', $film->trailer_youtube_link) }}?controls=0"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

                </div>
            </div>
        </div>
    </div>
@endsection
