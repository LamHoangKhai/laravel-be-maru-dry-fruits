<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="">
            <h4>Maru Dry Fruits</h4>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Home</span>
        </li>
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin/dasboard') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>




        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        <li class="menu-item  {{ request()->is('admin/category/*') ? 'active' : '' }}">
            <a href="{{ route('admin.category.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Category</div>
            </a>
        </li>
        <li class="menu-item  {{ request()->is('admin/product/*') ? 'active' : '' }}">
            <a href="{{ route('admin.product.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Product</div>
            </a>
        </li>

        <li class="menu-item  {{ request()->is('admin/user/*') ? 'active' : '' }}">
            <a href="{{ route('admin.user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">User</div>
            </a>
        </li>


        <li class="menu-item {{ request()->is('admin/transaction/*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Transaction</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item ">
                    <a href="{{ route('admin.transaction.import') }}" class="menu-link">
                        <div data-i18n="Account">Import</div>
                    </a>
                </li>
                <li class="menu-item ">
                    <a href="{{ route('admin.transaction.export') }}" class="menu-link">
                        <div data-i18n="Notifications">Export</div>
                    </a>
                </li>
                <li class="menu-item ">
                    <a href="{{ route('admin.transaction.supplier') }}" class="menu-link">
                        <div data-i18n="Connections">Supplier</div>
                    </a>
                </li>
            </ul>
        </li>


    </ul>
</aside>
