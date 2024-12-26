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
                <h4 class="page-title">Quản lý vé đặt</h4>
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
                            <a href="{{ route('admin.order.index') }}" class="btn btn-danger mb-2">
                                Danh sách vé đặt
                            </a>
                        </div>
                        <div class="col-sm-7">
                            {{-- <div class="text-sm-end">
                                <button type="button" class="btn btn-success mb-2 me-1"><i
                                        class="mdi mdi-cog-outline"></i></button>
                                <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div> --}}
                        </div>
                    </div>

                    <div class="row">
                        <form action="{{ route('admin.order.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Khách hàng</label>
                                        <select class="form-select" name="user_id" value="{{ old('user_id') }}">
                                            <option value="">Chọn khách hàng</option>

                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Lịch chiếu</label>
                                        <select class="form-select" name="schedule_id" value="{{ old('schedule_id') }}">
                                            <option value="">Chọn lịch chiếu</option>

{{--                                            @foreach($users as $user)--}}
{{--                                                <option value="{{$user->id}}">{{$user->name}}</option>--}}
{{--                                            @endforeach--}}
                                        </select>
                                        @error('schedule_id')
                                            <span class="text-danger">{{ $errors->first('schedule_id') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Trạng thái</label>
                                        <div class="mt-2">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio3" value="0" name="status" class="form-check-input">
                                                <label class="form-check-label" for="customRadio3" >Chưa thanh toán</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio4" name="status" value="1" class="form-check-input">
                                                <label class="form-check-label" for="customRadio4">Đã thanh toán</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio5" name="status" value="2" class="form-check-input">
                                                <label class="form-check-label" for="customRadio5">Đã Checkin</label>
                                            </div>
                                        </div>
                                        @error('status')
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Chọn ghế ngồi</label>
                                        <div>
                                            <button type="submit" class="btn btn-info">Chọn</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Trailer phim</label>
                                        <input type="text" class="form-control mb-1" name="trailer_youtube_link"
                                            value="{{ old('trailer_youtube_link') }}">
                                        @error('trailer_youtube_link')
                                            <span class="text-danger">{{ $errors->first('trailer_youtube_link') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Thời lượng (phút)</label>
                                        <input type="number" class="form-control mb-1" step="1" min="0"
                                            name="time_duration" value="{{ old('time_duration') }}">
                                        @error('time_duration')
                                            <span class="text-danger">{{ $errors->first('time_duration') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Thời gian xuất bản</label>
                                        <input type="datetime-local" class="form-control mb-1" name="publish_at"
                                            value="{{ old('publish_at') }}">
                                        @error('publish_at')
                                            <span class="text-danger">{{ $errors->first('publish_at') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Tiền hạng ghế</label>
                                        <input type="number" disabled class="form-control mb-1" name="amount"
                                               value="{{ old('amount') }}">
                                        @error('amount')
                                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tổng tiền thanh toán</label>
                                        <input type="number" disabled class="form-control mb-1" name="amount"
                                               value="{{ old('amount') }}">
                                        @error('amount')
                                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                                        @enderror
                                    </div>
                                </div>
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

        });
    </script>
@endpush
