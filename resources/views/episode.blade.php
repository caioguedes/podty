@extends('layouts.app')
@section('title', 'Podty')

@section('content')
    <section class="vbox">
        @include('header')
        <section class="padding-top-50">
            <section class="hbox stretch">
                <section id="content">
                    <section class="hbox stretch">
                        <section class="scrollable">
                            <div class="text-center">
                                <div class="
                                        col-lg-4 col-lg-offset-4
                                        col-md-4 col-md-offset-4
                                        col-sm-6 col-sm-offset-4
                                        ">
                                    <h2>
                                        <a href="/podcast/{{$podcast['slug']}}">{{$podcast['name']}}</a>
                                    </h2>

                                    <img src="{{$podcast['episodes']['image'] ?: $podcast['thumbnail_600']}}" width="300">
                                    <hr>
                                    <h3>{{$podcast['episodes']['title']}}</h3>
                                    <br>
                                    <audio controls id="player" style="width: 100%">
                                        <source src="{{$podcast['episodes']['media_url']}}" id="source">
                                    </audio>

                                </div>
                            </div>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
@endsection
