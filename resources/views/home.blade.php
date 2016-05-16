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
                    <a href="/podcast/nerdcast">
                        <i class="fa fa-microphone" aria-hidden="true"></i>
                        - Nerdcast
                    </a>
                    <br><br>
                    <a href="/podcast/devnaestrada">
                        <i class="fa fa-microphone" aria-hidden="true"></i>
                        - Dev Na Estada
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

