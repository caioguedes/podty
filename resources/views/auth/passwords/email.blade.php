@extends('layouts.app')

@section('title', 'Podty - Reset Password')

@section('head')
    <style>
        .body {
            background-image: url(/img/welcome-low.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            height: 100vh;
        }
    </style>
@endsection

@section('content')
    @include('header')
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="container aside-xl">
            <a class="navbar-brand block" href="/"><span class="h1 font-bold">Podty.co</span></a>
            <section class="m-b-lg m-t-lg">
                <header class="wrapper text-center">
                    <strong>Reset Password</strong>
                </header>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            <strong>{{ session('status') }}</strong>
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control rounded input-lg text-center no-border" name="email" value="{{ old('email') }}" placeholder="E-Mail">
                        </div>
                        
                        <div class="col-md-10 col-md-offset-1">
                            <button class="btn btn-lg btn-info btn-block btn-rounded">
                                <span class="m-r-n-md" style="padding-right: 25px">Reset Password</span>
                                <i class="fa fa-btn fa-envelope"></i>
                            </button>
                        </div>
                        
                        <div class="col-md-12" style="margin-top:60px;">
                            <div class="col-md-6">
                                <a href="/login" class="btn btn-md btn-info lt  btn-block btn-rounded">Login</a>
                            </div>
                            <div class="col-md-6">
                                <a href="/register" class="btn btn-md btn-info lt  btn-block btn-rounded">Register</a>
                            </div>
                        </div>

                    </form>
                </div>
            </section>
        </div>
    </section>
@endsection
