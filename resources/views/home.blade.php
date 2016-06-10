@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="panel-heading">What your friends are listening</div>
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <p>service not available.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-8  col-md-8 col-sm-9 col-xs-12">
            <div class="panel panel-default find">
                <div class="panel-body find-podcasts">
                    <input type="text" class="find-podcast-search">
                    <div class="find-podcast-results"><ul></ul></div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs">
            <div class="panel panel-default">
                <div class="panel-body latests-podcasts">
                    <ul class="latests-podcasts-list">
                    @forelse($data['feeds'] as $feed)
                        <li>
                            <a href="/podcast/{{$feed['id']}}" target="_blank" data-toggle="tooltip" title="{{str_replace('–', '', substr($feed['name'], 0, 13))}}">
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
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection

