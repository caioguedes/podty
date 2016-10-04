@extends('layouts.app')
@section('title', 'Podty')

@section('content')
    <section class="vbox">
        @include('header')
        <section>
            <section class="hbox stretch">
                @include('home.logged')
            </section>
        </section>
    </section>
@endsection

@section('footer-scripts')
    <script type="text/javascript">
        $(window).load(function(){
            getHomeNoFeed();
            var findPodcastResults = $('.podcasts-episodes-home');
            function getHomeNoFeed(){
                $.ajax({
                    url: 'ajax/homeNoFeeds',
                    beforeSend: function() {
                        showLoader(true)
                    },
                    complete: function() {
                        showLoader(false)
                    },
                    success: function success(response) {
                        $('#home-title').text('Top Podcasts');
                        return handleViewRenderHome(response);
                    },
                    error: function(){
                        findPodcastResults.append('<div class="col-lg-12 col-md-6 col-sm-12"><p>service not available.</p></div>');
                    }
                });

            }



            (function() {$.ajax({url: '/ajax/touchUser'});})()

            function handleViewRenderHome(response) {
                response.forEach(function (param) {
                    var a = '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="item"><div class="pos-rlt"><div class="bottom"><span class="badge bg-info m-l-sm m-b-sm">'+param.total_episodes + ' Episodes</span></div><div class="item-overlay opacity r r-2x bg-black">';
                    var b = a + '<div class="center text-center m-t-n"><a href="/podcast/'+param.id+'"><i class="icon-action-redo i-2x"></i></a></div></div>';
                    var c = b + '<a href="#"><img src="'+param.thumbnail_600+'" class="r r-2x img-full"></a></div><div class="padder-v">';
                    var d = c + '<a href="/podcast/'+param.id+'" class="text-ellipsis">' + param.name + '</a>';
                    var e = d + '<a href="/podcast/'+param.id+'" class="text-ellipsis text-xs text-muted"></a></div></div></div>';
                    findPodcastResults.append(e);
                });
            }

            function showLoader(flag) {
                $('#loading').attr('hidden', !flag);
            }
        });
    </script>

    <script type="text/javascript" src="js/partials/leftbar.js"></script>
@endsection
