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
                            <a href="{{ route('admin.film.create') }}" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i>
                                Thêm phim
                            </a>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <form class="row row-cols-lg-auto g-3 align-items-end justify-content-end">
                                    <div class="col-12">
                                        <select id="inputState" class="form-select" name="category_id">
                                            <option value="">Loại phim</option>
                                            @foreach ($categories as $c)
                                                <option {{ request('category_id') == $c->id ? 'selected' : '' }}
                                                    value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        {{--                                        <label for="inputPassword2" class="visually-hidden">Tìm kiếm</label> --}}
                                        <input type="search" class="form-control" id="inputPassword2"
                                            value="{{ request('keyword' ?? '') }}" name="keyword" placeholder="Tên phim">
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
                                    <th>Tên phim</th>
                                    <th>Thể loại</th>
                                    <th>Thời lượng</th>
                                    <th>Giá tiền</th>
                                    <th>Ngày phát hành</th>
                                    <th class="text-center">Đạo diễn</th>
                                    <th class="text-center">Ảnh</th>
                                    <th class="table-action"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($films as $film)
                                    <tr>
                                        <td>{{ $film->name }}</td>
                                        <td>{{ $film->category->name }}</td>
                                        <td>{{ $film->time_duration }}</td>
                                        <td>{{ number_format($film->amount) }}</td>
                                        <td>{{ $film->publish_at }}</td>
                                        <td class="text-center">{{ $film->derector }}</td>
                                        <td class="category-img text-center">
                                            <img src="{{ asset(config('filesystems.folder_storage_user.film') . $film->picture) }}"
                                                alt="film-img" class="img-fluid" width="150" />
                                        </td>
                                        <td class="table-action">
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('admin.film.edit', $film->id) }}" class="action-icon">
                                                    <i class="mdi mdi-pencil text-primary"></i>
                                                </a>
                                                <form action="{{ route('admin.film.destroy', $film->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-bg-none m-0 p-0"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?')">
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
            </div>
        </div>
    </div>
@endsection
