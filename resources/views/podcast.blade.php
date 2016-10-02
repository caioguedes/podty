@extends('layouts.app')
@section('title', str_limit($data['podcast']['name'], 20) . ' - Podty')

@section('content')
  <section class="vbox">
      @include('header')
      <section class="hbox stretch">

        @include('partials.bar.left')

        <section id="content">
          <section class="vbox">
          <section class="w-f-md">
            <section class="hbox stretch bg-light dk">
              <aside class="col-sm-3 no-padder bg-black" id="sidebar">
                <section class="vbox animated fadeInUp">
                  <section class="scrollable">
                    <div class="m-t-n-xxs item pos-rlt">
                      <div class="bottom gd bg-info wrapper-lg podcast-image-texts">
                        <span class="pull-right text-sm">{{$data['podcast']['total_episodes']}} <br>Episodes</span>
                        <span class="text-sm">{{$data['podcast']['listeners']}} <br> Listeners</span>
                      </div>
                      <img class="img-full podcast-image" src="{{$data['podcast']['thumbnail_600']}}">
                    </div>
                    <div id="audio" hidden>
                        <audio controls id="player" style="width: 100%">
                            <source src="" id="source">
                        </audio>
                        <div id="playing">
                            <span class="center"></span>
                        </div>
                    </div>
                    <br>
                    @if(Auth::user())
                      <div class="button-follow col-lg-offset-4 col-md-offset-3 col-sm-offset-3 col-xs-offset-4">
                        <button class="btn btn-lg btn-info btn-rounded {{$data['userFollows'] ? 'btn-ufllw':'btn-fllw'}}" data-follows="{{$data['userFollows']}}">
                          {{$data['userFollows'] ? 'Unfollow':'Follow'}}
                        </button>
                      </div>
                      <br>
                    @endif
                  </section>
                </section>
              </aside>

              <section class="col-sm-6 no-padder bg-light dk" style="padding-top: 10px !important;">
                <section class="vbox">
                  <section class="scrollable hover" id="podcast-list" style="padding-bottom: 10px;">
                        @foreach($data['episodes'] as $episode)
                          <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                              <div class="item">
                                  <div class="pos-rlt">
                                      <div class="bottom">
                                          @if($episode['duration'])
                                              <span class="badge bg-info m-l-sm m-b-sm">
                                                  {{$episode['duration']}}
                                              </span>
                                          @endif
                                      </div>

                                      <div class="item-overlay opacity r r-2x bg-black">
                                          <a href="#" class="center text-center play-me m-t-n">
                                              <input type="hidden"
                                                     value="{{$episode['media_url']}}"
                                                     data-title="{{$episode['title']}}"
                                                     data-id="{{$episode['id']}}"
                                                     data-image="{{($episode['image']) ?$episode['image']: $data['podcast']['thumbnail_600']}}"
                                              >
                                              <i class="icon-control-play text i-2x"></i>
                                              <i class="icon-control-pause text-active  i-2x"></i>
                                          </a>
                                          {{--<div class="bottom pull-right text-sm">
                                              <a href="#" class="pull-right text-sm m-r-sm m-b-sm">
                                                  <i class="icon-cloud-download"></i>
                                              </a>
                                          </div>--}}
                                      </div>
                                      <a href="#">
                                        <img src="{{($episode['image']) ?$episode['image']: $data['podcast']['thumbnail_600']}}" class="r r-2x img-full">
                                      </a>
                                  </div>
                                  <div class="padder-v">
                                      <a href="#" class="text-ellipsis" data-toggle="modal" data-target="#myModal{{$episode['id']}}">{{$episode['title']}}</a>
                                      <a href="#" class="text-ellipsis text-xs text-muted" data-toggle="modal" data-target="#myModal{{$episode['id']}}">
                                          {{$episode['published_date']}}
                                      </a>
                                  </div>

                                  <div class="modal fade" id="myModal{{$episode['id']}}" role="dialog">
                                      <div class="modal-dialog">
                                          <div class="modal-content bg-dark">
                                              <div class="modal-body" style="overflow: scroll; max-height: 300px;">
                                                  <h4 class="modal-title">{{$episode['title']}}</h4>
                                                  <hr>
                                                  <?= !empty($episode['content']) ? $episode['content'] : $episode['summary']?>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-info btn-rounded" data-dismiss="modal">
                                                      Close
                                                  </button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        @endforeach
                  </section>
                </section>
              </section>
            </section>
          </section>
        </section>
        </section>
      </section>
  </section>
@endsection

@section('footer-scripts')
    <script type="text/javascript" src="/js/partials/leftbar.js"></script>
    <script type="text/javascript" src="/js/podcast.js"></script>
@endsection
