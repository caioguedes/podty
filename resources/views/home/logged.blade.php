@include('partials.bar.left')

<section id="content">
    <section class="hbox stretch">
        <section>
            <section class="vbox">
                <section class="scrollable padder-lg" id="bjax-target" style="padding-bottom: 60px;">
                    <h2 class="font-thin m-b" id="home-title">Latests Episodes <small>({{$podcasts->count()}})</small></h2>
                    <div class="row row-sm podcasts-episodes-home">

                        @foreach($podcasts as $podcast)
                            <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                <div class="item">
                                    <div class="pos-rlt">
                                        <div class="bottom">
                                            @if($podcast['episodes'][0]['duration'])
                                                <span class="badge bg-info m-l-sm m-b-sm">
                                                  {{$podcast['episodes'][0]['duration']}}
                                              </span>
                                            @endif
                                        </div>

                                        <div class="item-overlay opacity r r-2x bg-black">
                                            <a href="#" class="center text-center play-me m-t-n active" data-toggle="class">
                                                <input type="hidden"
                                                       value="{{$podcast['episodes'][0]['media_url']}}"
                                                       data-title="{{$podcast['episodes'][0]['title']}}"
                                                       data-id="{{$podcast['episodes'][0]['id']}}"
                                                       data-image="{{$podcast['episodes'][0]['image']}}"
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
                                                <a href="#" class="pull-left m-l-sm m-b-sm button-rmv-ep">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                                <a href="/episodes/{{$podcast['episodes'][0]['id']}}" class="pull-right m-r-sm m-b-sm" target="_blank">
                                                    <i class="icon-action-redo"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <img src="{{$podcast['episodes'][0]['image'] ?: $podcast['thumbnail_100']}}" class="r r-2x img-full">
                                        </a>
                                    </div>
                                    <div class="padder-v">
                                        <a href="#" class="text-ellipsis" data-toggle="modal" data-target="#myModal{{$podcast['episodes'][0]['id']}}">{{$podcast['episodes'][0]['title']}}</a>
                                        <a href="#" class="text-ellipsis text-xs text-muted" data-toggle="modal" data-target="#myModal{{$podcast['episodes'][0]['id']}}">
                                            {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $podcast['episodes'][0]['published_at'])->diffForHumans()}}
                                        </a>
                                        <a href="/podcast/{{$podcast['slug']}}" class="text-ellipsis">{{$podcast['name']}}</a>
                                    </div>

                                    <div class="modal fade" id="myModal{{$podcast['episodes'][0]['id']}}" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-dark">
                                                <div class="modal-body" style="overflow: scroll; max-height: 300px;">
                                                    <h4 class="modal-title">{{$podcast['episodes'][0]['title']}}</h4>
                                                    <hr>
                                                    <?= !empty($podcast['episodes'][0]['content']) ? $podcast['episodes'][0]['content'] : $podcast['episodes'][0]['summary']?>
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
                @if(Route::getCurrentRoute()->uri() == '/')
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
                @endif
            </section>
        </section>
    </section>
</section>

@include('partials.connected')

<script>
    $(document).on('click', '.button-rmv-ep', function () {
        var episodeID = $(this).parent().prev().prev().find('input').attr('data-id');
        if (!episodeID) return;
        $.ajax({url: 'ajax/detachEpisode/' + episodeID});
        $(this).parent().parent().parent().parent().css('opacity', '0.1')
        $(this).remove()
    });

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
