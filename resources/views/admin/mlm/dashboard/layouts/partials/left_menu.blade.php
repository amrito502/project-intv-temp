<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
        <ul class="app-menu">

                <li>
                        <a class="app-menu__item" href="{{ route('admin.index') }}">
                                <i class="app-menu__icon fa fa-home" style="color: red"></i>
                                <span class="app-menu__label">Dashboard</span>
                        </a>
                </li>


                @foreach (session('menus')->where('parent_id', 0)->where('action_menu', 0)->sortBy('order_serial') as $parentMenu)

                @if (!count(session('menus')->where('action_menu', 0)->where('parent_id', $parentMenu->id)->sortBy('order_serial')))

                @can($parentMenu->name)
                <li>
                        <a class="app-menu__item @if (Route::currentRouteName() == $parentMenu->url ) active @endif"
                                href="{{ route($parentMenu->url) }}">
                                <i class="app-menu__icon {{ $parentMenu->icon }}"
                                        style="color:{{ $parentMenu->icon_color }};"></i>
                                <span class="app-menu__label">{{ $parentMenu->name }}
                                        @if ($parentMenu->url ==
                                        'member.payment')({{ session('pendingWithdrawRequest') }})@endif
                                        @if ($parentMenu->url == 'verify.fund')({{ session('pendingAddedFund') }})@endif
                                        @if ($parentMenu->url ==
                                        'account.approval')({{ session('pendingAccountVerification') }})@endif
                                </span>

                        </a>
                </li>
                @endcan

                @else

                @can($parentMenu->name)

                @php
                $openSubMenu = count(session('menus')->where('parent_id',
                $parentMenu->id)->sortBy('order_serial')->where('url' ,
                Route::currentRouteName()) );

                $openSubMenu = $openSubMenu > 0 ? 'is-expanded' : '';

                @endphp

                <li class="treeview {{ $openSubMenu }}">
                        <a class="app-menu__item" href="#" data-toggle="treeview">
                                <i class="app-menu__icon {{ $parentMenu->icon }}"
                                        style="color:{{ $parentMenu->icon_color }};">
                                </i>
                                <span class="app-menu__label">
                                        {{ $parentMenu->name }}
                                </span>

                                <i class="treeview-indicator fa fa-angle-right"></i>
                        </a>


                        @if (count(session('menus')->where('action_menu', 0)->where('parent_id', $parentMenu->id)))

                        <ul class="treeview-menu">
                                @foreach (session('menus')->where('parent_id', $parentMenu->id)->sortBy('order_serial')
                                as $ChildMenu)

                                @can($ChildMenu->name)
                                <li>
                                        <a class="treeview-item @if (Route::currentRouteName()== $ChildMenu->url ) active @endif"
                                                href="{{ route($ChildMenu->url) }}">
                                                <i class="icon {{ $ChildMenu->icon }}"
                                                        style="color:{{ $ChildMenu->icon_color }};"></i>
                                                {{ $ChildMenu->name }}

                                                @if ($ChildMenu->url ==
                                                'member.payment')({{ session('pendingWithdrawRequest') }})@endif
                                                @if ($ChildMenu->url == 'verify.fund')({{ session('pendingAddedFund') }})@endif
                                                @if ($ChildMenu->url ==
                                                'account.approval')({{ session('pendingAccountVerification') }})@endif
                                        </a>
                                </li>
                                @endcan

                                @endforeach
                        </ul>

                        @endif
                </li>
                @endcan

                @endif

                @endforeach


                @if (Auth::user()->is_agent == 1)
                <li>
                        <a class="app-menu__item" href="{{ route('member.payment.agent') }}">
                                <i class="app-menu__icon fa fa-dashboard fa-lg"></i>
                                <span class="app-menu__label">Withdraw Request</span>
                        </a>
                </li>
                <li>
                        <a class="app-menu__item" href="{{ route('agent.list') }}">
                                <i class="app-menu__icon fa fa-dashboard fa-lg"></i>
                                <span class="app-menu__label">Agent List</span>
                        </a>
                </li>
                @endif

                <li>
                        <a onclick="$('#logout-form').submit();" class="app-menu__item" href="#">
                                <i class="app-menu__icon fa fa-sign-out fa-lg" style="color: red"></i>
                                <span class="app-menu__label">Logout</span>
                        </a>
                </li>


        </ul>
</aside>
