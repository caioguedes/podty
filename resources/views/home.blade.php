
@extends('layouts.app')

@section('head')
    <link href="/css/home.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
            <div class="panel panel-default">
                <div class="panel-body latests-podcasts">
                    <ul class="latests-podcasts-list">
                        @forelse($data['episodes'] as $episode)
                            <li>
                                <a href="/podcast/{{$episode['feed_id']}}">
                                    <small class="text-center">
                                        {{substr($episode['title'], 0, 60)}}
                                    </small>
                                    <img src="{{$episode['thumbnail_30']}}" class="img-circle">
                                </a>
                            </li>
                            <br>
                        @empty
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                <p>service not available.</p>
                            </div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-lg-8  col-md-8 col-sm-9 col-xs-12">
            <div class="panel panel-default find">
                <div class="panel-body find-podcasts">
                    <input type="text" class="find-podcast-search">
                    <div class="find-podcast-results">
                        <ul></ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs">
            <div class="panel panel-default">
                <div class="panel-body latests-podcasts">
                    <ul class="latests-podcasts-list">
                    @forelse($data['feeds'] as $feed)
                        <li>
                            <a href="/podcast/{{$feed['id']}}">
                                <small>
                                    {{str_replace('–', '', substr($feed['name'], 0, 13))}} <br>
                                    {{(new DateTime($feed['last_episode_at']))->format('d/m/Y H:i')}}
                                </small>
                                <img src="{{$feed['thumbnail_60']}}" class="img-circle">
                            </a>
                        </li>
                    @empty
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                <p>service not available.</p>
                            </div>
                    @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

