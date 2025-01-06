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
                        <div class="col-sm-5">
                            <a href="{{ route('admin.schedule.create') }}" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i>
                                Thêm lịch chiếu
                            </a>
                        </div>
                        <div class="col-sm-2">
                            <div class="text-sm-end">
                                <select class="form-select" name="cinema_id" id="select-cinema_id">
                                    <option>-Lọc theo rạp-</option>
                                </select>
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
