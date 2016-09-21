@extends('layouts.app')
@section('title', 'Vllep')

@section('content')
  <section class="vbox">
      @include('header')
      <section class="hbox stretch">

        @include('partials.bar.left')

        <section id="content">
          <section class="vbox">
          <section class="w-f-md">
            <section class="hbox stretch bg-black dker">

              <aside class="col-sm-3 no-padder" id="sidebar">
                <section class="vbox animated fadeInUp">
                  <section class="scrollable">
                    <div class="m-t-n-xxs item pos-rlt">
                      <div class="top text-right">
                        <span class="musicbar animate bg-success bg-empty inline m-r-lg m-t" style="width:25px;height:30px">
                          <span class="bar1 a3 lter"></span>
                          <span class="bar2 a5 lt"></span>
                          <span class="bar3 a1 bg"></span>
                          <span class="bar4 a4 dk"></span>
                          <span class="bar5 a2 dker"></span>
                        </span>
                      </div>
                      <div class="bottom gd bg-info wrapper-lg">
                        <span class="pull-right text-sm">{{$data['podcast']['total_episodes']}} <br>Episodes</span>
                        <span class="h2 font-thin">{{$data['podcast']['name']}}</span>
                      </div>
                      <img class="img-full" src="{{$data['podcast']['thumbnail_600']}}">
                    </div>
                    <div class="col-md-offset-3 button-follow">
                        <button class="btn btn-lg btn-info btn-rounded {{$data['userFollows'] ? 'btn-ufllw':'btn-fllw'}}">
                            {{$data['userFollows'] ? 'Unfollow':'Follow'}}
                        </button>
                    </div>
                  </section>
                </section>
              </aside>

              <section class="col-sm-6 no-padder bg">
                <section class="vbox">
                  <section class="scrollable hover">
                    <ul class="list-group list-group-lg no-bg auto m-b-none m-t-n-xxs">
                        @foreach($data['episodes'] as $episode)
                          <li class="list-group-item clearfix">
                            <a href="#" class="jp-play-me pull-right m-t-sm m-l text-md">
                              <i class="icon-control-play text"></i>
                              <i class="icon-control-pause text-active"></i>
                                <div class="pull-right m-l">
                                    <a href="#" class="m-r-sm"><i class="icon-cloud-download"></i></a>
                                    <a href="#" class="m-r-sm"><i class="icon-plus"></i></a>
                                    <a href="#"><i class="icon-close"></i></a>
                                </div>
                            </a>
                            <a href="#" class="pull-left thumb-sm m-r">
                              <img src="{{$data['podcast']['thumbnail_100']}}" class="img-circle">
                            </a>
                            <a class="clear" href="#">
                              <span class="block text-ellipsis">{{$episode['title']}}</span>
                              <span class="text-muted">{{$episode['published_date']}}</span>
                            </a>
                          </li>
                        @endforeach
                    </ul>
                  </section>
                </section>
              </section>
            </section>
          </section>
        </section>
        </section>
      </section>
{{--
        @include('partials.player')
--}}
  </section>
@endsection

@section('footer-scripts')
    <script type="text/javascript" src="/js/partials/leftbar.js"></script>
    <script type="text/javascript" src="/js/podcast.js"></script>
@endsection
