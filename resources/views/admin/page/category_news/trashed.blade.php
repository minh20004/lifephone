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
                <div>
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div id="selection-element">
                                        <div class="my-n1 d-flex align-items-center text-muted">
                                            Select <div id="select-content" class="text-body fw-semibold px-1"></div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3 material-shadow-none" data-bs-toggle="modal" data-bs-target="#removeItemModal">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card header -->

                        <div><button class="btn btn-primary "><a style="color: yellow;" href="{{route('category_news.create')}}">thêm</a></button></div>
                        @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
                        <div class="card-body">
                            <div class="tab-content text-muted">
                                <div class="tab-pane active" id="productnav-all" role="tabpanel">
                                    <div id="table-product-list-all" class="table-card gridjs-border-none">
                                        <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
                                            <div class="gridjs-wrapper" style="height: auto;">
                                                <table role="grid" class="gridjs-table" style="height: auto;">
                                                    <thead class="gridjs-thead">
                                                        <tr class="gridjs-tr">
                                                            <th data-column-id="#" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 40px;">
                                                                <div class="gridjs-th-content">#</div>
                                                            </th>
                                                            <th data-column-id="product" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 94px;">
                                                                <div class="gridjs-th-content">STT</div>
                                                            </th>
                                                            <th data-column-id="product" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 300px;">
                                                                <div class="gridjs-th-content">Tiêu đề</div>
                                                            </th>
                                                            <th data-column-id="action" class="gridjs-th gridjs-th-sort text-muted" tabindex="0" style="width: 100px;">
                                                                <div class="gridjs-th-content">Hành động</div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="gridjs-tbody">
                                                        @foreach ($trashedNews as $key => $cate)
                                                        <tr class="gridjs-tr">
                                                            <td data-column-id="#" class="gridjs-td">
                                                                <span>
                                                                    <div class="form-check checkbox-product-list">
                                                                        <input class="form-check-input" type="checkbox" value="3" id="checkbox-3">
                                                                        <label class="form-check-label" for="checkbox-3"></label>
                                                                    </div>
                                                                </span>
                                                            </td>
                                                            <td data-column-id="STT" class="gridjs-td">{{$key+1}}</td>
                                                            <td data-column-id="orders" class="gridjs-td">{{$cate->title}}</td>
                                                            <td data-column-id="action" class="gridjs-td">
                                                                <div>
                                                                <form action="{{ route('category_news.restore', $cate->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit" class="btn btn-success">Khôi phục</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                                <div class="d-flex justify-content-end mt-3">
                                                    {{ $trashedNews->links() }}
                                                </div>


                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
