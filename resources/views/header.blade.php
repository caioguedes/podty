<script>
    $(this).on('resize load', function(){
        var element = $('.navbar-header')
        if ($(window).width() >= 767) {
            element.toggleClass('bg-info', true)
        } else {
            element.toggleClass('bg-info', false)
        }
    })
</script>

<header class="bg-black header header-md navbar navbar-fixed-top-xs">
    <div class="navbar-header aside nav-xs">
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
            <i class="icon-list"></i>
        </a>
        <a href="/" class="navbar-brand text-lt">
            <i class="icon-earphones"></i>
            <img src="" alt="." class="hide">
            <span class="hidden-nav-xs m-l-sm">Vllep</span>
        </a>
    </div>
    @unless(Auth::guest())
        <ul class="nav navbar-nav hidden-xs">
            <li>
                <a href="#nav,.navbar-header" data-toggle="class:nav-xs,nav-xs" class="text-muted">
                    <i class="fa fa-indent text"></i>
                    <i class="fa fa-dedent text-active"></i>
                </a>
            </li>
        </ul>

        @if(\Illuminate\Support\Facades\Route::getCurrentRoute()->uri() == '/')
            <div class="navbar-form navbar-left input-s-lg m-t m-l-n-xs hidden-xs" role="search">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-sm bg-white btn-icon rounded btn-find-cast">
                              <i class="fa fa-search"></i>
                          </button>
                        </span>
                        <input type="text" id="find-cast"
                               class="form-control input-sm no-border rounded"
                               placeholder="Search podcasts"
                        >
                    </div>
                </div>
            </div>
        @endif

    @endunless
    @if (Auth::guest())
        <div class="navbar-right">
            <ul class="nav navbar-nav m-n hidden-xs nav-user user">
                <li class="hidden-xs">
                    <a href="{{ url('login') }}">
                        <i class="fa fa-sign-in text-success" style="padding-right: 5px"></i>
                         Sign In
                    </a>
                </li>
                <li class="hidden-xs">
                    <a href="{{ url('register') }}">
                        <i class="fa fa-users text-success" style="padding-right: 5px"></i>
                        Sign Up
                    </a>
                </li>
                <li class="dropdown">
                    <ul class="dropdown-menu animated fadeInRight">
                        <li>
                            <a href="{{ url('login') }}">
                                <i class="fa fa-sign-in text-success"></i>
                                Sign In
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('register') }}">
                                <i class="fa fa-users text-success"></i>
                                Sign Up
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    @else
        <div class="navbar-right ">
            <ul class="nav navbar-nav m-n hidden-xs nav-user user">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle bg clear" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                            <img src="https://www.gravatar.com/avatar/{{md5(strtolower(trim(Auth::user()->email)))}}?d=retro">
                        </span>
                        {{ Auth::user()->name }}<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
                        {{--<li>
                            <span class="arrow top"></span>
                            <a href="#">Settings</a>
                        </li>--}}
                        <li>
                            <a href="/profile">Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('/logout') }}" >Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    @endif
</header>


