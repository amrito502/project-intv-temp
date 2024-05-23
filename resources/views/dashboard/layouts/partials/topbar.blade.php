<header class="app-header">
    <div class="one d-flex">
        <a class="" href="{{ route('home') }}">
            @if (session('ss')->website_logo === '')
            {{ session('ss')->website_name }}
            @else
            <img src="{{ asset('storage/sitesetting/'.session('ss')->website_logo) }}" class="logoImg" alt="Logo">
            @endif
        </a>
        <!-- Sidebar toggle button-->
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->


        <h2 class="text-center text-light mt-4 d-none d-md-block" style=" margin-left: 5px;font-size: 35px;">{{
            Auth::user()?->company?->name }}</h2>
        <ul class="app-nav">
            {{-- <li class="app-search">
                <input class="app-search__input" type="search" placeholder="Search">
                <button class="app-search__button"><i class="fa fa-search"></i></button>
            </li> --}}
            <!-- User Menu-->
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>

            <li class="dropdown">
                <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
                    <i class="fa fa-user fa-lg"></i> &nbsp; {{ Auth::user()?->company?->name }}
                </a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="{{ route('cp.view') }}"><i class="fa fa-lock fa-lg"
                                aria-hidden="true"></i> Change Password</a></li>
                    <li><a onclick="$('#logout-form').submit();" class="dropdown-item" href="#"><i
                                class="fa fa-sign-out fa-lg"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <h2 class="text-center d-md-none d-block" style=" margin-left: 5px;font-size: 25px;">{{
        Auth::user()?->company?->name }}</h2>
</header>
