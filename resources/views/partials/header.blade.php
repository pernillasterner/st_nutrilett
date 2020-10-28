@include('partials.alert')

<div class="nav-bar">
    @include('partials.notification')
    <nav class="nav-header">
        <div class="container d-lg-flex align-items-lg-stretch">
            <div class="navbar-brand align-self-lg-center">
                <a class="navbar-item-logo" href="{{ $home_url }}">
                    @if($logo->dark)
                        {!! str_replace('class=""','class="logo-dark"',$logo->dark) !!}
                    @endif

                    @if($logo->light)
                        {!! str_replace('class=""','class="logo-light"',$logo->light) !!}
                    @endif
                </a>
            </div>

            @if( $show_menu )
                <div class="navbar-util-mob js-navbar-cart-mobile">
                    <a href="{{ $checkout_link }}" class="navbar-util-btn">
                        <div class="cart-count js-item-count">0</div>
                        @include('icons.shopping-bag')
                    </a>
                    <button class="navbar-toggle navbar-util-btn js-nav-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div class="navbar-cart is-touch"><!-- / can add .is-active --></div>
                </div>

                <div class="navbar-menu d-lg-flex flex-lg-row align-self-lg-center flex-lg-fill">
                    <div class="nav-form-wrapper">
                        <form id="js-form-search-mobile" action="#">
                            <div class="nav-form">
                                <input type="text" class="form-control" placeholder="{!! $site_translate->general['search_textbox'] ?: 'Search Nutrilett' !!}">
                                <div class="icon">
                                    @include('icons.zoom')
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="navbar-start align-self-lg-center ml-auto">
                        @if (has_nav_menu('header_navigation'))
                            {!! wp_nav_menu(['theme_location' => 'header_navigation', 'menu_class' => 'nav']) !!}
                        @endif
                    </div>
                    <div class="navbar-end d-lg-flex flex-lg-row align-self-lg-center">
                        <div class="navbar-util align-self-lg-center">
                            {{-- <button class="navbar-button js-search-open">
                                @include('icons.zoom')
                            </button> --}}
                            <button class="js-ois-trigger js-search-open navbar-button">
                                @include('icons.zoom')
                            </button>
                        </div>
                        <div class="navbar-util align-self-lg-center navbar-cart js-navbar-cart"><!-- / can add .is-active -->
                            @php ( include( locate_template( 'parts/shop/header-selection.php' ) ) )
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </nav>
    @include('partials.product-filter')
</div>

@include('partials.searchbar')