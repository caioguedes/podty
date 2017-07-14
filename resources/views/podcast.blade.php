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
                          <h4 class="text-sm">Be the first to follow this podcast!</h4>
                      @endforelse
                  </div>

              </aside>

              <section class="col-sm-5 no-padder bg-black dk" style="padding-top: 10px !important;">
                <section class="vbox">
                  <section class="scrollable hover" id="podcast-list" style="padding-bottom: 10px;">
                      <div class="m-t-n-xxs item pos-rlt">
                          <ul id="podcast-ul" class="list-group list-group-lg no-radius no-border no-bg m-t-n-xxs m-b-none auto">
                              @foreach($data['episodes'] as $episode)
                                  <li class="list-group-item">
                                      <div class="pull-right m-l">
                                          @if(Auth::user())
                                              <a href="#" class="m-r-sm m-b-sm btn-fav-ep" data-toggle="class">
                                                  <i class="fa fa-heart-o text"></i>
                                                  <i class="fa fa-heart text-active text-danger"></i>
                                              </a>
                                          @endif
                                          <a href="/episodes/{{$episode['id']}}" target="_blank">
                                              <i class="icon-action-redo"></i>
                                          </a>
                                      </div>
                                  
                                      <a href="#" class="play-me active m-r-sm pull-left" data-toggle="class">
                                          <input type="hidden"
                                                 value="{{$episode['media_url']}}"
                                                 data-title="{{$episode['title']}}"
                                                 data-id="{{$episode['id']}}"
                                                 data-image="{{($episode['image']) ?$episode['image']: $data['podcast']['thumbnail_100']}}"
                                          >
                                          <i class="icon-control-play text-active i-2x"></i>
                                          <i class="icon-control-pause text i-2x"></i>
                                      </a>
                                     
                                      <div class="clear text-ellipsis m-l-xl">
                                          <span><a href="#" class="text-ellipsis" data-toggle="modal" data-target="#myModal{{$episode['id']}}">{{$episode['title']}}</a></span>
                                          <span class="text-muted pull-right m-r-lg">{{$episode['duration'] == '' ? '00:00:00' : $episode['duration']}}</span>
                                      </div>
                                      <div class="m-l-xl m-t-n-sm">
                                              {{ (new \DateTime($episode['published_at']))->format('d/m/Y H:i')}}
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
                                </li>
                              @endforeach
                          </ul>
                      </div>
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
        var episodeID = $(this).parent().next().find('input').attr('data-id');
        if (!episodeID) return;
        $.ajax({url: '/ajax/favoriteEpisode/' + episodeID});
        $(this).removeClass('btn-fav-ep');
        $(this).addClass('btn-unfav-ep');
    });

    $(document).on('click', '.btn-unfav-ep', function () {
        var episodeID = $(this).parent().next().find('input').attr('data-id');
        if (!episodeID) return;
        $.ajax({url: '/ajax/unfavoriteEpisode/' + episodeID});
        $(this).removeClass('btn-unfav-ep');
        $(this).addClass('btn-fav-ep');
    });
</script>
@endsection

@section('footer-scripts')
    @if (\Illuminate\Support\Facades\Auth::user())
        <script async type="text/javascript" src="js/partials/leftbar.js"></script>
    @endif
    <script async type="text/javascript" src="/js/podcast.js"></script>
@endsection
