@extends('layouts.app')
@section('title', $data['user']['username'] . " - Podty")

@section('content')
  <section class="vbox">
    @include('header')
      <section class="padding-top-50">
      <section class="hbox stretch">
        @include('partials.bar.left')
        <section id="content">
          <section class="vbox">
            <section class="scrollable">
              <div class="wrapper">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center m-b m-t">
                            <img src="https://www.gravatar.com/avatar/{{md5(strtolower($data['user']['email']))}}?d=retro" class="img-circle">
                            <div>
                                <div class="h3 m-t-xs m-b-xs">{{$data['user']['username']}}</div>
                            </div>
                        </div>
                        <div class="panel wrapper bg-dark">
                            <div class="row text-center">
                                <div class="col-xs-6">
                                    <span class="m-b-xs h4 block">{{$data['user']['podcasts_count']}}</span>
                                    <small class="text-muted">Podcasts</small>
                                </div>
                                <div class="col-xs-6">
                                    <span class="m-b-xs h4 block">{{$data['user']['friends_count']}}</span>
                                    <small class="text-muted">Friends</small>
                                </div>
                            </div>
                        </div>

                        @if(Auth::user())
                            <div class="col-md-offset-3 button-follow" @if(Auth::user()->name == $data['user']['username']) hidden @endif>
                                <button class="btn btn-lg btn-info btn-rounded {{$data['isFriend'] ? 'btn-ufllw':'btn-fllw'}}">
                                    {{$data['isFriend'] ? 'Unfollow':'Follow'}}
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h2>Podcasts</h2>
                        <div>
                            @foreach($data['podcasts'] as $podcast)
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="item">
                                    <div class="pos-rlt">
                                        <div class="item-overlay opacity r r-2x bg-black">
                                            <div class="center text-center m-t-n">
                                                <a href="/podcast/{{$podcast['slug']}}"><i class="icon-action-redo i-2x"></i></a>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <img src="{{$podcast['thumbnail_600']}}" class="r r-2x img-full">
                                        </a>
                                    </div>
                                    <div class="padder-v">
                                        <a href="/podcast/{{$podcast['slug']}}" class="text-ellipsis"> {{$podcast['name']}} </a>
                                        <a href="/podcast/{{$podcast['slug']}}" class="text-ellipsis text-xs text-muted"></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
              </div>
            </section>
          </section>
        </section>
        @include('partials.connected')
      </section>
    </section>
  </section>
@endsection

@section('footer-scripts')
    <script async type="text/javascript" src="/js/partials/leftbar.js?t={{time()}}"></script>
    <script async type="text/javascript" src="/js/profile.js"></script>
@endsection

