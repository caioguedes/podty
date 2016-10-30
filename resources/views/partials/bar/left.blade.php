@if(Auth::user())
    <aside class="bg-black dk nav-xs aside hidden-print" id="nav">
        <section class="vbox">
            <section class="w-f-md scrollable">
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
                                    <b class="badge bg-primary pull-right" id="podcasts-count">-</b>
                                    <span class="font-bold">My Podcasts</span>
                                </a>
                            </li>
                            <li>
                                <a href="/profile">
                                    <i class="icon-users icon text-info"></i>
                                    <b class="badge bg-primary pull-right" id="friends-count">-</b>
                                    <span class="font-bold">Friends</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </section>
        </section>
    </aside>
@endif
