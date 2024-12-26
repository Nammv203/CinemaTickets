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
                <h4 class="page-title">Quản lý phim</h4>
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
                            <a href="{{ route('admin.film.index') }}" class="btn btn-danger mb-2">
                                Danh sách phim
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
                        <form action="{{ route('admin.film.update', $film->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tên phim</label>
                                        <input type="text" class="form-control mb-1" name="name"
                                            value="{{ old('name', $film->name) }}">
                                        @error('name')
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Đạo diễn</label>
                                        <input type="text" class="form-control mb-1" name="derector"
                                            value="{{ old('derector', $film->derector) }}">
                                        @error('derector')
                                            <span class="text-danger">{{ $errors->first('derector') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Diễn viên</label>
                                        <input type="text" class="form-control mb-1" name="actor"
                                            value="{{ old('actor', $film->actor) }}">
                                        @error('actor')
                                            <span class="text-danger">{{ $errors->first('actor') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Số tiền</label>
                                        <input type="number" class="form-control mb-1" name="amount"
                                            value="{{ old('amount', $film->amount) }}">
                                        @error('amount')
                                            <span class="text-danger">{{ $errors->first('amount') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Loại phim</label>
                                        <select class="form-select" name="category_id"
                                            value="{{ old('category_id', $film->category_id) }}">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $film->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach

                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Ảnh</label>
                                        <input type="file" class="form-control mb-1" name="picture" id="pictureInput">
                                        @error('picture')
                                            <span class="text-danger">{{ $errors->first('picture') }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Trailer phim</label>
                                        <input type="text" class="form-control mb-1" name="trailer_youtube_link"
                                            value="{{ old('trailer_youtube_link', $film->trailer_youtube_link) }}">
                                        @error('trailer_youtube_link')
                                            <span class="text-danger">{{ $errors->first('trailer_youtube_link') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Thời lượng (phút)</label>
                                        <input type="number" class="form-control mb-1" step="1" min="0"
                                            name="time_duration" value="{{ old('time_duration', $film->time_duration) }}">
                                        @error('time_duration')
                                            <span class="text-danger">{{ $errors->first('time_duration') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Thời gian xuất bản</label>
                                        <input type="datetime-local" class="form-control mb-1" name="publish_at"
                                            value="{{ old('publish_at', $film->publish_at) }}">
                                        @error('publish_at')
                                            <span class="text-danger">{{ $errors->first('publish_at') }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Mô tả</label>
                                        <textarea class="form-control" rows="5" name="description">{{ old('description', $film->description) }}</textarea>
                                    </div>

                                    @if ($category->picture)
                                        <div class="form-group mb-3">
                                            <img src="{{ asset(config('filesystems.folder_storage_user.film') . $film->picture) }}"
                                            alt="Current Picture"
                                            class="img-thumbnail mt-3"
                                            alt="Vui lòng chọn ảnh"
                                            width="200"
                                            id="previewImage">
                                        </div>
                                    @endif
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
            $('#pictureInput').on('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result).show();
                    }

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
