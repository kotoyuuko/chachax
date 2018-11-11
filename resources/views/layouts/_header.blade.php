<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('root') }}">
                {{ env('APP_NAME') }}
            </a>
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav">
                @auth
                    <li class="{{ Route::is('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">首页</a>
                    </li>
                    <li class="{{ Route::is('plans*') ? 'active' : '' }}">
                        <a href="{{ route('plans.root') }}">套餐</a>
                    </li>
                @endauth
                <li class="{{ Route::is('tos') ? 'active' : '' }}">
                    <a href="{{ route('tos') }}">用户协议</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li class="{{ Route::is('login') ? 'active' : '' }}">
                        <a href="{{ route('login') }}">登录</a>
                    </li>
                    <li class="{{ Route::is('register') ? 'active' : '' }}">
                        <a href="{{ route('register') }}">注册</a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="user-avatar pull-left">
                                <img src="{{ Auth::user()->avatar(60) }}" class="avatar img-responsive img-circle">
                            </span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('user.profile') }}">个人中心</a></li>
                            <li><a href="{{ route('user.recharge') }}">充值</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    退出
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
