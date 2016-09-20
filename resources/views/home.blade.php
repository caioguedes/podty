@extends('layouts.app')
@section('title', 'Vllep')

@section('content')
    <section class="vbox">
          @include('header')
        <section>
          <section class="hbox stretch">
          @if(Auth::guest())
              <div style="height: 100%;/* overflow-y: scroll;*/">
                @include('home.guest')
              </div>
          @else
              @include('home.logged')
          @endif
          </section>
        </section>
    </section>
@endsection

@section('footer-scripts')
    <script type="text/javascript" src="/js/jPlayer/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
    <script type="text/javascript" src="/js/jPlayer/demo.js"></script>
    <script type="text/javascript" src="js/home.js"></script>
    <script type="text/javascript" src="js/partials/leftbar.js"></script>
@endsection
