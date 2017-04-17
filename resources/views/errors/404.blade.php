
@extends('layouts.app')

@section('title', '404 - Not Found')

@section('content')
    <body class="bg-info dker">
    <section id="content">
        <div class="row m-n">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="text-center m-b-lg">
                    <h1 class="h text-white animated fadeInDownBig">404</h1>
                </div>
                <div class="list-group auto m-b-sm m-b-lg">
                    <a href="/" class="list-group-item">
                        <i class="fa fa-chevron-right icon-muted"></i>
                        <i class="fa fa-fw fa-home icon-muted"></i> Goto homepage
                    </a>
                </div>
            </div>
        </div>
    </section>
    </body>
@endsection
