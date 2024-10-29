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
                                                        @foreach ($cate as $key => $cate_news)
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
                                                            <td data-column-id="orders" class="gridjs-td">{{$cate_news->title}}</td>
                                                            <td data-column-id="action" class="gridjs-td">
                                                                <div>
                                                                    <a href="{{ route('category_news.edit', $cate_news->id) }}" class="btn btn-warning me-2">Edit</a>
                                                                    <form action="{{route('category_news.destroy',$cate_news->id)}}" method="post">

                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button class="btn btn-danger" onclick="return confirm('xoa')">Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>
                                            <div class="gridjs-footer">
                                                <div class="gridjs-pagination">
                                            
                                                </div>
                                            </div>
                                            <div id="gridjs-temp" class="gridjs-temp"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab pane -->

                                <div class="tab-pane" id="productnav-draft" role="tabpanel">
                                    <div class="py-4 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px">
                                        </lord-icon>
                                        <h5 class="mt-4">Sorry! No Result Found</h5>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                            </div>
                            <!-- end tab content -->

                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
</div>
@endsection