@foreach($menu as $key => $m)
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input checked-menu"
               id="{{ $m['title'] }}" value="{{ $m['id'] }}" {{ !empty($dataMenu[$m['id']]['id']) == $m['id'] ? 'checked':'' }}>
        <label class="custom-control-label"
               for="{{ $m['title'] }}">{{ $m['title'] }}</label>
    </div>
    @if(array_key_exists('child', $m))
        @foreach($m['child'] as $m1)
            <div class="custom-control custom-checkbox mb-2 child-1">
                <input type="checkbox" class="custom-control-input checked-menu"
                       id="{{ $m1['title'] }}" value="{{ $m1['id'] }}" {{ !empty($dataMenu[$m1['id']]['id']) == $m1['id'] ? 'checked':'' }}>
                <label class="custom-control-label"
                       for="{{ $m1['title'] }}">{{ $m1['title'] }}</label>
            </div>
            @if(array_key_exists('child', $m1))
                @foreach($m1['child'] as $m2)
                    <div class="custom-control custom-checkbox mb-2 child-2">
                        <input type="checkbox"
                               class="custom-control-input checked-menu"
                               id="{{ $m2['title'] }}" value="{{ $m2['id'] }}" {{ !empty($dataMenu[$m2['id']]['id']) == $m2['id'] ? 'checked':'' }}>
                        <label class="custom-control-label"
                               for="{{ $m2['title'] }}">{{ $m2['title'] }}</label>
                    </div>
                    @if(array_key_exists('child', $m2))
                        @foreach($m2['child'] as $m3)
                            <div class="custom-control custom-checkbox mb-2 child-3">
                                <input type="checkbox"
                                       class="custom-control-input checked-menu"
                                       id="{{ $m3['title'] }}" value="{{ $m3['id'] }}" {{ !empty($dataMenu[$m3['id']]['id']) == $m3['id'] ? 'checked':'' }}>
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
            <div class="form-group">
                <input type="text" class="form-control" id="menu" placeholder="menu"
                       name="menu"  value="{{ old('menu') }}">
            </div>
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