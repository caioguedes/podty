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
    <section id="content" class="m-t-lg wrapper-md animated fadeInDown">
        <div class="container aside-xl">
            <a class="navbar-brand block" href="/"><span class="h1 font-bold">Podty</span></a>
            <section class="m-b-lg">
                <header class="wrapper text-center">
                    <strong>Reset Password</strong>
                </header>

                <div class="panel-body">
                    <form method="POST" action="{{ url('/password/reset') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control rounded input-lg text-center no-border" name="email" value="{{ $email or old('email') }}" placeholder="e-mail">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control rounded input-lg text-center no-border" name="password" placeholder="password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input type="password" class="form-control rounded input-lg text-center no-border" name="password_confirmation" placeholder="confirm password">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <br>
                        <button class="btn btn-lg btn-info btn-block btn-rounded">
                            <span class="m-r-n-md" style="padding-right: 25px">Reset Password</span>
                            <i class="fa fa-refresh"></i>
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </section>
@endsection
