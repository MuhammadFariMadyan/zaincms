@extends('site.master')
@section('content')

    @if( !empty($data->image) )
        <div class="banner bg-img" style="background-image: url('{{ url('images/'.$data->image) }}')">
        </div>
    @endif

    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12 page">
                <div class="title">
                    <h1>{{ $data->title }}</h1>
                </div>
                <div class="content">
                    {!! $data->content !!}
                </div>
            </div>
        </div>
    </div>

@endsection
