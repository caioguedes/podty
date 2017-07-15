@extends('layouts.app')
@section('title', 'Favorites Episodes - Podty')

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
                                  <h2 class="font-thin m-b" id="home-title">Favorites Episodes <small>({{$favorites->count()}})</small></h2>
                                  <div class="row row-sm podcasts-episodes-home">

                                      @include('partials.episodes', [
                                          'episodes' => $favorites,
                                          'favorite' => true,
                                      ])
                                      
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
                      $(this).parent().parent().parent().parent().css('opacity', '0.1')
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
