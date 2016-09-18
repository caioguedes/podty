@include('partials.bar.left')

<section id="content">
    <section class="hbox stretch">
        <section>
            <section class="vbox">
                <section class="scrollable padder-lg w-f-md" id="bjax-target">
                    <h2 class="font-thin m-b">
                        Discover
                      <span class="musicbar animate inline m-l-sm" style="width:20px;height:20px">
                        <span class="bar1 a1 bg-primary lter"></span>
                        <span class="bar2 a2 bg-info lt"></span>
                        <span class="bar3 a3 bg-success"></span>
                        <span class="bar4 a4 bg-warning dk"></span>
                        <span class="bar5 a5 bg-danger dker"></span>
                      </span>
                    </h2>
                    <div class="row row-sm">
                        <?php $i=0; ?>

                        @forelse($data['episodes'] as $episode)
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="item">
                                    <div class="pos-rlt">
                                        <div class="bottom">
                                            <span class="badge bg-info m-l-sm m-b-sm">03:20</span>
                                        </div>
                                        <div class="item-overlay opacity r r-2x bg-black">
                                            <div class="center text-center m-t-n">
                                                <a href="#"><i class="icon-control-play i-2x"></i></a>
                                            </div>
                                            <div class="bottom padder m-b-sm">
                                                <a href="#" class="pull-right">
                                                    <i class="fa fa-plus-circle"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <img src="{{$episode['thumbnail']}}" class="r r-2x img-full">
                                        </a>
                                    </div>
                                    <div class="padder-v">
                                        <a href="#" class="text-ellipsis">{{ $episode['title']}}</a>
                                        <a href="/podcast/{{$episode['podcast_id']}}" class="text-ellipsis text-xs text-muted">{{ $episode['podcast_name'] }}</a>
                                    </div>
                                </div>
                            </div>
                            @if ($i % 2 != 0  && $i > 0)
                                <div class="clearfix visible-xs"></div>
                            @endif
                            <?php $i++; ?>
                        @empty
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                <p>service not available.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
                @include('partials.player')
            </section>
        </section>
    </section>
</section>

@include('partials.connected')
