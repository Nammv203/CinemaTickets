@extends('backend.layouts.app')
@push('css-stack')
    <style>
        .btn-gloss {
            font-size: 12px;
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

                <h4 class="page-title">Sơ đồ ghế ngồi
                    {{ $schedulePublish->cinemaRoom->cinema->name }} -
                    {{ $schedulePublish->cinemaRoom->cinema->cinema_code }}
                    (P {{ $schedulePublish->cinemaRoom->room_code }})
                    - {{ \Carbon\Carbon::parse($schedulePublish->show_date)->format('d/m/Y') }}
                    - {{ $schedulePublish->show_time }}
                </h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-sm-5">
                            {{--                            <a href="{{ route('admin.cinema.create') }}" class="btn btn-danger mb-2"> --}}
                            {{--                                <i class="mdi mdi-plus-circle me-2"></i> --}}
                            {{--                                Thêm rạp phim --}}
                            {{--                            </a> --}}
                            <a href="{{ url()->previous() ?? route('admin.cinemas.rooms.index') }}"
                                class="btn btn-light mb-2">
                                <- Quay lại </a>

                                    <div class="">
                                        <span>Số vé đã đặt: {{ count($chairBooked) }} /
                                            {{ count($schedulePublish->cinemaRoom->cinemaRoomChairs) }}</span>
                                    </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                {{--                                modal price --}}
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#standard-modal">Bảng giá
                                    <i class="mdi mdi-cog-outline"></i></button>
                                <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Bảng giá loại ghế</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-hover table-centered mb-0">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Hạng ghế</th>
                                                            <th>Mức giá*</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="text-center">
                                                            <th>A</th>
                                                            <td><span
                                                                    class="badge bg-info p-2">{{ number_format(\App\Helpers\Constants::PRICE_CHAIR_TYPE_A) }}
                                                                    đ</span></td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th>B</th>
                                                            <td><span
                                                                    class="badge bg-info p-2">{{ number_format(\App\Helpers\Constants::PRICE_CHAIR_TYPE_B) }}
                                                                    đ</span></td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th>C</th>
                                                            <td><span
                                                                    class="badge bg-info p-2">{{ number_format(\App\Helpers\Constants::PRICE_CHAIR_TYPE_C) }}
                                                                    đ</span></td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th>D</th>
                                                            <td><span
                                                                    class="badge bg-info p-2">{{ number_format(\App\Helpers\Constants::PRICE_CHAIR_TYPE_D) }}
                                                                    đ</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-center">* Lưu ý: số tiền này sẽ được cộng thêm vào giá vé
                                                    khi khách hàng chọn hàng ghế</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>

                            <div class="text-end mt-1">
                                <button class="btn btn-sm btn-gloss btn-danger">Ghế đã đặt</button>
                                <button class="btn btn-sm btn-gloss btn-success">Ghế còn trống</button>
                            </div>
                        </div>
                    </div>

                    <div class="row table-responsive">
                        <table class="table mb-0  overflow-x-scroll">
                            <thead>
                                {{-- 20 GHE MOI HANG --}}
                                <tr>
                                    <th scope="col">Hạng</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cinemaRoomChairs as $keyChair => $chairs)
                                    <tr class="">
                                        <th scope="row" class="py-4">
                                            {{ ['A', 'B', 'C', 'D'][$keyChair] ?? '' }}
                                        </th>
                                        @foreach ($chairs as $chair)
                                            @php
                                                $badgeClass = '';

                                                if (in_array($chair->chair_code, $chairBooked)) {
                                                    $badgeClass = 'badge bg-danger p-2';
                                                } else {
                                                    $badgeClass = 'badge bg-success p-2';
                                                }
                                            @endphp
                                            <td class="py-4">
                                                <span class="{{ $badgeClass }}">
                                                    {{ $chair->chair_code }}
                                                    <i class="ri-wheelchair-line text-white"></i>
                                                </span>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
