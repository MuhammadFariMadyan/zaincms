@extends('site.master')
@section('content')

    <div class="content search">
        <div class="container">
            <div class="row container-mobile">
                @foreach ($post as $p)
                    <div class="box-blog col-md-4 col-6 col-sm-4">
                        <div class="card">
                            <a href="{{ url('/'.$p['slug_cat'].'/'.$p['slug']) }}">
                                <img class="card-img-top" src="{{ url('thumb/'.$p['image']) }}"
                                     alt="{{ $p['title'] }}">
                                <div class="card-body">
                                    <span class="date">{{ \Carbon\Carbon::parse($p['created_at'])->format('l, d F Y') }}</span>
                                    <p class="card-text">
                                        {{ $p['title'] }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
