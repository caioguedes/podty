@include('partials.bar.left')

<section id="content">
    <section class="hbox stretch">
        <section>
            <section class="vbox">
                <section class="scrollable padder-lg" id="bjax-target">
                    <h2 class="font-thin m-b" id="home-title">{{$title}}</h2>
                    <div class="row row-sm podcasts-episodes-home">

                        @foreach($content as $podcast)
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="item">
                                    <div class="pos-rlt">
                                        <div class="bottom">
                                            <span class="badge bg-info m-l-sm m-b-sm">{{$podcast['total_episodes']}} Episodes</span>
                                        </div>
                                        <div class="item-overlay opacity r r-2x bg-black">
                                            <div class="center text-center m-t-n">
                                                <a href="/podcast/{{$podcast['id']}}">
                                                    <i class="icon-action-redo i-2x"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <img src="{{$podcast['thumbnail_600']}}" class="r r-2x img-full">
                                        </a>
                                    </div>
                                    <div class="padder-v">
                                        <a href="/podcast/{{$podcast['id']}}" class="text-ellipsis">{{$podcast['name']}}</a>
                                        <a href="/podcast/{{$podcast['id']}}" class="text-ellipsis text-xs text-muted"></a>
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
            </section>
        </section>
    </section>
</section>

@include('partials.connected')
