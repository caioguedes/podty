@extends('layouts.app')

@section('content')
<div class="container home">
    <div class="row">
        <div class="col-lg-8  col-md-8 col-sm-9 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    search for podcasts:
                    <input type="text">
                    <p>laura wilson <br> laura wilson <br> laura wilson <br> laura wilson <br> laura wilson <br>
                    laura wilson <br> laura wilson <br> laura wilson <br>laura wilson <br> laura wilson <br> laura wilson <br>
                    laura wilson <br> laura wilson <br> laura wilson <br> laura wilson <br> laura wilson <br> laura wilson <br>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-3 hidden-xs">
            <div class="panel panel-success">
                <div class="panel-heading"><b>Latests Feeds</b></div>
                <div class="panel-body">
                    @forelse($data['feeds'] as $feed)
                        <div class="col-lg-6 col-md-5 col-sm-12">
                            <b>{{substr($feed['name'], 0, 13)}} ({{$feed['total_episodes']}})</b><br>
                            <small>{{(new DateTime($feed['last_episode_at']))->format('d/m/Y H:i')}}</small>
                            <a class="thumbnail" href="/podcast/{{$feed['id']}}" target="_blank">
                                <img src="{{$feed['thumbnail_60']}}" class="img-thumbnail">
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

