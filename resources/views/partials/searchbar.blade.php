<div class="js-ois-overlay search-bar js-search-bar">
    <div class="search-wrap">
        <div class="search-fixed">
            <div class="container">
                <form class="search-form" method="get" action="{{ $home_url }} ?>">
                    <input type="text" name="s" value="{{ is_search() ? get_search_query() : '' }}" placeholder="{!! $site_translate->general['search_textbox'] ?: 'Search Nutrilett' !!}" class="search-input" autocomplete="off"/>
                    <div class="ic-search search-btn is-open">
                        @include('icons.zoom')
                    </div>
                    <div class="js-ois-close search-close">
                        @include('icons.cross')
                    </div>                    
                </form>
                <div class="spinner-border js-ois-loader" style="display:none" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="search-result no-result js-ois-empty" style="display: none">
                <div class="container">
                    <p id="js-ois-no-result"></p>
                </div>
            </div>
            <div class="search-result js-ois-results">
                <div class="container key-tips">
                    <div class="row">
                        <div class="col-xl-6 col-lg-5 col-md-5">
                            <div id="js-ois-result-text" class="keyword"></div>
                        </div>
                        <div class="col-xl-6 col-lg-7 col-md-7">
                            <div id="js-ois-tips" class="tips"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>