@extends('website.layouts.bookings')
@section('page-title','Xác nhận đơn đặt')
@section('page-content')
	<!-- st bc Start -->
	<div class="st_bcc_main_main_wrapper float_left">
		<div class="st_bcc_main_wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="st_bcc_heading_wrapper float_left">	<i class="fa fa-check-circle"></i>
							<h3>Thanh toán cho <span>{{number_format($netPrice ?? 0)}} đ</span> Thành công</h3>
						</div>
					</div>
					<div class="col-md-12">
						<div class="st_bcc_ticket_boxes_wrapper float_left">
							<div class="st_bcc_tecket_top_hesder float_left">
								<p>Đơn hàng của bạn đã được đặt!</p>	<span> ID {{session('ticketOrder')?->ticket_number}} </span>
							</div>
							<div class="st_bcc_tecket_bottom_hesder float_left">
								<div class="st_bcc_tecket_bottom_left_wrapper">
									<div class="st_bcc_tecket_bottom_inner_left">
										<div class="st_bcc_teckt_bot_inner_img">
											<img src="{{ asset(config('filesystems.folder_storage_user.film') . $schedule->film?->picture) }}" alt="img" width="160px">
										</div>
										<div class="st_bcc_teckt_bot_inner_img_cont">
											<h4>{{$schedule->film?->name}}</h4>
											<h5>{{$schedule->cinemaRoom?->cinema?->name}}</h5>
											<h3>{{$schedule->show_date}} | {{$schedule->show_time}}</h3>
{{--											<h6>Carnival: Artech Central Mall,<br>--}}
{{--				Trivandrum Audi-5</h6>--}}
										</div>
										<div class="st_purchase_img">
											<img src="{{asset('assets-website')}}/images/content/pur2.png" alt="img">
										</div>
									</div>
									<div class="st_bcc_tecket_bottom_inner_right">	<i class="fas fa-chair"></i>
										<h3>{{$totalTicket}} Vé <br>
		<span>P{{$schedule->cinemaRoom?->room_code}} - {{$ticketString}}</span></h3>
									</div>
								</div>
								<div class="st_bcc_tecket_bottom_right_wrapper">
									<img src="{{asset('assets-website')}}/images/content/qr.png" alt="img">
									<h4>Booking ID<br>{{session('ticketOrder')?->ticket_number}}</h4>
								</div>
								<div class="st_bcc_tecket_bottom_left_price_wrapper">
									<h4>Tổng tiền</h4>
									<h5>{{number_format($netPrice ?? 0)}} đ</h5>
								</div>
							</div>
						</div>
						<div class="st_bcc_ticket_boxes_bottom_wrapper float_left">
							<p>Bạn có thể truy cập vé từ Hồ sơ của mình. Chúng tôi sẽ gửi cho bạn
								<br>1 cái email confirm trong vòng 15 phút tới.</p>
							<ul>
								<li><a href="{{route('auth.profile')}}">XEM ĐƠN ĐẶT</a>
								</li>
								<li><a href="{{route('client.home')}}">TIẾP TỤC</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- st bc End -->
@endsection
