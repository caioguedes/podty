@extends('layouts.app')

@section('content')
<div class="container home">
    <div class="row">

        <div class="col-lg-9  col-md-9 col-sm-9 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <input type="text" class="find-podcast-search">
                </div>
                <div class="find-podcast-results"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
            <div class="panel panel-default">
                <div class="panel-body">
                    @forelse($data['feeds'] as $feed)
                        <div class="col-lg-6 col-md-5 col-sm-12">
                            <a href="/podcast/{{$feed['id']}}" target="_blank">
                                <div class="img-data">
                                <img src="{{$feed['thumbnail_60']}}" class="img-circle">
                                </div>
                                <div class="metadata">
                                    <b>{{str_replace('–', '', substr($feed['name'], 0, 13))}}</b><br>
                                    <small>{{(new DateTime($feed['last_episode_at']))->format('d/m/Y H:i')}}</small>
                                </div>


                            </a>
                        </div>
                    @empty
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                <p>service not available.</p>
                            </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

