<ul class="menu-nav">
    <li class="menu-item">
        @if (Auth::user()->group == 1)
            <a href="/home" class="menu-link">
                <span class="menu-text">My Sims</span>
            </a>
        @else
            <a href="/home" class="menu-link">
                <span class="menu-text">Dashboard</span>
            </a>
        @endif
    </li>
    @if (Auth::user()->group == 3)
        <li class="menu-item menu-item-open menu-item-submenu menu-item-rel menu-item-open"
            data-menu-toggle="click" aria-haspopup="true">
            <a href="javascript:;" class="menu-link menu-toggle">
                <span class="menu-text">Admin</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                <ul class="menu-subnav">
                    <li class="menu-item">
                        <a href="/admin/users" class="menu-link">
                            <span class="menu-text">Users</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/pricing" class="menu-link">
                            <span class="menu-text">Pricing</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/countries" class="menu-link">
                            <span class="menu-text">Countries</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/regions" class="menu-link">
                            <span class="menu-text">Regions</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/plans" class="menu-link">
                            <span class="menu-text">Plans</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/orders" class="menu-link">
                            <span class="menu-text">Orders</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/endpoints" class="menu-link">
                            <span class="menu-text">Sims</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/retailers" class="menu-link">
                            <span class="menu-text">Retailers</span>
                            <span class="menu-desc"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    @endif
    @if (Auth::user()->group != 3)
        <li class="menu-item">
            <a href="/catalog" class="menu-link">
                <span class="menu-text">Shop</span>
            </a>
        </li>
        <li class="menu-item {{isset($active) && in_array($active, ['personal']) ? 'menu-item-here' : ''}}">
            <a href="/profile/personal-information" class="menu-link">
                <span class="menu-text">My Profile</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="/profile/orders" class="menu-link">
                <span class="menu-text">Order History</span>
            </a>
        </li>
    @endif
</ul>