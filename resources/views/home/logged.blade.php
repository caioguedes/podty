@include('partials.bar.left')

<section id="content">
    <section class="hbox stretch">
        <section>
            <section class="vbox">
                <section class="scrollable padder-lg" id="bjax-target" style="padding-bottom: 60px;">
                    <h2 class="font-thin m-b" id="home-title">Latests Episodes <small>({{$episodes->count()}})</small></h2>
                    <div class="row row-sm podcasts-episodes-home">
    
                        @include('partials.episodes', [
                            'removable' => true
                        ])

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
