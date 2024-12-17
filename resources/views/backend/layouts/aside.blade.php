        <!-- Menu -->


        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">

                <a href="/admin/dashboard" class="app-brand-link">
                    <span class=" demo menu-text fw-bolder ms-2 fs-3"><span class="text-primary">Print</span>ifyIt
                </a>


                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item  {{ Route::is('admin') ? 'active' : '' }}">
                    <a href="/admin/" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Product & Order</span>
                </li>
                <li class="menu-item {{ Route::is('orders.index') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="fa fa-folder" aria-hidden="true"></i>
                        <div data-i18n="Account Settings">Orders</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('orders.index') }}" class="menu-link">
                                <div data-i18n="Notifications">Manage</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class= "menu-item  {{ Route::is('product.index') || Route::is('product.create') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="fa-brands fa-product-hunt"></i>
                        <div data-i18n="Account Settings">Products</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('product.create') }}" class="menu-link">
                                <div data-i18n="Notifications">Create</div>
                            </a>
                        </li>
                    </ul>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('product.index') }}" class="menu-link">
                                <div data-i18n="Notifications">Manage</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Category and reservation</span>
                </li>
                <li class="menu-item {{ Route::is('categories.index') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        <div data-i18n="Account Settings">Categories</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('categories.index') }}" class="menu-link">
                                <div data-i18n="Notifications">Manage</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ Route::is('file.index') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="fa fa-folder" aria-hidden="true"></i>
                        <div data-i18n="Account Settings">Files</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('file.index') }}" class="menu-link">
                                <div data-i18n="Notifications">Manage</div>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (Auth::user() && Auth::user()->role == 'admin')
                    <li class="menu-item {{ Route::is('contact.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <div data-i18n="Account Settings">Contact</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('contact.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item {{ Route::is('carousels.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            <div data-i18n="Account Settings">Carousels</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('carousels.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                {{-- 
                
                <li class="menu-item {{ Route::is('reservation.index') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="fa-solid fa-calendar-days"></i>&nbsp;&nbsp;
                        <div data-i18n="Account Settings">Reservation</div>
                    </a>
                    <ul class="menu-sub">

                        <li class="menu-item">
                            <a href="{{ route('reservation.index') }}" class="menu-link">
                                <div data-i18n="Notifications">Manage</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ Route::is('transactions.index') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="fa fa-dollar" aria-hidden="true"></i>&nbsp;&nbsp;
                        <div data-i18n="Account Settings">Transactions</div>
                    </a>
                    <ul class="menu-sub">

                        <li class="menu-item">
                            <a href="{{ route('transactions.index') }}" class="menu-link">
                                <div data-i18n="Notifications">Manage</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ Route::is('newsletter.index') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="fa fa-mail-forward" aria-hidden="true"></i>&nbsp;&nbsp;
                        <div data-i18n="Account Settings">Newsletter</div>
                    </a>
                    <ul class="menu-sub">

                        <li class="menu-item">
                            <a href="{{ route('newsletter.index') }}" class="menu-link">
                                <div data-i18n="Notifications">Manage</div>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- @if (Auth::check() && (Auth::user()->role == 'staff' || Auth::user()->role == 'admin'))
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Manage File</span>
                    </li>
                    <li class="menu-item {{ Route::is('fileManager.create', 'fileManager.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-envelope"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">File Manager</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('fileManager.create') }}" class="menu-link">
                                    <div data-i18n="Account">Create</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('fileManager.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Manage</span>
                    </li>
                    <li class="menu-item {{ Route::is('admins.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-user"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">Admin</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admins.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item {{ Route::is('users.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-user"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">User</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('users.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item {{ Route::is('staffs.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-user"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">Staff</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('staffs.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Pages</span>
                    </li>

                    <li class="menu-item {{ Route::is('tables.create', 'tables.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            <div data-i18n="Account Settings">Table</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('tables.create') }}" class="menu-link">
                                    <div data-i18n="Account">Create</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('tables.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item {{ Route::is('carousels.create', 'carousels.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-sliders"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">carousel</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('carousels.create') }}" class="menu-link">
                                    <div data-i18n="Account">Create</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('carousels.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Route::is('aboutus.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-address-card"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">About</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('aboutus.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Route::is('about_imgs.create', 'about_imgs.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-bars"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">About Iamges</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('about_imgs.create') }}" class="menu-link">
                                    <div data-i18n="Account">Create</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('about_imgs.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Route::is('foods.create', 'foods.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-burger"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">Food</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('foods.create') }}" class="menu-link">
                                    <div data-i18n="Account">Create</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('foods.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                

                    <li
                        class="menu-item {{ Route::is('testimonials.create', 'testimonials.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-solid fa-plus"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">Testimonial</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('testimonials.create') }}" class="menu-link">
                                    <div data-i18n="Account">Create</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('testimonials.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="menu-item {{ Route::is('team_members.create', 'team_members.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa-sharp fa-solid fa-people-group"></i>&nbsp;&nbsp;
                            <div data-i18n="Account Settings">Team Members</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('team_members.create') }}" class="menu-link">
                                    <div data-i18n="Account">Create</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('team_members.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Route::is('settings.create', 'settings.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa fa-cogs" aria-hidden="true"></i> &nbsp;&nbsp;
                            <div data-i18n="Account Settings">Settings</div>
                        </a>
                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="{{ route('settings.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Route::is('contacts.index') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="fa fa-phone" aria-hidden="true"></i> &nbsp;&nbsp;
                            <div data-i18n="Account Settings">Contacts</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('contacts.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Manage</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif --}}

                <li class="menu-item">
                    <a href="{{ route('logout') }}" class="menu-link menu-toggle"
                        onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;
                        <div data-i18n="Account Settings">Logout</div>
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </aside>
        <!-- / Menu -->
