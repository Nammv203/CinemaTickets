@extends('backend.layouts.app')
@push('css-stack')
    <style>
        .category-description {
            max-width: 200px;
        }

        .category-img {
            max-width: 200px;
            max-height: 100px
        }

        .category-icon-delete {
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
                <h4 class="page-title">Quản lý loại phim</h4>
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
                            <a href="{{ route('admin.category.create') }}" class="btn btn-danger mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i>
                                Thêm loại phim
                            </a>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <form class="row row-cols-lg-auto g-3 align-items-end justify-content-end">
                                    <div class="col-12">
{{--                                        <label for="inputPassword2" class="visually-hidden">Password</label>--}}
                                        <input type="search" class="form-control" id="inputPassword2" name="keyword" placeholder="Tên danh mục">
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
                                    <th>Loại phim</th>
                                    <th>Mô tả</th>
                                    <th class="text-center">Hình ảnh</th>
                                    <th class="table-action"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td class="category-description">{{ $category->description }}</td>
                                        <td class="category-img text-center">
                                            <img src="{{ asset(config('filesystems.folder_storage_user.category') . $category->picture) }}"
                                                alt="category-img" width="150" />
                                        </td>
                                        <td class="table-action">
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('admin.category.edit', $category->id) }}"
                                                    class="action-icon">
                                                    <i class="mdi mdi-pencil text-primary"></i>
                                                </a>
                                                <form action="{{ route('admin.category.destroy', $category->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-bg-none m-0 p-0"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa loại phim này?')">
                                                        <i class="mdi mdi-delete category-icon-delete text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>{{$categories->links()}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
