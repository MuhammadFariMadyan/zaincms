@extends('layouts.app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Category</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="show-error-msg" style="color:red; display:none">
                            <ul></ul>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Description" id="description"
                                      name="description"></textarea>
                        </div>
                        <button id="saveCat" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="cf nestable-lists">
                            <div class="dd" id="nestable">
                                <div id="viewCategory">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="id">
        <input type="hidden" id="modul" value="{{ Request::segment(3) }}">
        <input type="hidden" id="nestable-output">
        <input type="hidden" id="urlViewCat" value="{{ url('admin/category/view/'.Request::segment(3)) }}">
        <input type="hidden" id="urlStoreCat" value="{{ url('admin/category/store/'.Request::segment(3)) }}">
        <input type="hidden" id="urlUpdateCat" value="{{ url('admin/category/update/'.Request::segment(3)) }}">
        <input type="hidden" id="urlDeleteCat" value="{{ url('admin/category/destroy/'.Request::segment(3)) }}">
        <input type="hidden" id="urlShowCat" value="{{ url('admin/category/show/'.Request::segment(3)) }}">
    </section>

    <script src="{{ asset('js/admin/category.js') }}"></script>
@endsection
