@extends('layouts.app')


@section('title', $data['podcast']['name'] . ' - PodVille')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href="/css/podcast.css" rel="stylesheet" />
    <link href="/audio-player/audioplayer.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-9  col-md-8 col-sm-8 col-xs-12">
                <div class="podcast-title">
                    <h4>
                        Latest Episodes of <br><br>
                        <img src="{{ $data['podcast']['thumbnail_100'] }}" alt="" class="img-circle">
                        <b>{{$data['podcast']['name']}}</b>
                        ({{$data['podcast']['total_episodes']}})
                    </h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <div class="panel panel-default find">
                    <div class="panel-body find-episode">
                        <input type="text" class="find-episode-search form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right">
        <button class="more-podcasts" value="8">Next</button>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12 text-right podcasts-episodes">
            @forelse ($data['episodes'] as $episode)
                <div class="wrapper col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card__share">
                                <div class="card__social">
                                    <a class="share-icon facebook" href="#"><span class="fa fa-facebook"></span></a>
                                    <a class="share-icon twitter" href="#"><span class="fa fa-twitter"></span></a>
                                    <a class="share-icon googleplus" href="#"><span class="fa fa-google-plus"></span></a>
                                </div>
                                <a id="share" class="share-toggle share-icon" href="#"></a>
                            </div>
                            <article class="card-article">
                                <h4 class="text-left">
                                    <a href="{{$episode['link']}}" target="_blank" class="episode-title">{{ $episode['title'] }}</a>
                                    <br><small>{{$episode['published_date']}}</small>
                                </h4>
                                <p>{{$episode['content']}}</p>
                            </article>
                        </div>
                        <div class="card-play">
                            <button class="btn play-on">
                                <i class="fa fa-play-circle fa-3x play" aria-hidden="true"></i>
                            </button>
                            <input type="text" value="{{ $episode['media_url'] }}" id="url" hidden>
                            <input type="text" value="{{ $episode['media_type'] }}" id="type" hidden>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <p>service not available.</p>
                </div>
            @endforelse
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
