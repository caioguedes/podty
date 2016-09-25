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
                    <br>
                    <div class="button-follow col-lg-offset-4">
                        <button class="btn btn-lg btn-info btn-rounded {{$data['userFollows'] ? 'btn-ufllw':'btn-fllw'}}">
                            {{$data['userFollows'] ? 'Unfollow':'Follow'}}
                        </button>
                    </div>
                  </section>
                </section>
              </aside>

              <section class="col-sm-6 no-padder bg">
                <section class="vbox">
                  <section class="scrollable hover" style="padding-bottom: 50px;">

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
                                          <a href="#" class="center text-center jp-play-me m-t-n">
                                              <i class="icon-control-play text i-2x"></i>
                                              <i class="icon-control-pause text-active  i-2x"></i>
                                          </a>
                                          <div class="bottom pull-right text-sm">
                                              <a href="#" class="pull-right text-sm m-r-sm m-b-sm">
                                                  <i class="icon-cloud-download"></i>
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
                      {{--<div>
                          <ul class="pagination center">
                              @for($i=1;$i<=$data['total_pages'];$i++)
                                  <li class="@if($i==1) active @endif"><a href="#">{{$i}}</a></li>
                              @endfor
                          </ul>
                      </div>--}}
                  </section>
                </section>
              </section>
            </section>
          </section>
        </section>
        @include('partials.player')
        </section>
      </section>
  </section>
@endsection

@section('footer-scripts')
    <script type="text/javascript" src="/js/jPlayer/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
    <script type="text/javascript" src="/js/jPlayer/demo.js"></script>

    <script type="text/javascript" src="/js/partials/leftbar.js"></script>
    <script type="text/javascript" src="/js/podcast.js"></script>
@endsection
