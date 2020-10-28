@if( $show_product_filter )
<section class="bg-white product-filter">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-md-9 {{ is_single() ? '' : 'col-8' }}">
        <div class="filter-category filter-category-desktop d-none d-lg-flex">
          @if(is_tax('silk_category') || get_page_template_slug() == 'views/template-product-listing.blade.php')
            @php( $category_menu = TaxonomySilk_category::categoryMenu() )
            <div class="icon-menu">
              <div class="container" style="padding: 0;">
                <ul class="list-unstyled mb-0">
                  @if(isset($category_menu['shop']))
                    <li class="item is-first {{ $category_menu['isActive']=='shop' ? 'active' : '' }}">
                      <a href="{{ $category_menu['shop']['url'] }}" class="link-text has-icon">
                        <p class="label"><small>{{ $category_menu['shop_text'] ?? 'Shop' }}</small></p>
                      </a>
                    </li>
                  @endif

                  @if(isset($category_menu['icon_links']))
                    @foreach ($category_menu['icon_links'] as $item)
                      <li class="item {{ $category_menu['isActive']==$item['term_id'] ? 'active' : '' }}">
                        <a href="{!! $item['url'] !!}" class="link-text has-icon">
                          <div class="icon">
                            {{-- Normal icon --}}
                            {!! $item['icon'] !!}
                            {{-- Hover icon --}}
                            {!! $item['hover_state_icon'] !!}
                          </div>
                          <p class="label"><small>{!! $item['text'] !!}</small></p>
                        </a>
                      </li>
                    @endforeach
                  @endif
                </ul>
              </div>
            </div>
          @else
            @foreach( $filter_sort_links as $item )
              @if( isset( $item['has_arrow'] ) && $item['has_arrow'] )
                @if( $item['text'] )
                  <a href="{{ $item['url'] }}">
                    <div class="filter-category-item d-flex align-items-center {{ $item['classes'] }}">
                      <div>{!! $item['text'] !!}</div>
                    </div>
                  </a>
                @endif
                @include('icons.right-arrow')
              @else
                <a href="{{ $item['url'] }}">
                  <div class="filter-category-item {{ $item['classes'] }}">{!! $item['text'] !!}</div>
                </a>
              @endif
            @endforeach
          @endif
        </div>
        <div
          class="filter-category-mobile d-block d-lg-none {{ is_tax('silk_category') || is_singular('silk_products') ? 'has-parent' : '' }}">

          @foreach( $mobile_filter_sort_links as $item )
          @if( isset( $item['has_arrow'] ) && $item['has_arrow'] )
          @if( $item['text'] )
          <a href="{{ $item['url'] }}" class="filter-category-item item-link is-first">
            {!! $item['text'] !!}
          </a>
          @endif
          <div class="item-link item-svg">
            @include('icons.right-arrow')
          </div>
          @else
          <a href="{{ $item['url'] }}" class="filter-category-item item-link">
            {!! $item['text'] !!}
          </a>
          @endif
          @endforeach

        </div>
      </div>

      @if( $show_filter_sort )
      <div class="col-lg-2 col-md-3 col-4">
        <a href="#" class="js-open-filter">
          <div class="filter-icon d-flex align-items-center justify-content-end">
            @include('icons.wand')
            <span class="filter-icon-label">{!! $site_translate->general['filter'] !!}</span>
          </div>
        </a>
      </div>
      @endif
    </div>
    {{-- <div class="row"> --}}
    {{-- Product Category Menu - Single Product Page  NO FILTER --}}
    {{-- <div class="col-lg-12 col-md-12 col">
        <div class="filter-category-mobile">
          <a href="#">
            <div class="filter-category-item d-flex align-items-center">
              <div>Shop</div> @include('icons.right-arrow')<div>Chocolate</div>
            </div>
          </a>
        </div>
      </div> --}}
    {{-- </div> --}}
  </div>

  <div class="product-filter-wrapper is-filter-close">
    <div class="product-filter-wrapper-button-container">
      <div class="container">
        <div class="row">
          <div class="col-6">
            <div class="filter-btn icon-delete js-clear-filter">
              @include('icons.trash-can')
              <span class="text-uppercase">{!! $site_translate->general['clear_filter'] !!}</span>
            </div>
          </div>
          <div class="col-6">
            <div class="filter-btn icon-fill text-right js-close-filter close-svg">@include('icons.i-delete') <span
                class="text-uppercase">{!! $site_translate->general['close_filter'] !!}</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container product-filter-wrapper-panel">
      <div class="row">
        <div class="col-lg-6">
          <div class="h2 filter-title">{!! $filter_categories_title !!}</div>
          <div class="filter-attribute">
            <div id="js-filter-column1" class="filter-attribute-wrap">
              @if( $filter_categories['column-1'] )
              @foreach( $filter_categories['column-1'] as $item )
              <div class="filter-attribute-wrap-item">
                <a href="">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input js-filter-category" value="{{ $item->term_id }}"
                      id="{{ $item->term_id }}">
                    <label class="custom-control-label" for="{{ $item->term_id }}">{!! $item->name !!}</label>
                  </div>
                </a>
              </div>
              @endforeach
              @endif
            </div>

            <div id="js-filter-column2" class="filter-attribute-wrap">
              @if( $filter_categories['column-2'] )
              @foreach( $filter_categories['column-2'] as $item )
              <div class="filter-attribute-wrap-item">
                <a href="">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input js-filter-category" value="{{ $item->term_id }}"
                      id="{{ $item->term_id }}">
                    <label class="custom-control-label" for="{{ $item->term_id }}">{!! $item->name !!}</label>
                  </div>
                </a>
              </div>
              @endforeach
              @endif
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="h2 filter-title">
            Sorter
          </div>
          <div class="filter-attribute">
            <div class="filter-attribute-wrap">
              @if( is_category() )
              <div class="filter-attribute-wrap-item js-sort" data-order="asc" data-orderby="title">
                <a href="#"><span class="small">ALLE</span>
                  <div class="icon-fill no-stroke svg-gallery">@include('icons.gallery-layout')</div>
                </a>
              </div>
              <div class="filter-attribute-wrap-item js-sort sort-asc" data-order="asc" data-orderby="menu_order">
                <a href="#"><span class="small">Mest populære</span>
                  <div class="sorter-svg">@include('icons.crisp-arrow-bottom')</div>
                </a>
              </div>
              <div class="filter-attribute-wrap-item js-sort sort-asc" data-order="asc" data-orderby="date">
                <a href="#"><span class="small">Dato</span>
                  <div class="sorter-svg">@include('icons.crisp-arrow-bottom')</div>
                </a>
              </div>
              @elseif( is_tax( 'silk_category' ) || get_page_template_slug() ===
              'views/template-product-listing.blade.php' )
              <div class="filter-attribute-wrap-item js-sort" data-order="asc" data-orderby="title">
                <a href="#"><span class="small">ALLE</span>
                  <div class="icon-fill no-stroke svg-gallery">@include('icons.gallery-layout')</div>
                </a>
              </div>
              <div class="filter-attribute-wrap-item js-sort sort-asc" data-order="asc" data-orderby="menu_order">
                <a href="#"><span class="small">Mest populære</span>
                  <div class="sorter-svg">@include('icons.crisp-arrow-bottom')</div>
                </a>
              </div>
              <div class="filter-attribute-wrap-item js-sort sort-asc" data-order="asc" data-orderby="price">
                <a href="#"><span class="small">Pris</span>
                  <div class="sorter-svg">@include('icons.crisp-arrow-bottom')</div>
                </a>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 text-center filter-btn-wrapper">
          <button type="button" class="btn btn-secondary has-icon icon-wand js-filter-update">Oppdater</button>
        </div>
      </div>
    </div>
  </div>
</section>
@endif
