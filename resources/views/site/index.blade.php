@extends('site.master')
@section('content')

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        @if(count($slide) >= 2)
            <ol class="carousel-indicators">
                @for($i=0; $i <= count($slide) - 1; $i++)
                  <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'acrive':'' }}"></li>
                @endfor
            </ol>
        @endif
        <div class="carousel-inner">
            @foreach($slide as $key => $s)
                <div class="carousel-item {{ $key == 0 ? 'active':'' }}">
                    <img class="d-block w-100" src="{{ asset('images/'.$s->image) }}" alt="{{ $s->title }}">
                </div>
            @endforeach
        </div>
        @if(count($slide) >= 2)
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        @endif
    </div>

    <div class="content">
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

    <script>
        $('.carousel').carousel({
            interval: 2000
        })
    </script>

@endsection
