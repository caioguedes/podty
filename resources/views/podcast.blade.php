@extends('layouts.app')

@section('head')
    <link href="/css/podcast.css" rel="stylesheet">
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
                    @foreach ($data['episodes'] as $episode)
                        <div class="row text-left">
                            <b>{{ (new DateTime($episode['published_date']))->format('d/m/Y H:i') }}</b>
                            <br>
                            <a href="{{$episode['link']}}" target="_blank">
                                <b>{{ $episode['title'] }}</b>
                            </a>
                            <br>
                            {{Faker\Provider\Lorem::sentence(60)}}
                            <br><br>
                            <audio controls>
                                <source src={{ $episode['media_url'] }} type={{ $episode['media_type'] }}>
                            </audio>
                        </div>
                        <hr>
                    @endforeach
                </div>
                <a href="#">next</a>
            </div>
        </div>
    </div>
</div>

@endsection
