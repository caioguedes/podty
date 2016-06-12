@extends('layouts.app')

@section('head')
    <link href="/css/podcast.css" rel="stylesheet" />
    <link href="/audio-player/audioplayer.css" rel="stylesheet" />
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        Latest Episodes of <br><br>
                            <img src="{{ $data['feed']['thumbnail_100'] }}" alt="" class="img-circle">
                        <b>{{ explode(' - ', $data['feed']['name'])[0] }}</b>
                        ({{ $data['feed']['total_episodes'] }})
                    </h4>
                </div>
                <div class="panel-body">
                    <ul>
                    @foreach ($data['episodes'] as $episode)
                        <li>
                            <b>{{ (new DateTime($episode['published_date']))->format('d/m/Y H:i') }}</b>
                            <div>
                                <b>{{ $episode['title'] }}</b>
                                <button class="play" style="background: #111; border: none;">
                                    <i class="fa fa-play-circle fa-2x play" aria-hidden="true">
                                        <input type="text" value="{{ $episode['media_url'] }}" id="url" hidden>
                                        <input type="text" value="{{ $episode['media_type'] }}" id="type" hidden>
                                    </i>
                                </button>
                            </div>
                            {{Faker\Provider\Lorem::sentence(60)}}
                        </li>
                        <hr>
                    @endforeach
                    </ul>
                </div>
                <a href="#">next</a>
            </div>
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
