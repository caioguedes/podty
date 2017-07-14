@extends('layouts.app')
@section('title', $title . ' - Podty')

@section('content')
    <section class="vbox">
          @include('header')
        <section class="padding-top-50">
          <section class="hbox stretch">

              @include('home.logged')

          </section>
        </section>
    </section>
@endsection

@section('footer-scripts')
    @if (\Illuminate\Support\Facades\Auth::user())
        <script async type="text/javascript" src="js/partials/leftbar.js"></script>
    @endif
    
    <script async type="text/javascript" src="js/find-podcasts.js"></script>
@endsection
