@extends('layouts.app')
@section('title', 'My Podcasts - Podty')

@section('content')
    <section class="vbox">
        @include('header')
        <section class="padding-top-50">
            <section class="hbox stretch">

                @include('partials.bar.left')

                <section id="content">
                    <section class="hbox stretch">
                        <section>
                            <section class="vbox">
                                <section class="scrollable padder-lg" id="bjax-target">
                                    <h2 class="font-thin m-b" id="home-title">My Podcasts <small>({{$podcasts->count()}})</small></h2>
                                    <div class="row row-sm podcasts-episodes-home">
                                        @include('partials.podcasts')
                                    </div>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>

                @include('partials.connected')

            </section>
        </section>
    </section>
@endsection

@section('footer-scripts')
    <script async type="text/javascript" src="js/find-podcasts.js"></script>
    <script async type="text/javascript" src="js/partials/leftbar.js?t={{time()}}"></script>
@endsection
