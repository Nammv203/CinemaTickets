<!DOCTYPE html>

<html lang="en">

<head>
	@include('website.partials.head')
</head>

<body class="booking_type_back">
	<!-- preloader Start -->
	<div id="preloader">
		<div id="status">
			<img src="{{asset('assets-website')}}/images/header/horoscope.gif" id="preloader_image" alt="loader">
		</div>
	</div>
	<!-- color picker start -->
	<!-- st top header Start -->
	<div class="st_bt_top_header_wrapper float_left">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
					<div class="st_bt_top_back_btn float_left">	<a style="cursor: pointer" onclick="history.back()"><i class="fas fa-long-arrow-alt-left"></i> &nbsp;Trở lại</a>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
					<div class="st_bt_top_center_heading float_left">
						<h3>{{$schedule?->film?->name}} - ({{$schedule->film?->time_duration}}) phút </h3>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- st top header Start -->
	<!-- st dtts section Start -->
	<div class="st_dtts_wrapper float_left">
		<div class="container">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
					<div class="st_dtts_left_main_wrapper float_left">
						<div class="row">
							<div class="col-md-12">
								<div class="st_dtts_ineer_box float_left">
									<ul>
										<li><span class="dtts1">Ngày chiếu</span>  <span class="dtts2">{{$schedule->show_time}} - {{$schedule->show_date}}</span>
										</li>
										<li><span class="dtts1">Thời lượng</span>  <span class="dtts2">{{$schedule->film?->time_duration}} phút</span>
										</li>
										<li><span class="dtts1">Rạp chiếu</span>  <span class="dtts2">{{$schedule->cinemaRoom?->cinema?->name}}</span>
										</li>
										<li><span class="dtts1">Phòng-Chỗ ngồi</span>  <span class="dtts2">P{{$schedule->cinemaRoom?->room_code}} - {{$ticketString}} ({{$totalTicket}} Vé) </span>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-md-12">
								<div class="st_cherity_section float_left">
									<div class="st_cherity_img float_left">
										<img src="{{ asset(config('filesystems.folder_storage_user.film')) . '/' . $schedule?->film?->picture}}" alt="img">
									</div>
									<div class="st_cherity_img_cont float_left">
										<div class="box">
											<p class="cc_pc_color1">
												<input type="checkbox" id="c201" name="term_condition">
												<label for="c201">Bạn đồng ý với điều khoản của trang web.</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="st_cherity_btn float_left">
									<h3></h3>
									<ul>
{{--										<li><a href="#"><i class="flaticon-tickets"></i> &nbsp;M-Ticket</a>--}}
{{--										</li>--}}
{{--										<li><a href="#"><i class="flaticon-tickets"></i> &nbsp;Box office Pickup </a>--}}
{{--										</li>--}}
										<li><a style="cursor: pointer" id="btn-payment">Tiếp tục thanh toán</a>
										</li>
									</ul>

                                    <form style="display: none" action="{{route('auth.client.movies.postCheckoutPayment')}}" method="post" id="form-data-payment">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="schdule_id" value="{{$schedule->id}}">
                                        <input type="hidden" name="grand_total" value="{{$netPrice}}">
                                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
					<div class="row">
						<div class="col-md-12">
							<div class="st_dtts_bs_wrapper float_left">
								<div class="st_dtts_bs_heading float_left">
									<p>Tổng quan đơn hàng</p>
								</div>
								<div class="st_dtts_sb_ul float_left">
									<ul>
                                        <li>Giá mỗi vé
                                            <br>
                                            <span>{{number_format($schedule->ticket_price)}}đ</span>
                                        </li>
										<li>P{{$schedule->cinemaRoom?->room_code}} - {{$ticketString}}
											<br>( {{$totalTicket}} Vé ) <span>{{number_format($schedule->ticket_price * $totalTicket)}}đ</span>
										</li>
                                        <li>Giá vé hạng ghế
											<br>
                                            <span>{{number_format($sumChairTypePrice)}}đ</span>
										</li>
										<li>Ghi chú bảng giá ghế *<span></span>
										</li>
									</ul>
									<p>Hạng ghế A <span>{{\App\Helpers\Constants::PRICE_CHAIR_TYPE_A}}</span>
									</p>
                                    <p>Hạng ghế B <span>{{\App\Helpers\Constants::PRICE_CHAIR_TYPE_B}}</span>
                                    </p>
                                    <p>Hạng ghế C <span>{{\App\Helpers\Constants::PRICE_CHAIR_TYPE_C}}</span>
                                    </p>
                                    <p>Hạng ghế D <span>{{\App\Helpers\Constants::PRICE_CHAIR_TYPE_D}}</span>
                                    </p>
								</div>
								<div class="st_dtts_sb_h2 float_left">
									<h3>Tổng phụ <span>{{number_format($netPrice)}}đ</span></h3>
									<h4>Current State is <span>Vietnam</span></h4>
									<h5>Giá phải thanh toán <span>{{number_format($netPrice)}}đ</span></h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- st dtts section End -->
	@include('website.partials.script')
	<!--main js file end-->
	<script>
		//* Isotope js
		    function protfolioIsotope(){
		        if ( $('.st_fb_filter_left_box_wrapper').length ){
		            // Activate isotope in container
		            $(".protfoli_inner, .portfoli_inner").imagesLoaded( function() {
		                $(".protfoli_inner, .portfoli_inner").isotope({
		                    layoutMode: 'masonry',
		                });
		            });

		            // Add isotope click function
		            $(".protfoli_filter li").on('click',function(){
		                $(".protfoli_filter li").removeClass("active");
		                $(this).addClass("active");
		                var selector = $(this).attr("data-filter");
		                $(".protfoli_inner, .portfoli_inner").isotope({
		                    filter: selector,
		                    animationOptions: {
		                        duration: 450,
		                        easing: "linear",
		                        queue: false,
		                    }
		                });
		                return false;
		            });
		        };
		    };
		 protfolioIsotope ();

		  function changeQty(increase) {
				            var qty = parseInt($('.select_number').find("input").val());
				            if (!isNaN(qty)) {
				                qty = increase ? qty + 1 : (qty > 1 ? qty - 1 : 1);
				                $('.select_number').find("input").val(qty);
				            } else {
				                $('.select_number').find("input").val(1);
				            }
				        }

        // handle button checkout
        $(document).ready(function () {
            $('#btn-payment').click(function () {
                if(!$('input[name="term_condition"]').is(':checked')){
                    alert('Hãy đồng ý với điều khoản của trang web trước!')
                    return
                }

                // send data to backend
                $('form#form-data-payment').submit();
            })
        })
	</script>
</body>

</html>
