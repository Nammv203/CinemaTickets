@extends('backend.layouts.app')
@push('css-stack')
    <style>
        .category-img {
            max-width: 200px;
            max-height: 100px
        }

        .icon-delete {
            font-size: 20px;
        }
    </style>
@endpush

@section('content-page')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                {{-- <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div> --}}
                <h4 class="page-title">Quản lý vé</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            {{--                            <a href="{{ route('admin.order.create') }}" class="btn btn-danger mb-2">--}}
                            {{--                                <i class="mdi mdi-plus-circle me-2"></i>--}}
                            {{--                                Thêm vé đặt--}}
                            {{--                            </a>--}}
                        </div>
                        <div class="col-sm-12">
                            <div class="text-sm-end">
                                <form class="row row-cols-lg-auto g-3 align-items-end justify-content-end">
                                    <div class="col-12">
                                        <label class="form-label">Rạp phim</label>
                                        <select id="cinema_id" class="form-select" name="cinema_id">
                                            <option value="">Chọn rạp phim</option>
                                            @foreach ($cinemas as $c)
                                                <option {{ request('cinema_id') == $c->id ? 'selected' : '' }}
                                                        value="{{ $c->id }}">{{ $c->name }}
                                                    - {{ $c->cinema_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Phòng chiếu</label>
                                        <select id="room_code" class="form-select" name="cinema_room_id">
                                            <option value="">Chọn phòng chiếu</option>

                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Trạng thái</label>
                                        <select id="inputState" class="form-select" name="status">
                                            <option value="" selected>Chọn trạng thái</option>
                                            <option
                                                {{ (int)request('status') === 1 ? 'selected' : '' }}
                                                value="1">Đã thanh toán
                                            </option>
                                            <option
                                                {{ (int)request('status') === 2 ? 'selected' : '' }}
                                                value="2">Đã checkin
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Ngày bắt đầu</label>
                                        <input type="date" class="form-control date" id="start_date" name="start_date">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Ngày kết thúc</label>
                                        <input type="date" class="form-control date" id="end_date" name="end_date">
                                    </div>
                                    <div class="col-12">
                                        <input name="id" value="{{request('id') ?? ''}}" class="form-control"
                                               placeholder="Số vé(ID)">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    </div>
                                    <div class="col-12">
                                        <a class="btn btn-info" href="{{ route('admin.order.index') }}">Hủy bỏ</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                            <tr>
                                <th>Số vé (ID)</th>
                                <th>Khách hàng</th>
                                <th>Rạp - phòng phim</th>
                                <th>Số ghế</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th class="table-action"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        {{--                                        <a href="{{route('admin.order.edit',$order->id)}}">--}}
                                        {{ $order->ticket_number }}
                                        {{--                                        </a>--}}
                                    </td>
                                    <td>{{ $order->user?->name }}</td>
                                    <td>
                                        {{$order->schedule?->cinemaRoom->cinema->name}}
                                        - {{$order->schedule?->cinemaRoom->room_code}}
                                    </td>
                                    <td>
                                        @php
                                            $chairCodeArr = $order->ticketOrderItems?->pluck('chair_code')->toArray();
                                        @endphp
                                        {{ !empty($chairCodeArr) ? implode(', ', $chairCodeArr) : '' }}
                                    </td>
                                    <td>{{ number_format($order->grand_total) }}</td>
                                    <td>
                                        <select class="form-select select-status-ticket-order"
                                                data-id="{{ $order->id }}">
                                            @foreach (config('constant.STATUS_TICKET_ORDER') as $key => $val)
                                                <option
                                                    value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                                    {{ $val }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>{{ \Carbon\Carbon::parse($order->created_at)?->format('Y-m-d') }}</td>

                                    <td class="table-action">
                                        {{--                                        <div class="d-flex justify-content-around">--}}
                                        {{--                                            <a href="{{ route('admin.order.edit', $order->id) }}" class="action-icon">--}}
                                        {{--                                                <i class="mdi mdi-pencil text-primary"></i>--}}
                                        {{--                                            </a>--}}
                                        {{--                                            <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST">--}}
                                        {{--                                                @csrf--}}
                                        {{--                                                @method('DELETE')--}}

                                        {{--                                                <button type="submit" class="btn btn-bg-none m-0 p-0"--}}
                                        {{--                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')">--}}
                                        {{--                                                    <i class="mdi mdi-delete icon-delete text-danger"></i>--}}
                                        {{--                                                </button>--}}
                                        {{--                                            </form>--}}
                                        {{--                                        </div>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ $orders->links() }}
@endsection
@push('script-stack')
    <script>
        $(document).ready(function () {
            const currentCinemaRoomIdSelected = {{request('cinema_room_id') ?? 0}};

            function get_rooms_by_cinema() {

                if ($('#cinema_id').val()) {
                    callApiRenderRoom($('#cinema_id').val());
                }

                $('#cinema_id').change(function () {
                    let cinemaId = $(this).val();

                    callApiRenderRoom(cinemaId);
                })
            }

            // function call ajax
            function callApiRenderRoom(cinemaId) {
                $.ajax({
                    url: '/admin/cinemas/' + cinemaId + '/cinema-rooms?limit=9999',
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function (data) {

                        $("#room_code").empty();

                        $.each(data?.data?.data ?? data?.data, function (key, value) {

                            $('#room_code').append('<option value="' + value.id +
                                `" ${currentCinemaRoomIdSelected == value.id ? 'selected' : ''}>` + value.room_code + '  </option>')
                        })
                    },
                    error: function (error) {
                        console.log('error', error)
                    }
                })
            }

            function changeStatus() {
                $('.select-status-ticket-order').on('change', function () {
                    let status = $(this).val();
                    let id = $(this).data('id');

                    $.ajax({
                        url: '/admin/order/' + id,
                        type: 'PATCH',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            status: status
                        },
                        success: function (response) {
                            toastr.success(response.message);
                        },
                        error: function (error) {
                            toastr.error(error.message);
                        }
                    });
                });
            }

            // call function
            get_rooms_by_cinema();
            changeStatus();
        })
    </script>
@endpush