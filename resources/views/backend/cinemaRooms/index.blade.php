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
                <h4 class="page-title">Quản lý phòng phim {{$cinema ? 'cho rạp '.'"'.$cinema->name.'"' : ''}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-4">
            <a href="{{route('admin.cinema.index')}}" class="btn btn-info mb-3"><- Quản lý rạp phim</a>

            <h4 class="page-title">Thêm Mới</h4>

            <form action="{{ route('admin.cinemas.rooms.store') }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label">Rạp phim</label>
                            <select class="form-select" name="cinema_id" value="{{ old('cinema_id') }}"
                                    id="cinema_id">
                                @foreach ($cinemas as $cinema)
                                    <option
                                        value="{{ $cinema->id }}" {{request('cinema_id') && request('cinema_id') != $cinema->id ? 'disabled' : ''}}>{{ $cinema->name }}</option>
                                @endforeach
                            </select>
                            @error('cinema_id')
                            <span class="text-danger">{{ $errors->first('cinema_id') }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label">Mã phòng</label>
                            <input type="text" class="form-control mb-1" name="room_code" value="{{old('room_code')}}">
                            @error('room_code')
                            <span class="text-danger">{{ $errors->first('room_code') }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description">{{old('description')}}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <p>* Mặc định khi tạo 1 phòng phim, mỗi phòng sẽ được tạo sẵn 80 ghế ngồi.</p>
                <button type="submit" class="btn btn-primary">Xác nhận</button>
            </form>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        {{--                        <div class="col-sm-5">--}}
                        {{--                            <a href="{{ route('admin.cinema.create') }}" class="btn btn-danger mb-2">--}}
                        {{--                                <i class="mdi mdi-plus-circle me-2"></i>--}}
                        {{--                                Thêm rạp phim--}}
                        {{--                            </a>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="col-sm-7">--}}
                        {{--                            <div class="text-sm-end">--}}
                        {{--                                <button type="button" class="btn btn-success mb-2 me-1"><i--}}
                        {{--                                        class="mdi mdi-cog-outline"></i></button>--}}
                        {{--                                <button type="button" class="btn btn-light mb-2 me-1">Import</button>--}}
                        {{--                                <button type="button" class="btn btn-light mb-2">Export</button>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>

                    <div class="row">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên rạp phim</th>
                                <th>Mã rạp phim</th>
                                <th>Mã phòng</th>
                                <th></th>

                                <th class="table-action">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cinemaRooms as $key => $room)
                                <tr>
                                    <td><a href="{{route('admin.cinemas.rooms.show', $room->id)}}">{{$key + 1}}</a></td>
                                    <td>{{ $room?->cinema?->name }}</td>
                                    <td>{{ $room?->cinema?->cinema_code }}</td>
                                    <td>{{ $room->room_code }}</td>
                                    <td>
                                        <a href="{{route('admin.rooms-chairs.index',['room_id'=>$room->id])}}"
                                           class="btn btn-info">Quản lý chỗ ngồi <i
                                                class="mdi mdi-pencil text-white"></i></a>
                                    </td>

                                    <td class="table-action">
                                        <div class="d-flex justify-content-around">
                                            <a href="{{ route('admin.cinemas.rooms.show', $room->id) }}"
                                               class="action-icon">
                                                <i class="mdi mdi-pencil text-primary"></i>
                                            </a>
                                            <form action="{{ route('admin.cinemas.rooms.destroy', $room->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-bg-none m-0 p-0"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa rạp phim này?')">
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
                </div>
                {{$cinemaRooms->links()}}
            </div>
        </div>
    </div>
@endsection
