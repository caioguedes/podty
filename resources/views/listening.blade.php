@extends('layouts.app')
@section('title', 'Listening Episodes - Podty')

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
                              <section class="scrollable padder-lg" id="bjax-target" style="padding-bottom: 60px;">
                                  <h2 class="font-thin m-b" id="home-title">Listening Episodes <small>({{$episodes->count()}})</small></h2>
                                  <div class="row row-sm podcasts-episodes-home">

                                      @foreach($episodes as $episode)
                                          <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                              <div class="item">
                                                  <div class="pos-rlt">
                                                      <div class="bottom">
                                                          @if($episode['episode']['duration'])
                                                              <span class="badge bg-info m-l-sm m-b-sm">
                                                                  {{$episode['episode']['duration']}}
                                                              </span>
                                                          @endif
                                                      </div>

                                                      <div class="item-overlay opacity r r-2x bg-black">
                                                          <a href="#" class="center text-center play-me m-t-n active" data-toggle="class">
                                                              <input type="hidden"
                                                                     value="{{$episode['episode']['media_url']}}"
                                                                     data-title="{{$episode['episode']['title']}}"
                                                                     data-id="{{$episode['episode']['id']}}"
                                                                     data-image="{{$episode['episode']['image']}}"
                                                                     data-paused-at="{{$episode['episode']['paused_at']}}"
                                                              >
                                                              <i class="icon-control-play text-active i-2x"></i>
                                                              <i class="icon-control-pause text i-2x"></i>
                                                          </a>

                                                          <div class="top m-r-sm m-t-sm">
                                                              <a href="#" class="pull-right btn-fav-ep" data-toggle="class">
                                                                  <i class="fa fa-heart-o text"></i>
                                                                  <i class="fa fa-heart text-active text-danger"></i>
                                                              </a>
                                                          </div>
                                                          <div class="bottom">
                                                              <a href="/episodes/{{$episode['episode']['id']}}" class="pull-right m-r-sm m-b-sm" target="_blank">
                                                                  <i class="icon-action-redo"></i>
                                                              </a>
                                                          </div>
                                                      </div>
                                                      <a href="#">
                                                          <img src="{{$episode['episode']['image'] ?: $episode['thumbnail_100']}}" class="r r-2x img-full">
                                                      </a>
                                                  </div>
                                                  <div class="padder-v">
                                                      <a href="#" class="text-ellipsis" data-toggle="modal" data-target="#myModal{{$episode['episode']['id']}}">{{$episode['episode']['title']}}</a>
                                                      <a href="#" class="text-ellipsis text-xs text-muted" data-toggle="modal" data-target="#myModal{{$episode['episode']['id']}}">
                                                          {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $episode['episode']['published_at'])->diffForHumans()}}
                                                      </a>
                                                      <a href="/podcasts/{{$episode['slug']}}" class="text-ellipsis">{{$episode['name']}}</a>
                                                  </div>

                                                  <div class="modal fade" id="myModal{{$episode['episode']['id']}}" role="dialog">
                                                      <div class="modal-dialog">
                                                          <div class="modal-content bg-dark">
                                                              <div class="modal-body" style="overflow: scroll; max-height: 300px;">
                                                                  <h4 class="modal-title">{{$episode['episode']['title']}}</h4>
                                                                  <hr>
                                                                  <?= !empty($episode['episode']['content']) ? $episode['episode']['content'] : $episode['episode']['summary']?>
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
                                  </div>
                              </section>
                              <div id="div-player"
                                   style="background-color:#232c32;
                            position: absolute;
                            bottom: 0;
                            width: inherit;
                            max-height: 60px;"
                                   hidden
                              >
                                  <div id="audio" style="margin-top: 7px;">
                                      <audio controls id="player" style="width: 60%;margin-left: 5px;">
                                          <source src="" id="source">
                                      </audio>
                                      <div id="playing" style="width: 38%;float: right;">
                                          <span class="center"></span>
                                      </div>
                                  </div>
                              </div>
                          </section>
                      </section>
                  </section>
              </section>

              @include('partials.connected')

              <script>
                  $(document).on('click', '.btn-fav-ep', function () {
                      var episodeID = $(this).parent().prev().find('input').attr('data-id');
                      if (!episodeID) return;
                      $.ajax({url: 'ajax/favoriteEpisode/' + episodeID});
                      $(this).removeClass('btn-fav-ep');
                      $(this).addClass('btn-unfav-ep');
                  });

                  $(document).on('click', '.btn-unfav-ep', function () {
                      var episodeID = $(this).parent().prev().find('input').attr('data-id');
                      if (!episodeID) return;
                      $.ajax({url: 'ajax/unfavoriteEpisode/' + episodeID});
                      $(this).removeClass('btn-unfav-ep');
                      $(this).addClass('btn-fav-ep');
                  });
              </script>
          </section>
        </section>
    </section>
@endsection

@section('footer-scripts')
    <script async type="text/javascript" src="js/find-podcasts.js"></script>
    <script async type="text/javascript" src="js/partials/leftbar.js?t={{time()}}"></script>
@endsection
