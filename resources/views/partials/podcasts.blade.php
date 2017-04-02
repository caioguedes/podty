@foreach($podcasts as $podcast)
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="item">
            <div class="pos-rlt">
                <div class="bottom">
                    <span class="badge bg-info m-l-sm m-b-sm">{{$podcast['total_episodes']}} Episodes</span>
                </div>
                <div class="item-overlay opacity r r-2x bg-black">
                    <div class="center text-center m-t-n">
                        <a href="/podcast/{{$podcast['slug']}}">
                            <i class="icon-action-redo i-2x"></i>
                        </a>
                    </div>
                </div>
                <a href="#">
                    <img src="{{$podcast['thumbnail_600']}}" class="r r-2x img-full">
                </a>
            </div>
            <div class="padder-v">
                <a href="/podcast/{{$podcast['slug']}}" class="text-ellipsis">{{$podcast['name']}}</a>
                <a href="/podcast/{{$podcast['id']}}" class="text-ellipsis text-xs text-muted"></a>
            </div>
        </div>
    </div>
@endforeach
