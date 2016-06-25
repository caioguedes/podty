@extends('layouts.app')
@section('title', 'PodVille')

@section('head')
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="/css/home.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
            <div class="panel panel-default">
                <div class="panel-body latests-episodes">
                    <ul class="latests-episodes-list">
                        <?php $i=0; ?>
                        @forelse($data['episodes'] as $episode)
                            <li>
                                <a href="/podcast/{{$episode['podcast_id']}}" class="text-center">
                                    <small class="text-center episode-title">
                                        {{ $episode['title']}}
                                    </small>
                                    <img src="{{$episode['thumbnail_30']}}" class="img-circle" >
                                </a>
                            </li>
                            <?php $i++; ?>
                            @if($i < count($data['episodes'])) <hr> @endif
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
                    <input type="text" class="find-podcast-search form-control">
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
                    @forelse($data['podcasts'] as $podcast)
                        <li>
                            <a href="/podcast/{{$podcast['id']}}">
                                <span class="podcast-title">
                                    {{$podcast['name']}}
                                </span><br>
                                <span class="podcast-date">
                                    {{$podcast['last_episode_at']}}
                                </span>
                                <span class="podcast-img">
                                    <img src="{{$podcast['thumbnail_60']}}" class="img-circle">
                                </span>
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

@section('footer')
    <script src="/js/home.js"></script>
@endsection
