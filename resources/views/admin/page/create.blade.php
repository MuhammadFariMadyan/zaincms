@extends('layouts.app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add New Pages</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <form method="post" action="{{ url('admin/page') }}" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group {{ !empty($errors->first('title')) ? 'has-error':'' }}">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{ old('title') }}" required>
                                <div class="error">{{ $errors->first('title') }}</div>
                            </div>
                            <div class="form-group {{ !empty($errors->first('description')) ? 'has-error':'' }}">
                                <label for="editor">Content</label>
                                <textarea id="editor" class="form-control" rows="3" placeholder="Content"
                                          name="description">{{ old('description') }}</textarea>
                                <div class="error">{{ $errors->first('description') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <span>Seo</span>
                        </div>
                        <div class="card-body">
                            <div class="form-group {{ !empty($errors->first('keyword')) ? 'has-error':'' }}">
                                <label for="keyword">Keyword</label>
                                <input type="text" class="form-control" id="keyword" placeholder="Keyword"
                                       name="keyword" value="{{ old('keyword') }}">
                                <div class="error">{{ $errors->first('keyword') }}</div>
                            </div>
                            <div class="form-group {{ !empty($errors->first('description')) ? 'has-error':'' }}">
                                <label for="description-seo">Description</label>
                                <textarea id="description-seo" class="form-control" rows="3" placeholder="Description"
                                          name="seo">{{ old('seo') }}</textarea>
                                <div class="error">{{ $errors->first('seo') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <span>Publish</span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="publish" name="publish" checked class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="publish">Publish</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="draft" name="publish" class="custom-control-input" value="0">
                                    <label class="custom-control-label" for="draft">Draft</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="saveDataMenu" class="btn btn-primary float-right">Publish</button>
                        </div>
                    </div>

                    <div class="card" id="app">
                        <div class="card-header">
                            <span>Menu</span>
                        </div>
                        <div class="card-body">
                            <div id="viewMenu">
                                @foreach($menu as $key => $m)
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input checked-menu"
                                               id="{{ $m['title'] }}" value="{{ $m['id'] }}" {{ old('menu') == $m['id'] ? 'checked':'' }}>
                                        <label class="custom-control-label"
                                               for="{{ $m['title'] }}">{{ $m['title'] }}</label>
                                    </div>
                                    @if(array_key_exists('child', $m))
                                        @foreach($m['child'] as $m1)
                                            <div class="custom-control custom-checkbox mb-2 child-1">
                                                <input type="checkbox" class="custom-control-input checked-menu"
                                                       id="{{ $m1['title'] }}" value="{{ $m1['id'] }}" {{ old('menu') == $m1['id'] ? 'checked':'' }}>
                                                <label class="custom-control-label"
                                                       for="{{ $m1['title'] }}">{{ $m1['title'] }}</label>
                                            </div>
                                            @if(array_key_exists('child', $m1))
                                                @foreach($m1['child'] as $m2)
                                                    <div class="custom-control custom-checkbox mb-2 child-2">
                                                        <input type="checkbox"
                                                               class="custom-control-input checked-menu"
                                                               id="{{ $m2['title'] }}" value="{{ $m2['id'] }}" {{ old('menu') == $m2['id'] ? 'checked':'' }}>
                                                        <label class="custom-control-label"
                                                               for="{{ $m2['title'] }}">{{ $m2['title'] }}</label>
                                                    </div>
                                                    @if(array_key_exists('child', $m2))
                                                        @foreach($m2['child'] as $m3)
                                                            <div class="custom-control custom-checkbox mb-2 child-3">
                                                                <input type="checkbox"
                                                                       class="custom-control-input checked-menu"
                                                                       id="{{ $m3['title'] }}" value="{{ $m3['id'] }}" {{ old('menu') == $m3['id'] ? 'checked':'' }}>
                                                                <label class="custom-control-label"
                                                                       for="{{ $m3['title'] }}">{{ $m3['title'] }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                <div class="showMenu" style="display: none">
                                    <hr>
                                    <div id="formMenu">
                                        <div class="show-error-msg" style="color:red; display:none">
                                            <ul></ul>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="menu" placeholder="menu"
                                                   name="menu"  value="{{ old('titleMenu') }}">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="parent" id="parent">
                                                <option value="0">--Parent Menu--</option>
                                                @foreach($menu as $m)
                                                    <option value="{{ $m['id'] }}" {{ old('menu') == $m['id'] ? 'selected':'' }}> {{ $m['title'] }} </option>
                                                    @if(array_key_exists('child', $m))
                                                        @foreach($m['child'] as $m1)
                                                            <option value="{{ $m1['id'] }}" {{ old('menu') == $m1['id'] ? 'selected':'' }}>
                                                                - {{ $m1['title'] }} </option>
                                                            @if(array_key_exists('child', $m1))
                                                                @foreach($m1['child'] as $m2)
                                                                    <option value="{{ $m2['id'] }}" {{ old('menu') == $m2['id'] ? 'selected':'' }}>
                                                                        -- {{ $m2['title'] }} </option>
                                                                    @if(array_key_exists('child', $m2))
                                                                        @foreach($m2['child'] as $m3)
                                                                            <option value="{{ $m3['id'] }}" {{ old('menu') == $m3['id'] ? 'selected':'' }}>
                                                                                --- {{ $m3['title'] }} </option>
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="btn-a pull-left" id="addMenu">Add New menu</a>
                            <a class="btn-a pull-right showMenu" id="saveMenu" style="display: none">Save</a>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header">
                            <span>Featured Image</span>
                        </div>
                        <div class="card-body">
                            <div class="form-group {{ !empty($errors->first('image')) ? 'has-error':'' }}">
                                <div class="input-group">
                                    <div class="box-image" id="box-image1">
                                        <input type="file" id="file1" name="image" class="input-image"
                                               onchange="uploadImage(this, 1);" accept="image/*"/>
                                        <label class="icon-upload" for="file1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                                 viewBox="0 0 20 17">
                                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                            </svg>
                                        </label><br>
                                        <span>Pilih Gambar</span>
                                    </div>
                                    <div id="ShowImage1" class="img-responsive"></div>
                                    <div id="change-img1" class="text-center edit-image" style="display: none">
                                        <label for="file1"><i class="fa fa-edit"></i></label> |
                                        <label onclick="removeImage(1);"><i class="fa fa-trash"></i></label>
                                    </div>
                                </div>
                                <div class="error">{{ $errors->first('image') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="dataCheckedMenu" name="dataMenu">
            <input type="hidden" id="dataCheckedPlugin" name="dataPlugin">
            <input type="hidden" id="urlSaveMenu" value="{{ url('/admin/menu/save') }}">
        </form>

    </section>

    <script>
        CKEDITOR.replace('editor', {
            filebrowserBrowseUrl: '{{ asset('plugins/ckeditor/plugins/filemanager/dialog.php') }}?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl: '{{ asset('plugins/ckeditor/plugins/filemanager/dialog.php') }}?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl: '{{ asset('plugins/ckeditor/plugins/filemanager/dialog.php') }}?type=1&editor=ckeditor&fldr='
        });
    </script>

@endsection
