@if(Auth::user())
    <aside class="bg-black dk nav-xs aside hidden-print" id="nav">
        <section class="vbox">
            <section>
                <div>
                    <nav class="nav-primary hidden-xs">
                        <ul class="nav bg">
                            <li>
                                <a href="/discover">
                                    <i class="icon icon-bell text-info"></i>
                                    <span class="font-bold">Discover</span>
                                </a>
                            </li>
                            <li>
                                <a href="/podcasts">
                                    <i class="icon-microphone icon text-info"></i>
                                    <span class="font-bold">My Podcasts</span>
                                </a>
                            </li>
                            <li>
                                <a href="/favorites">
                                    <i class="icon-heart icon text-info"></i>
                                    <span class="font-bold">Favorites</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div style="height: 70%;overflow: auto;">
                    <nav class="nav-primary hidden-xs" style="margin-top: 5px;">
                        <ul class="nav" id="podcasts-list-left-side">
                        </ul>
                    </nav>
                </div>
            </section>
        </section>
    </aside>

    <script>
        $.ajax({
            url: '/ajax/myPods',
            success: function(response){
                response.map(function(podcast){
                    $('#podcasts-list-left-side').append(renderList(podcast))
                });
            }
        });

        function renderList(podcast){
            return '<li>' +
                    '<a href="/podcasts/' + podcast.slug + '">' +
                        '<img src="' + podcast.thumbnail_100 + '" class="img-circle" width="40" height="40">' +
                    '</a>' +
                '</li>';
        }
    </script>

@endif

