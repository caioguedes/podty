@extends('layouts.app')
@section('title', 'Podty')

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
                                    <h2 class="font-thin m-b" id="home-title">{{$title}}</h2>
                                    <div class="row row-sm podcasts-episodes-home">
                                        @include('partials.podcasts')
                                    </div>
                                    <div id="loading" hidden>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="header-title">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 col-xs-5" style="margin-right: 50px;">
                                                <div class="image-shadow"></div>
                                                <div class="subtitle"></div>
                                                <div class="title"></div>
                                            </div>
                                            <div class="col-md-2 col-xs-4" style="margin-right: 50px;">
                                                <div class="image-shadow"></div>
                                                <div class="subtitle"></div>
                                                <div class="title"></div>
                                            </div>
                                            <div class="col-md-2 hidden-xs" style="margin-right: 20px;">
                                                <div class="image-shadow"></div>
                                                <div class="subtitle"></div>
                                                <div class="title"></div>
                                            </div>
                                            <div class="col-md-2 hidden-xs"></div>
                                            <div class="col-md-2 hidden-xs"></div>
                                            <div class="col-md-2 hidden-xs"></div>
                                        </div>
                                        <style>
                                            .header-title {
                                                background: darkgrey;
                                                width: 200px;
                                                height: 40px;
                                                margin-bottom: 20px;
                                                border-radius: 4%;
                                            }
                                            .image-shadow {
                                                background-color: darkgrey;
                                                width: 130px;
                                                height:130px;
                                                border-radius: 3%;
                                                margin-bottom: 20px;
                                            }
                                            .subtitle, .title {
                                                background-color: darkgrey;
                                                width: 110px;
                                                height: 15px;
                                                margin: 5px 0 0 5px;
                                                border-radius: 4%;
                                            }
                                        </style>
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
