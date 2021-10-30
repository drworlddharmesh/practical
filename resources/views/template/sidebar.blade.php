<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    {{-- <img alt="image" style="height: 50px;width: auto;" src="{{ $image }}" /> --}}
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">test</span>

                        <span class="text-muted text-xs block">Admin
                            <b class="caret"></b>
                        </span>
                    </a>

                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a class="dropdown-item" href="{{ url('admin/profile') }}">Profile</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ url('admin/change-password') }}">Change Password</a>
                        </li>

                        <li class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="{{ url('admin/logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>

                <div class="logo-element">
                    t
                </div>
            </li>

            <li class="{{ Request::segment(1) == 'shop' ? 'active' : '' }}">
                <a href="{{ url('shop/shop') }}">
                    <i class="fa fa-dashboard"></i>

                    <span class="nav-label">Shop</span>
                </a>
            </li>


        </ul>
    </div>
</nav>