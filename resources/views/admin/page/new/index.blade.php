@extends('admin.layout.master')

@section('title')
News
@endsection

@section('content')

<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">News</h4>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div id="selection-element">
                                    <div class="my-n1 d-flex align-items-center text-muted">
                                        Select <div id="select-content" class="text-body fw-semibold px-1"></div> Result
                                        <button type="button" class="btn btn-link link-danger p-0 ms-3 material-shadow-none" data-bs-toggle="modal" data-bs-target="#removeItemModal">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card header -->

                    @if ($listNews->isEmpty())
                        <p class="text-center text-muted">Không có tin tức nào để hiển thị.</p>
                    @else
                        <div class="mb-3">
                            <button class="btn btn-primary">
                                <a href="{{route('new_admin.create')}}" class="text-decoration-none text-white">Thêm tin tức</a>
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="tab-content text-muted">
                                <div class="tab-pane active" id="productnav-all" role="tabpanel">
                                    <div class="table-card gridjs-border-none">
                                        <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
                                            <div class="gridjs-wrapper" style="height: auto;">
                                                <table class="gridjs-table" role="grid" style="height: auto;">
                                                    <thead class="gridjs-thead">
                                                        <tr class="gridjs-tr">
                                                            <th class="gridjs-th text-muted" style="width: 40px;">#</th>
                                                            <th class="gridjs-th text-muted" style="width: 94px;">STT</th>
                                                            <th class="gridjs-th text-muted" style="width: 300px;">Tiêu đề</th>
                                                            <th class="gridjs-th text-muted" style="width: 105px;">Người đăng</th>
                                                            <th class="gridjs-th text-muted" style="width: 360px;">Nội dung ngắn</th>
                                                            <th class="gridjs-th text-muted" style="width: 105px;">Danh mục tin tức</th>
                                                            <th class="gridjs-th text-muted" style="width: 140px;">Trạng thái</th>
                                                            <th class="gridjs-th text-muted" style="width: 140px;">Ngày công khai</th>
                                                            <th class="gridjs-th text-muted" style="width: 80px;">Hành động</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($listNews as $key => $News)
                                                        <tr class="gridjs-tr">
                                                            <td class="gridjs-td">
                                                                <div class="form-check checkbox-product-list">
                                                                    <input class="form-check-input" type="checkbox" value="{{ $News->id }}" id="checkbox-{{$News->id}}">
                                                                    <label class="form-check-label" for="checkbox-{{$News->id}}"></label>
                                                                </div>
                                                            </td>
                                                            <td class="gridjs-td">{{$key + 1}}</td>
                                                            <td class="gridjs-td">{{$News->title}}</td>
                                                            <td class="gridjs-td">{{$News->author->name}}</td>
                                                            <td class="gridjs-td">{{$News->short_content}}</td>
                                                            <td class="gridjs-td">{{$News->categoryNews->title}}</td>
                                                            <td class="gridjs-td">{{$News->status}}</td>
                                                            <td class="gridjs-td">{{$News->published_at}}</td>
                                                            <td class="gridjs-td">
                                                                <div class="d-flex">
                                                                    <a href="{{ route('new_admin.show', $News->id) }}" class="btn btn-success me-2"><i class="bi bi-eye-fill"></i></a>
                                                                    <a href="{{ route('new_admin.edit', $News->id) }}" class="btn btn-warning me-2"><i class="bi bi-pencil-square"></i></a>

                                                                    <form action="{{route('new_admin.destroy', $News->id)}}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa tin tức này?')">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
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
                        </div>
                    @endif
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    </div>
</div>

@endsection
