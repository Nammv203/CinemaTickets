@extends('website.layouts.bookings')
@section('page-title','Xác nhận đơn đặt')
@section('banner-title','Xác nhận')
@section('page-content')
	<!-- st bc Start -->
	<div class="st_bcc_main_main_wrapper float_left">
		<div class="st_bcc_main_wrapper">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="st_bcc_heading_wrapper float_left">	<i class="fa fa-check-circle"></i>
							<h3>Thanh toán cho <span>{{number_format($order?->grand_total ?? 0)}} đ</span> Thành công</h3>
						</div>
					</div>
					<div class="col-md-12">
						<div class="st_bcc_ticket_boxes_wrapper float_left">
							<div class="st_bcc_tecket_top_hesder float_left">
								<p>Đơn hàng của bạn đã được đặt!</p>	<span> ID {{$order?->ticket_number}} </span>
							</div>
							<div class="st_bcc_tecket_bottom_hesder float_left">
								<div class="st_bcc_tecket_bottom_left_wrapper">
									<div class="st_bcc_tecket_bottom_inner_left">
										<div class="st_bcc_teckt_bot_inner_img">
											<img src="{{ asset(config('filesystems.folder_storage_user.film') . $order?->schedule?->film?->picture) }}" alt="img" width="160px">
										</div>
										<div class="st_bcc_teckt_bot_inner_img_cont">
											<h4>{{$order?->schedule?->film?->name}}</h4>
											<h5>{{$order?->schedule?->cinemaRoom?->cinema?->name}}</h5>
											<h3>{{$order?->schedule?->show_date}} | {{$order?->schedule?->show_time}}</h3>
{{--											<h6>Carnival: Artech Central Mall,<br>--}}
{{--				Trivandrum Audi-5</h6>--}}
										</div>
										<div class="st_purchase_img">
											<img src="{{asset('assets-website')}}/images/content/pur2.png" alt="img">
										</div>
									</div>
									<div class="st_bcc_tecket_bottom_inner_right">	<i class="fas fa-chair"></i>
										<h3>{{$order?->ticketOrderItems->count()}} Vé <br>
		<span>P{{$order?->schedule?->cinemaRoom?->room_code}} - {{$ticketString}}</span></h3>
									</div>
								</div>
								<div class="st_bcc_tecket_bottom_right_wrapper">
{{--									<img src="{{asset('assets-website')}}/images/content/qr.png" alt="img">--}}
									<h4>Booking ID<br>{{$order?->ticket_number}}</h4>
								</div>
								<div class="st_bcc_tecket_bottom_left_price_wrapper">
									<h4>Tổng tiền</h4>
									<h5>{{number_format($order?->grand_total ?? 0)}} đ</h5>
								</div>
							</div>
						</div>
						<div class="st_bcc_ticket_boxes_bottom_wrapper float_left">
							<p>Bạn có thể truy cập vé từ Hồ sơ của mình.</p>
							<ul>
								<li><a href="{{route('auth.ticket-purchase-history')}}">XEM ĐƠN ĐẶT</a>
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