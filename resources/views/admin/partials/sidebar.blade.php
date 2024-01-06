<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="">
            <h4>Maru Dry Fruits</h4>
        </a>
    </div>


    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Home</span>
        </li>
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin/dasboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Manage </span>
        </li>

        <li class="menu-item  {{ request()->is('admin/category/*') ? 'active' : '' }}">
            <a href="{{ route('admin.category.index') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-category'></i>
                <div data-i18n="Analytics">Category</div>
            </a>
        </li>
        <li class="menu-item  {{ request()->is('admin/product/*') ? 'active' : '' }}">
            <a href="{{ route('admin.product.index') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-package'></i>
                <div data-i18n="Analytics">Product</div>
            </a>
        </li>

        <li class="menu-item  {{ request()->is('admin/user/*') ? 'active' : '' }}">
            <a href="{{ route('admin.user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">User</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('admin/order/*') ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Order</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/order/create') ? 'active' : '' }}">
                    <a href="{{ route('admin.order.create') }}" class="menu-link">
                        <div data-i18n="Connections">Create In-Store Sales Order</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/order/index') ? 'active' : '' }}">
                    <a href="{{ route('admin.order.index') }}" class="menu-link">
                        <div data-i18n="Connections">Online Orders</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/order/history') ? 'active' : '' }}">
                    <a href="{{ route('admin.order.history') }}" class="menu-link">
                        <div data-i18n="Notifications">History</div>
                    </a>
                </li>
            </ul>
        </li>



        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Other</span>
        </li>

        <li class="menu-item {{ request()->is('admin/supplier/index') ? 'active' : '' }}">
            <a href="{{ route('admin.supplier.index') }}" class="menu-link">
                <div data-i18n="Connections"><i class='bx  tf-icons bx-detail'></i> Supplier</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/slider-banner/index') ? 'active' : '' }}">
            <a href="{{ route('admin.slider-banner.index') }}" class="menu-link">

                <div data-i18n="Account"><i class='bx bxs-slideshow'></i> Banner & Silder</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/weight-tag/index') ? 'active' : '' }}">
            <a href="{{ route('admin.weight-tag.index') }}" class="menu-link">
                <div data-i18n="Notifications"><i class='bx  tf-icons bx-tag'></i> Weigh Tag</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('admin/feedback/index') ? 'active' : '' }}">
            <a href="{{ route('admin.feedback.index') }}" class="menu-link">
                <div data-i18n="Notifications"><i class='bx  tf-icons bxs-contact'></i> Feedback</div>
            </a>
        </li>


    </ul>
</aside>
