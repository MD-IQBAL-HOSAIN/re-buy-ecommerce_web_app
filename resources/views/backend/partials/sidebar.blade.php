<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('backend.dashboard.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ $settings->mini_logo ? asset($settings->mini_logo) : asset('assets/images/logo-sm.png') }}"
                    alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ $settings->logo ? asset($settings->logo) : asset('assets/images/logo-dark.png') }}"
                    alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('backend.dashboard.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ $settings->mini_logo ? asset($settings->mini_logo) : asset('assets/images/logo-sm.png') }}"
                    alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ $settings->logo ? asset($settings->logo) : asset('assets/images/logo-light.png') }}"
                    alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Dashboard</span></li>
                <li class="nav-item">
                    <a href="{{ route('backend.dashboard.index') }}"
                        class="nav-link {{ getPageStatus('backend.dashboard.index') }}" data-key="t-ecommerce">
                        <i class="ri-home-4-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('backend.system-user.*') ? 'active' : '' }}"
                        href="{{ route('backend.system-user.index') }}">
                        <i class="ri-user-line"></i> <span>List of Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('language.*') ? 'active' : '' }}"
                        href="{{ route('language.index') }}">
                        <i class="ri-globe-line"></i> <span>List of Languages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('buy-category.*') ? 'active' : '' }}"
                        href="{{ route('buy-category.index') }}">
                        <i class="ri-shopping-bag-line"></i> <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('buy-subcategory.*') ? 'active' : '' }}"
                        href="{{ route('buy-subcategory.index') }}">
                        <i class="ri-shopping-cart-line"></i> <span>Subcategories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('color.*') ? 'active' : '' }}"
                        href="{{ route('color.index') }}">
                        <i class="ri-palette-line"></i> <span>Colors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('condition.*') ? 'active' : '' }}"
                        href="{{ route('condition.index') }}">
                        <i class="ri-checkbox-circle-line"></i> <span>Conditions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('storage.*') ? 'active' : '' }}"
                        href="{{ route('storage.index') }}">
                        <i class="ri-database-line"></i> <span>Storage</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('protection-service.*') ? 'active' : '' }}"
                        href="{{ route('protection-service.index') }}">
                        <i class="ri-shield-check-line"></i> <span>Protection Services</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('accessory.*') ? 'active' : '' }}"
                        href="{{ route('accessory.index') }}">
                        <i class="ri-tools-line"></i> <span>Accessories</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('product.*') ? 'active' : '' }}"
                        href="{{ route('product.index') }}">
                        <i class="ri-smartphone-line"></i> <span>Products (Buy Module)</span>
                    </a>
                </li>

                  <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('order.*') ? 'active' : '' }}"
                        href="{{ route('order.index') }}">
                        <i class="ri-shopping-bag-2-line"></i> <span>Orders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('sell-products.*') ? 'active' : '' }}"
                        href="{{ route('sell-products.index') }}">
                        <i class="ri-store-2-line"></i> <span>Products (Sell Module)</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('question.*') ? 'active' : '' }}"
                        href="{{ route('question.index') }}">
                        <i class="ri-question-answer-line"></i> <span>Question & Option (Sell)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('question-answers.*') ? 'active' : '' }}"
                        href="{{ route('question-answers.index') }}">
                        <i class="ri-file-list-3-line"></i> <span>Question Answers Wise Price (Sell)</span>
                    </a>
                </li>


                <!-- end Dashboard Menu -->

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">CMS Pages</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ getPageStatus(['backend.page.*', 'dynamic.*', 'backend.faq.*', 'refurbished-electronics.*', 'banner.*', 'feature-device-header.*', 'review-ratings.*', 'customer-details.*', 'sell-electronics.*', 'what-like-to-sell.*', 'how-it-works.*', 'trust-feature.*'], 'collapsed active') }}"
                        href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="sidebarPages">
                        <i class="ri-pages-line"></i> <span data-key="t-pages">CMS Pages</span>
                    </a>
                    <div class="collapse menu-dropdown {{ getPageStatus(['backend.page.*', 'dynamic.*', 'backend.faq.*', 'refurbished-electronics.*', 'banner.*', 'feature-device-header.*', 'review-ratings.*', 'customer-details.*', 'sell-electronics.*', 'what-like-to-sell.*', 'how-it-works.*', 'trust-feature.*'], 'show') }}"
                        id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('dynamic.index') }}"
                                    class="nav-link {{ getPageStatus('dynamic.*') }}" data-key="t-starter">
                                    Dynamic Pages
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('backend.faq.index') }}"
                                    class="nav-link {{ getPageStatus('backend.faq.*') }}" data-key="t-starter">
                                    FAQ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('banner.edit') }}"
                                    class="nav-link {{ getPageStatus('banner.*') }}" data-key="t-starter">
                                    Banner Images
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('refurbished-electronics.index') }}"
                                    class="nav-link {{ getPageStatus('refurbished-electronics.*') }}"
                                    data-key="t-starter">
                                    Refurbished Electronics
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('feature-device-header.edit') }}"
                                    class="nav-link {{ getPageStatus('feature-device-header.*') }}"
                                    data-key="t-starter">
                                    Feature Device Header
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('review-ratings.index') }}"
                                    class="nav-link {{ getPageStatus('review-ratings.*') }}" data-key="t-starter">
                                    Review & Ratings
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('sell-electronics.index') }}"
                                    class="nav-link {{ getPageStatus('sell-electronics.*') }}" data-key="t-starter">
                                    Sell Electronics
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('what-like-to-sell.edit') }}"
                                    class="nav-link {{ getPageStatus('what-like-to-sell.*') }}" data-key="t-starter">
                                    What would You Like To Sell
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('how-it-works.index') }}"
                                    class="nav-link {{ getPageStatus('how-it-works.*') }}" data-key="t-starter">
                                    How It Works
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('trust-feature.index') }}"
                                    class="nav-link {{ getPageStatus('trust-feature.*') }}" data-key="t-starter">
                                    Trust Feature
                                </a>
                            </li>


                            {{-- <li class="nav-item">
                                <a href="{{ route('customer-details.edit') }}"
                                    class="nav-link {{ getPageStatus('customer-details.*') }}" data-key="t-starter">
                                    Customer Details
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link {{ getPageStatus('backend.settings.*') }}" href="#sidebarMultilevel"
                        data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="sidebarMultilevel">
                        <i class="ri-share-line"></i> <span data-key="t-multi-level">Settings</span>
                    </a>
                    <div class="collapse menu-dropdown {{ getPageStatus('backend.settings.*', 'show') }}"
                        id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('backend.settings.profile.index') }}"
                                    class="nav-link {{ getPageStatus('backend.settings.profile.*') }}"
                                    data-key="t-level-1.1"> Profile Settings </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('backend.settings.system.index') }}"
                                    class="nav-link {{ getPageStatus('backend.settings.system.*') }}"
                                    data-key="t-level-1.1"> System Settings </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('backend.settings.mail.index') }}"
                                    class="nav-link {{ getPageStatus('backend.settings.mail.*') }}"
                                    data-key="t-level-1.1"> Mail Settings</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('backend.settings.third-party-api.index') }}"
                                    class="nav-link {{ getPageStatus('backend.settings.third-party-api.*') }}"
                                    data-key="t-level-1.1">Bible API Settings</a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('backend.settings.payments.stripe.index') }}"
                                    class="nav-link {{ getPageStatus('backend.settings.payments.*') }}"
                                    data-key="t-level-1.1"> Payment Settings</a>
                            </li>
                        </ul>
                    </div>
                </li>


                {{-- <li class="nav-item" style="margin-top: 10em">
                    <a class="nav-link menu-link {{ request()->routeIs('auth.logout.post') ? 'active' : '' }}"
                        href="{{ route('auth.logout.post') }}">
                        <i class="ri-user-line"></i> <span>Logout</span>
                    </a>
                </li> --}}
                <li class="nav-item" style="margin-top: 35em; margin-left: 15px; ">
                    <form action="{{ route('auth.logout.post') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit"
                            class="nav-link menu-link {{ request()->routeIs('auth.logout.post') ? 'active' : '' }}"
                            style="border: none; background: none; padding: 10px;">
                            <i class="ri-logout-box-r-line"></i> <span>Logout</span>
                        </button>
                    </form>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    {{-- <div class="sidebar-background"></div> --}}


</div>
