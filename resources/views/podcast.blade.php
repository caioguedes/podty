@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href="/css/podcast.css" rel="stylesheet" />
    <link href="/audio-player/audioplayer.css" rel="stylesheet" />
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div>
                <h4>
                    Latest Episodes of <br><br>
                        <img src="{{ $data['feed']['thumbnail_100'] }}" alt="" class="img-circle">
                    <b>{{ explode(' - ', $data['feed']['name'])[0] }}</b>
                    ({{ $data['feed']['total_episodes'] }})
                </h4>
            </div>
            @foreach ($data['episodes'] as $episode)
                <div class="wrapper col-lg-4 col-md-6">
                    <div class="card radius shadowDepth1">
                        <div class="card__content card__padding">
                            <div class="card__share">
                                <div class="card__social">
                                    <a class="share-icon facebook" href="#"><span class="fa fa-facebook"></span></a>
                                    <a class="share-icon twitter" href="#"><span class="fa fa-twitter"></span></a>
                                    <a class="share-icon googleplus" href="#"><span class="fa fa-google-plus"></span></a>
                                </div>
                                <a id="share" class="share-toggle share-icon" href="#"></a>
                            </div>
                            <article class="card__article">
                                <h2>
                                    <a href="{{$episode['link']}}" target="_blank">{{ $episode['title'] }}</a>
                                    <br><small>{{ (new DateTime($episode['published_date']))->format('d/m/Y H:i') }}</small>
                                </h2>
                                <p>{{Faker\Provider\Lorem::sentence(20)}}</p>
                            </article>
                        </div>
                        <div class="card__action">
                            <div class="card__author play">
                                <a class="btn center">
                                    <i class="fa fa-play-circle fa-2x play" aria-hidden="true"></i>
                                    Play
                                </a>
                                <input type="text" value="{{ $episode['media_url'] }}" id="url" hidden>
                                <input type="text" value="{{ $episode['media_type'] }}" id="type" hidden>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<footer class="audioplayer-footer" hidden>
</footer>

@endsection

@section('footer')
    <script src="/audio-player/audioplayer.js"></script>
    <script src="/js/podcast.js"></script>
@endsection
