@php
    $chairChecked = session('order') ?? [];
    $checked = false;
@endphp
    <!DOCTYPE html>

<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--[endif]-->

<head>
    @include('website.partials.head')

    <style>
        .double_chairs ul{
            display: flex;
            gap: 20px;
        }

        .double_chairs li label::after{
            width: 50px !important;
        }

        .double_chairs li label::before{
            width: 60px !important;
        }
    </style>
</head>

<body>
<!-- preloader Start -->
<div id="preloader">
    <div id="status">
        <img src="{{asset('assets-website')}}/images/header/horoscope.gif" id="preloader_image" alt="loader">
    </div>
</div>
<!-- color picker start -->
<!-- st top header Start -->
<div class="st_bt_top_header_wrapper float_left">
    <div class="container container_seat">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="st_bt_top_back_btn st_bt_top_back_btn_seatl float_left">
                    <a href="{{route('client.movies.booking',['id' => $schedule?->film?->id])}}"><i
                            class="fas fa-long-arrow-alt-left"></i> &nbsp;Trở lại</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="st_bt_top_center_heading st_bt_top_center_heading_seat_book_page float_left">
                    <h3>{{$schedule?->film?->name}} - ({{$schedule?->film?->time_duration}})phút</h3>
                    <h4>{{$schedule?->show_date}}, {{$schedule?->show_time}}</h4>
{{--                    <div style="margin-top: 15px">--}}
{{--                        <span>--}}
{{--                            Số lượng vé: <span--}}
{{--                                id="total-ticket-show">{{!empty($chairChecked) ? count($chairChecked['cb']) : 0}}</span>--}}
{{--                        </span>--}}
{{--                        <span> - </span>--}}
{{--                        <span>--}}
{{--                            Tổng tiền vé: <span id="total-price-show">{{number_format($totalTicketPrice)}}đ</span>--}}
{{--                        </span>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="st_bt_top_close_btn st_bt_top_close_btn2 float_left">
                    <a href="#" title="Hủy chỗ đặt"><i class="fa fa-times"></i></a>
                </div>
                <div class="st_seatlay_btn float_left">
                    <a id="btn-checkout" style="cursor: pointer">
                        Thanh toán ngay
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- st top header Start -->
<!-- st seat Layout Start -->
<form method="post" action="{{route('client.postCheckout')}}" class="st_seatlayout_main_wrapper float_left"
      id="form-checkout">
    @csrf
{{--    @method('POST')--}}
    <div class="container container_seat">
        <input type="hidden" name="schedule_id" value="{{$schedule->id}}">
        <div class="st_seat_lay_heading float_left">
            <h3>Màn hình chiếu</h3>
        </div>
        <div class="st_seat_full_container">
            <div class="st_seat_lay_economy_wrapper float_left">
                <div class="screen">
                    <img src="{{asset('assets-website')}}/images/content/screen.png">
                </div>
                <div class="st_seat_lay_economy_heading float_left">
                    <h3>Hạng ghế thường</h3>
                </div>
                <div class="st_seat_lay_row float_left">
                    <ul>
                        <li class="st_seat_heading_row">A</li>

                        @foreach($chairs[0] as $chairType => $chair)

                            <li
                                class="{{(!empty($chairsBooked) && in_array($chair->id, $chairsBooked)) ? 'seat_disable' : ''}}"
                            >
                                  <span>
                                    @if(!empty($chairsBooked) && in_array($chair->id, $chairsBooked))
                                          Ghế đã được đặt
                                      @else
                                          Gía ghế {{number_format(\App\Helpers\Constants::PRICE_CHAIR_TYPE_A) }}đ
                                      @endif
                                </span>
                                <input type="checkbox" value="{{$chair->id}}"
                                       id="{{$chair->id}}"
                                       name="cb[]"
                                       data-price="{{\App\Helpers\Constants::PRICE_CHAIR_TYPE_A}}"
                                    @php
                                        foreach ($chairChecked['cb'] ?? [] as $c){
                                            if($c == $chair->id){
                                                echo 'checked';
                                                break;
                                            }
                                        }
                                    @endphp
                                >
                                <label for="{{$chair->id}}"></label>
                            </li>
                        @endforeach

                        {{--                        <li class="seat_disable">--}}
                        {{--                            <input type="checkbox" id="c5" name="cb">--}}
                        {{--                            <label for="c5"></label>--}}
                        {{--                        </li>--}}

                    </ul>
                    <ul class="st_eco_second_row">

                    </ul>
                    <ul class="st_eco_second_row">

                    </ul>
                </div>
            </div>
            <div class="st_seat_lay_economy_wrapper st_seat_lay_economy_wrapperexicutive float_left">
                <div class="st_seat_lay_row float_left">
                    <ul>
                        <li class="st_seat_heading_row">B</li>
                        @foreach($chairs[1] as $chairType => $chair)
                            <li
                                class="{{(!empty($chairsBooked) && in_array($chair->id, $chairsBooked)) ? 'seat_disable' : ''}}"
                            >
                                  <span>
                                    @if(!empty($chairsBooked) && in_array($chair->id, $chairsBooked))
                                          Ghế đã được đặt
                                      @else
                                          Gía ghế {{number_format(\App\Helpers\Constants::PRICE_CHAIR_TYPE_B) }}đ
                                      @endif
                                </span>
                                <input type="checkbox" value="{{$chair->id}}"
                                       id="{{$chair->id}}" data-type="{{$chair->chair_type}}"
                                       name="cb[]"
                                       data-price="{{\App\Helpers\Constants::PRICE_CHAIR_TYPE_B}}"
                                    @php
                                        foreach ($chairChecked['cb'] ?? [] as $c){
                                             if($c == $chair->id){
                                                 echo 'checked';
                                             break;
                                             }
                                         }
                                    @endphp
                                >
                                <label for="{{$chair->id}}"></label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="st_seat_lay_economy_heading float_left">
                    <h3>Hàng ghế đôi</h3>
                </div>
                <div class="double_chairs st_seat_lay_row float_left" style="display: flex; justify-content: center;">
                    <ul>
                        <li class="st_seat_heading_row">C</li>
                        @foreach($chairs[2] as $chairType => $chair)
                            <li
                                class="{{(!empty($chairsBooked) && in_array($chair->id, $chairsBooked)) ? 'seat_disable' : ''}}"
                            >
                                  <span>
                                    @if(!empty($chairsBooked) && in_array($chair->id, $chairsBooked))
                                          Ghế đã được đặt
                                      @else
                                          Gía ghế {{number_format(\App\Helpers\Constants::PRICE_CHAIR_TYPE_C) }}đ
                                      @endif
                                </span>
                                <input type="checkbox" value="{{$chair->id}}"
                                       id="{{$chair->id}}" data-type="{{$chair->chair_type}}"
                                       name="cb[]"
                                       data-price="{{\App\Helpers\Constants::PRICE_CHAIR_TYPE_C}}"
                                    @php
                                        foreach ($chairChecked['cb'] ?? [] as $c){
                                             if($c == $chair->id){
                                                 echo 'checked';
                                             break;
                                             }
                                         }
                                    @endphp
                                >
                                <label for="{{$chair->id}}"></label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="st_seat_lay_economy_heading float_left">
                    <h3>VIP</h3>
                </div>
                <div class="st_seat_lay_row float_left" style="display: flex; justify-content: center">
                    <ul>
                        <li class="st_seat_heading_row">D</li>
                        @foreach($chairs[3] as $chairType => $chair)
                            <li
                                class="{{(!empty($chairsBooked) && in_array($chair->id, $chairsBooked)) ? 'seat_disable' : ''}}"
                            >
                                <span>
                                    @if(!empty($chairsBooked) && in_array($chair->id, $chairsBooked))
                                        Ghế đã được đặt
                                    @else
                                        Gía ghế {{number_format(\App\Helpers\Constants::PRICE_CHAIR_TYPE_D) }}đ
                                    @endif
                                </span>
                                <input type="checkbox" value="{{$chair->id}}"
                                       id="{{$chair->id}}" data-type="{{$chair->chair_type}}"
                                       data-price="{{\App\Helpers\Constants::PRICE_CHAIR_TYPE_D}}"
                                       name="cb[]"
                                    @php
                                        foreach ($chairChecked['cb'] ?? [] as $c){
                                             if($c == $chair->id){
                                                 echo 'checked';
                                             break;
                                             }
                                         }
                                    @endphp
                                >
                                <label for="{{$chair->id}}"></label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- st seat Layout End -->
@include('website.partials.script')
<!--main js file end-->
<script>
    //* Isotope js
    function protfolioIsotope() {
        if ($('.st_fb_filter_left_box_wrapper').length) {
            // Activate isotope in container
            $(".protfoli_inner, .portfoli_inner").imagesLoaded(function () {
                $(".protfoli_inner, .portfoli_inner").isotope({
                    layoutMode: 'masonry',
                });
            });

            // Add isotope click function
            $(".protfoli_filter li").on('click', function () {
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
        }
        ;
    };
    protfolioIsotope();

    function changeQty(increase) {
        var qty = parseInt($('.select_number').find("input").val());
        if (!isNaN(qty)) {
            qty = increase ? qty + 1 : (qty > 1 ? qty - 1 : 1);
            $('.select_number').find("input").val(qty);
        } else {
            $('.select_number').find("input").val(1);
        }
    }

    const scheduleTicketPrice = {{$schedule->ticket_price ?? 0}};
    const scheduleId = {{$schedule->id}};

    $(document).ready(function () {
        let totalTicketPrice = {{$totalTicketPrice}};
        let totalTicket = {{!empty($chairChecked) ? count($chairChecked['cb']) : 0}};
        // handle checkbox chair change
        $('input[name="cb[]"]').change(function () {
            console.log('chair id', $(this).attr('id'))
            console.log('checked: ', $(this).is(':checked'));

            const chairPrice = $(this).data('price');

            if ($(this).is(':checked')) {
                // checked
                totalTicketPrice += chairPrice + scheduleTicketPrice;
                totalTicket += 1;
            } else {
                // uncheck
                totalTicketPrice -= chairPrice + scheduleTicketPrice ?? 0;
                totalTicket -= 1;
            }

            $('#total-price-show').html(totalTicketPrice.toLocaleString('en-US') + ' đ')
            $('#total-ticket-show').html(totalTicket)
        })


        // handle click btn checkout
        $('#btn-checkout').click(function (e) {

            // To get their values as an array
            var checkedChairs = $('input[name="cb[]"]:checked').map(function () {
                return $(this);
            }).get();

            // if not have chair checked => alert required
            if (!checkedChairs.length) {
                alert('Bạn chưa chọn ghế ngồi! Chọn ghế và tiếp tục thanh toán!')
                return;
            }

            // trigger form checkout submit
            $('form#form-checkout').submit();
        })

        // handle btn clear checked ticket
        $('.st_bt_top_close_btn').click(function () {
            $('input[name="cb[]"]').prop("checked", false);

            // clear data
            $('#total-price-show').html(0 + ' đ')
            $('#total-ticket-show').html(0)
        })
    })
</script>
</body>

</html>