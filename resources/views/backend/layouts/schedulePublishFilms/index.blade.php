@extends('backend.layouts.app')
@push('css-stack')
    <style>
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
                <h4 class="page-title">Quản lý lịch chiếu</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-3 justify-content-between">
                        <div class="col-sm-3">
                            <a href="{{ route('admin.schedule.create') }}" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i>
                                Thêm lịch chiếu
                            </a>
                        </div>
                        <div class="col-sm-9">
                            <div class="text-sm-end">
                                <form class="row row-cols-lg-auto g-3 align-items-end justify-content-end">
{{--                                    <div class="col-12">--}}
{{--                                        <!-- Single Select -->--}}
{{--                                        <select class="form-control select2" data-toggle="select2">--}}
{{--                                            <option>Select</option>--}}
{{--                                            <optgroup label="Alaskan/Hawaiian Time Zone">--}}
{{--                                                <option value="AK">Alaska</option>--}}
{{--                                                <option value="HI">Hawaii</option>--}}
{{--                                            </optgroup>--}}
{{--                                            <optgroup label="Pacific Time Zone">--}}
{{--                                                <option value="CA">California</option>--}}
{{--                                                <option value="NV">Nevada</option>--}}
{{--                                                <option value="OR">Oregon</option>--}}
{{--                                                <option value="WA">Washington</option>--}}
{{--                                            </optgroup>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="col-12">
                                        <select id="cinema_id" class="form-select" name="cinema_id">
                                            <option value="">Chọn rạp phim</option>
                                            @foreach ($cinemas as $c)
                                                <option {{ request('cinema_id') == $c->id ? 'selected' : '' }}
                                                        value="{{ $c->id }}">{{ $c->name }} - {{ $c->cinema_code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <select id="room_code" class="form-select" name="cinema_room_id">
                                            <option value="">Chọn phòng chiếu</option>

                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <select id="inputState" class="form-select" name="status">
                                            <option value="" selected>Chọn trạng thái</option>
                                            <option
{{--                                                {{ request('status') == 1 ? 'selected' : '' }}--}}
                                                        value="1">Active</option>
                                            <option
{{--                                                {{ (int)request('status') === 0 ? 'selected' : '' }}--}}
                                                        value="0">DeActive</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Rạp phim</th>
                                    <th>Phòng chiếu</th>
                                    <th>Tên bộ phim</th>
                                    <th>Ngày chiếu</th>
                                    <th>Giờ chiếu</th>
                                    <th>Giá vé*</th>
                                    <th>Trạng thái</th>
                                    <th class="table-action">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedulePublishFilms as $key => $schedule)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.schedule.show', $schedule->id) }}">
                                                {{ $key + 1 }}
                                            </a>
                                        </td>
                                        <td>{{$schedule?->cinemaRoom?->cinema?->name}} - {{$schedule?->cinemaRoom?->cinema?->cinema_code}}</td>
                                        <td>{{ $schedule?->cinemaRoom?->room_code }}</td>
                                        <td>{{ $schedule?->film?->name }}</td>
                                        <td>{{ $schedule->show_date }}</td>
                                        <td>{{ $schedule->show_time }}</td>
                                        <td>{{ number_format($schedule->ticket_price) }}đ</td>
                                        <td>
                                            <span class="badge bg-{{$schedule->status ? 'success' : 'secondary'}}">{{ $schedule->status ? 'Active' : 'InActive' }}</span>
                                        </td>

                                        <td class="table-action">
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('admin.schedule.show', $schedule->id) }}" class="action-icon">
                                                    <i class="mdi mdi-pencil text-primary"></i>
                                                </a>
                                                <form action="{{ route('admin.schedule.destroy', $schedule->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-bg-none m-0 p-0"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa items này?')">
                                                        <i class="mdi mdi-delete icon-delete text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$schedulePublishFilms->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-stack')
    <script>
        $(document).ready(function() {
            function get_rooms_by_cinema() {
                $('#cinema_id').change(function() {
                    let cinemaId = $(this).val();

                    $.ajax({
                        url: '/admin/cinemas/' + cinemaId + '/cinema-rooms?limit=9999',
                        type: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        },
                        success: function(data) {

                            $("#room_code").empty();

                            $.each(data?.data?.data ?? data?.data, function(key, value) {

                                $('#room_code').append('<option value="' + value.id +
                                    '">' + value.room_code + '  </option>')
                            })
                        },
                        error: function(error) {
                            console.log('error', error)
                        }
                    })
                })
            }

            // call function
            get_rooms_by_cinema();
        })
    </script>
@endpush
