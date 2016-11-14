@extends('layouts.app')
@section('title', $title . ' - Podty')

@section('content')
    <section class="vbox">
          @include('header')
        <section>
          <section class="hbox stretch">

              @include('home.logged')

          </section>
        </section>
    </section>
@endsection

@section('footer-scripts')
    <script async type="text/javascript" src="js/find-podcasts.js"></script>
    <script async type="text/javascript" src="js/partials/leftbar.js?t={{time()}}"></script>
@endsection
