@extends('backend.layouts.app')
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
                <h4 class="page-title">Chỉnh sửa lịch chiếu</h4>
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
                            <a href="{{ route('admin.schedule.index') }}" class="btn btn-danger mb-2">
                                Danh sách lịch chiếu
                            </a>
                        </div>
                        <div class="col-sm-7">

                        </div>
                    </div>

                    <div class="row">
                        <form action="{{ route('admin.schedule.update',['schedule_id'=>$schedulePublishFilm->id]) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Chọn rạp chiếu</label>
                                        <select class="form-select" name="cinema_id" value="{{ old('cinema_id') }}"
                                                id="cinema_id">
                                            @foreach ($cinemas as $cinema)
                                                <option value="{{ $cinema->id }}"
                                                    {{$schedulePublishFilm->cinemaRoom?->cinema?->id === $cinema->id ? 'selected' : ''}}
                                                >{{ $cinema->name }} - {{$cinema->cinema_code}}</option>
                                            @endforeach
                                        </select>
                                        @error('cinema_id')
                                        <span class="text-danger">{{ $errors->first('cinema_id') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Chọn phòng chiếu</label>
                                        <select class="form-select" name="cinema_room_id"
                                                value="{{ old('cinema_room_id') }}"
                                                id="room_code">
                                            @foreach ($cinemaRooms as $room)
                                                <option value="{{ $room->id }}" {{$schedulePublishFilm->cinema_room_id === $room->id ? 'selected' : ''}}>{{ $room->room_code }}</option>
                                            @endforeach
                                        </select>
                                        @error('cinema_room_id')
                                        <span class="text-danger">{{ $errors->first('cinema_room_id') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Chọn bộ phim</label>
                                        <select class="form-select" name="film_id" value="{{ old('film_id') }}"
                                                id="film_id">
                                            @foreach ($films as $film)
                                                <option value="{{ $film->id }}" {{$schedulePublishFilm->film_id == $film->id ? 'selected' : ''}}>{{ $film->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('film_id')
                                        <span class="text-danger">{{ $errors->first('film_id') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Ngày chiếu</label>
                                        <input type="date" class="form-control mb-1" name="show_date"
                                               value="{{ $schedulePublishFilm->show_date }}">
                                        @error('show_date')
                                        <span class="text-danger">{{ $errors->first('show_date') }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Giờ chiếu</label>
                                        <input type="time" class="form-control mb-1" name="show_time"
                                               value="{{ $schedulePublishFilm->show_time }}">
                                        @error('show_time')
                                        <span class="text-danger">{{ $errors->first('show_time') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Giá vé(vnd)</label>
                                        <input type="number" class="form-control mb-1" name="ticket_price"
                                               placeholder="10000"
                                               value="{{ $schedulePublishFilm->ticket_price }}">
                                        @error('ticket_price')
                                        <span class="text-danger">{{ $errors->first('ticket_price') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Trạng thái</label>
                                        <div class="mt-2">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio3" value="1" name="status" checked
                                                       class="form-check-input" {{$schedulePublishFilm->status == 1 ? 'checked' : ''}}>
                                                <label class="form-check-label" for="customRadio3">Hợp lệ</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio4" name="status" value="0"
                                                       class="form-check-input" {{$schedulePublishFilm->status == 0 ? 'checked' : ''}}>
                                                <label class="form-check-label" for="customRadio4">Không hợp lệ</label>
                                            </div>
                                        </div>

                                        @error('address')
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Mô tả</label>
                                        <textarea name="description"
                                                  class="form-control">{{$schedulePublishFilm->description}}</textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div>
                                * Mặc định khi tạo 1 rạp phim, mỗi rạp sẽ được tạo sẵn 10 phòng chiếu.
                            </div>
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </form>
                    </div>

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
