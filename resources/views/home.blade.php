@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    search for podcasts:
                    <input type="text">
                    <hr>

                    <div class="panel-heading">Latests Feeds</div>
                    <ul>
                        @foreach($data['feeds'] as $feed)
                            <img src="{{$feed['thumbnail_30']}}">
                            <span>
                                <a href="/podcast/{{$feed['name']}}" target="_blank">
                                {{$feed['name']}}
                                </a>
                            </span>
                            <b>({{$feed['total_episodes']}})</b>
                            <br>
                            Last Episode: {{(new DateTime($feed['last_episode_at']))->format('d/m/Y H:i')}}
                            <hr>
                        @endforeach
                    </ul>

                    <div class="panel-heading">Latests Episodes</div>
                    <ul>
                        @foreach($data['episodes'] as $episode)
                            <img src="{{$episode['thumbnail_30']}}">
                            <a href="{{$episode['link']}}" target="_blank">
                                <b>{{$episode['title']}}</b>
                            </a> -
                            {{(new DateTime($episode['published_date']))->format('d/m/Y H:i')}} <br>
                            <audio controls>
                                <source src={{ $episode['media_url'] }} type={{ $episode['media_type'] }}>
                            </audio>
                            <hr>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

