@if(Auth::user())
    <aside class="aside-md bg-light dk hidden-xs" id="sidebar">
        <section class="vbox animated fadeInRight">
            <section class="w-f-md scrollable hover friends-list">
                <h4 class="font-thin m-l-md m-t">Friends</h4>
                <ul class="list-group no-bg no-borders auto m-t-n-xxs connect-friends-list"></ul>
            </section>

            <footer class="footer footer-md search-users" style="margin-bottom:35px;background:#4d5d6e;border-top: 2px solid #657789;" hidden>
                <h4 class="font-thin m-l-md m-t">Results <a id="clear-search-users" style="font-size: 12px;">Clear</a></h4>

                <ul class="list-group no-bg no-borders auto m-t-n-xxs search-users-list"></ul>
            </footer>
            <footer class="footer footer-md bg-black">
                <div class="form-group clearfix m-b-none">
                    <div class="input-group m-t m-b">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-sm bg-empty text-muted btn-icon" id="btn-search-user"><i class="fa fa-search"></i></button>
                        </span>
                        <input type="text" class="form-control input-sm text-white bg-empty b-b b-dark no-border" id="input-search-user" placeholder="Search members">
                    </div>
                </div>
            </footer>
        </section>
    </aside>

    <script type="text/javascript" src="/js/partials/connected.js"></script>
@endif
