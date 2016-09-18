@extends('layouts.app')

@section('title', 'Vllep - Sign In')

@section('head')
    <style>
        .body {
            background-image: url(/img/join-low-darker.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            height: 100vh;
        }
    </style>
@endsection

@section('content')
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="container aside-xl">
            <a class="navbar-brand block" href="/"><span class="h1 font-bold">Vllep</span></a>
            <section class="m-b-lg">
                <header class="wrapper text-center">
                    <strong>Sign in to get in touch</strong>
                </header>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control rounded input-lg text-center no-border" name="email" value="{{ old('email') }}" placeholder="Email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" class="form-control rounded input-lg text-center no-border" name="password"  placeholder="Password" >
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg btn-warning lt b-white b-2x btn-block btn-rounded">
                        <i class="icon-arrow-right pull-right"></i>
                        <span class="m-r-n-lg">Sign in</span>
                    </button>
                    <div class="text-center m-t m-b"><a href="{{ url('password/reset') }}"><small>Forgot password?</small></a></div>
                    <div class="line line-dashed"></div>
                    <p class="text-muted text-center"><small>Do not have an account?</small></p>
                    <a href="{{url('register')}}" class="btn btn-lg btn-info btn-block rounded">Create an account</a>
                </form>
            </section>
        </div>
    </section>
    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder clearfix">
            <p>
            </p>
        </div>
    </footer>
@endsection
