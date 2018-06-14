@foreach($category as $key => $c)
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input checked-category"
               id="{{ $c['title'] }}" value="{{ $c['id'] }}" {{ !empty($dataCat[$c['id']]['id']) == $c['id'] ? 'checked':'' }}>
        <label class="custom-control-label"
               for="{{ $c['title'] }}">{{ $c['title'] }}</label>
    </div>
    @if(array_key_exists('child', $c))
        @foreach($c['child'] as $c1)
            <div class="custom-control custom-checkbox mb-2 child-1">
                <input type="checkbox" class="custom-control-input checked-category"
                       id="{{ $c1['title'] }}" value="{{ $c1['id'] }}" {{ !empty($dataCat[$c1['id']]['id']) == $c1['id'] ? 'checked':'' }}>
                <label class="custom-control-label"
                       for="{{ $c1['title'] }}">{{ $c1['title'] }}</label>
            </div>
            @if(array_key_exists('child', $c1))
                @foreach($c1['child'] as $c2)
                    <div class="custom-control custom-checkbox mb-2 child-2">
                        <input type="checkbox"
                               class="custom-control-input checked-category"
                               id="{{ $c2['title'] }}" value="{{ $c2['id'] }}" {{ !empty($dataCat[$c2['id']]['id']) == $c2['id'] ? 'checked':'' }}>
                        <label class="custom-control-label"
                               for="{{ $c2['title'] }}">{{ $c2['title'] }}</label>
                    </div>
                    @if(array_key_exists('child', $c2))
                        @foreach($c2['child'] as $c3)
                            <div class="custom-control custom-checkbox mb-2 child-3">
                                <input type="checkbox"
                                       class="custom-control-input checked-category"
                                       id="{{ $c3['title'] }}" value="{{ $c3['id'] }}" {{ !empty($dataCat[$c3['id']]['id']) == $c3['id'] ? 'checked':'' }}>
                                <label class="custom-control-label"
                                       for="{{ $c3['title'] }}">{{ $c3['title'] }}</label>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
@endforeach

<div class="showCat" style="display: none">
    <hr>
    <div id="formCategory">
        <div class="show-error-msg" style="color:red; display:none">
            <ul></ul>
        </div>
        <div class="form-group">
            <div class="form-group">
                <input type="text" class="form-control" id="category" placeholder="Category"
                       name="category"  value="{{ old('category') }}">
            </div>
        </div>
        <input type="hidden" value="post" id="modul" name="modul">
        <div class="form-group">
            <select class="form-control" name="parent" id="parent">
                <option value="0">--Parent Category--</option>
                @foreach($category as $c)
                    <option value="{{ $c['id'] }}" {{ old('category') == $c['id'] ? 'selected':'' }}> {{ $c['title'] }} </option>
                    @if(array_key_exists('child', $c))
                        @foreach($c['child'] as $c1)
                            <option value="{{ $c1['id'] }}" {{ old('category') == $c1['id'] ? 'selected':'' }}>
                                - {{ $c1['title'] }} </option>
                            @if(array_key_exists('child', $c1))
                                @foreach($c1['child'] as $c2)
                                    <option value="{{ $c2['id'] }}" {{ old('category') == $c2['id'] ? 'selected':'' }}>
                                        -- {{ $c2['title'] }} </option>
                                    @if(array_key_exists('child', $c2))
                                        @foreach($c2['child'] as $c3)
                                            <option value="{{ $c3['id'] }}" {{ old('category') == $c3['id'] ? 'selected':'' }}>
                                                --- {{ $c3['title'] }} </option>
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