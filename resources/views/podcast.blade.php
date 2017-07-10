@extends('layouts.app')
@section('title', str_limit($data['podcast']['name'], 20) . ' - Podty')

@section('meta')
  <meta property="og:image" content="{{$data['podcast']['thumbnail_600']}}">
@endsection

@section('content')
  <section class="vbox">
      @include('header')
      <section class="hbox stretch">

        @include('partials.bar.left')

        <section id="content" class="padding-top-50">
          <section class="vbox">
          <section class="w-f-md">
            <section class="hbox stretch bg-light dk">
              <aside class="col-sm-2 no-padder bg-black" id="sidebar">
                    <div class="item pos-rlt">
                      <div class="bottom gd bg-info wrapper-md podcast-image-texts">
                        <span class="pull-right text-sm">{{$data['podcast']['total_episodes']}} <br>Episodes</span>
                        <span class="text-sm">{{count($data['listeners'])}} <br> Listeners</span>
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

                  <div style="margin-left: 5px;">
                      <h4>People who listen:</h4>
                      @forelse($data['listeners'] as $listener)
                          <a href="/profile/{{$listener['username']}}" style="margin-left:5px">
                              <img src="https://www.gravatar.com/avatar/{{$listener['email_hash']}}?d=retro"
                                   alt="{{$listener['username']}}" class="img-circle"
                                   width="40" height="40" style="margin-bottom: 5px;">
                          </a>
                      @empty
                          <h3>Be the first to follow this podcast!</h3>
                      @endforelse
                  </div>

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
                                          <a href="#" class="center text-center play-me m-t-n active" data-toggle="class">
                                              <input type="hidden"
                                                     value="{{$episode['media_url']}}"
                                                     data-title="{{$episode['title']}}"
                                                     data-id="{{$episode['id']}}"
                                                     data-image="{{($episode['image']) ?$episode['image']: $data['podcast']['thumbnail_100']}}"
                                              >
                                              <i class="icon-control-play text-active i-2x"></i>
                                              <i class="icon-control-pause text  i-2x"></i>
                                          </a>
                                          @if(Auth::user())
                                              <div class="top m-r-sm m-t-sm">
                                                  <a href="#" class="pull-right btn-fav-ep" data-toggle="class">
                                                      <i class="fa fa-heart-o text"></i>
                                                      <i class="fa fa-heart text-active text-danger"></i>
                                                  </a>
                                              </div>
                                          @endif
                                          <div class="bottom pull-right text-sm">
                                              <a href="/episodes/{{$episode['id']}}" class="pull-right text-sm m-r-sm m-b-sm" target="_blank">
                                                  <i class="icon-action-redo"></i>
                                              </a>
                                          </div>
                                      </div>
                                      <a href="#">
                                        <img src="{{($episode['image']) ?$episode['image']: $data['podcast']['thumbnail_600']}}" class="r r-2x img-full">
                                      </a>
                                  </div>
                                  <div class="padder-v">
                                      <a href="#" class="text-ellipsis" data-toggle="modal" data-target="#myModal{{$episode['id']}}">{{$episode['title']}}</a>
                                      <a href="#" class="text-ellipsis text-xs text-muted" data-toggle="modal" data-target="#myModal{{$episode['id']}}">
                                          {{ (new \DateTime($episode['published_at']))->format('d/m/Y H:i')}}
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
<script>
    $(document).on('click', '.btn-fav-ep', function () {
        var episodeID = $(this).parent().prev().find('input').attr('data-id');
        if (!episodeID) return;
        $.ajax({url: '/ajax/favoriteEpisode/' + episodeID});
        $(this).removeClass('btn-fav-ep');
        $(this).addClass('btn-unfav-ep');
    });

    $(document).on('click', '.btn-unfav-ep', function () {
        var episodeID = $(this).parent().prev().find('input').attr('data-id');
        if (!episodeID) return;
        $.ajax({url: '/ajax/unfavoriteEpisode/' + episodeID});
        $(this).removeClass('btn-unfav-ep');
        $(this).addClass('btn-fav-ep');
    });
</script>
@endsection

@section('footer-scripts')
    <script async type="text/javascript" src="/js/partials/leftbar.js?t={{time()}}"></script>
    <script async type="text/javascript" src="/js/podcast.js"></script>
@endsection
