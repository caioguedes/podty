@include('partials.bar.left')

<section id="content">
    <section class="hbox stretch">
        <section>
            <section class="vbox">
                <section class="scrollable padder-lg w-f-md" id="bjax-target">
                    <h2 class="font-thin m-b" id="home-title">Latests Episodes</h2>
                    <div class="row row-sm podcasts-episodes-home">
                    </div>
                    <div id="loading" hidden>
                        <div>
                            <div class="image-shadow"></div>
                            <div class="subtitle"></div>
                            <div class="title"></div>
                        </div>
                        <style>
                            .image-shadow {
                                background-color: darkgrey;
                                width: 130px;
                                height:130px;
                                border-radius: 3%;
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
                @include('partials.player')
            </section>
        </section>
    </section>
</section>

@include('partials.connected')
