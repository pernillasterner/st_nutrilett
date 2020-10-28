@php( $imageSize = $product->product_meta->product_type === 'Bundle' ? 'bundle' : 'standard' )

<section class="section section-product-page has-breadcrumbs" data-product-type="{{ $product->product_meta->product_type }}">
  <div class="container js-container-product">
    <div class="row">
      <div class="col-lg-5 col-xl-6">
        {{-- MOBILE --}}
        <div class="show-tablet product-mobile-header">
          <div class="title">
            <h2 class="h1">{!! $post->post_title !!}</h2>
            <div class="rate">
              @include( 'partials.star-rating', [ 'rating' => $product_rating ] )
            </div>
          </div>
          <a href="#" class="js-scroll-to review-scroll"  data-target="#review-section">{!! $site_translate->review['listing']['write_a_review'] !!}</a>
        </div>

        @if( $product->images )
        <div class="prod-item d-block d-lg-none">
          <div class="js-product-slider product-slider">
            @foreach( $product->images[$imageSize] as $key => $item )
            <div class="carousel-cell mobile-product-item">
              <div class="feature">
                @if( $product->display_price->is_sale || $product->product_meta->product_type === 'Special' )
                  <div class="sale">{{ $product->display_price->discount_percent }}%</div>
                @endif

                <div class="image-block">
                  <div class="image">
                    <img class="img-product" src="{{ $item['url'] }}" alt="">
                  </div>
                </div>

                @if( $product->product_meta->product_type === 'Special' && $product->bundles && $key === 0 )
                  <div class="bundle">
                    <div class="bundle-list">
                      @php($isFirst = true)
                      @foreach( $product->bundles as $key2 => $item )
                      <div class="bundle-item">
                        <input class="js-selected-bundle-mobile" type="radio" name="bundle_mobile" id="m-{{ get_the_ID() }}-{{ $key2 }}" value="{{ $item['post']->product_post->ID }}" {{ $isFirst ? 'checked' : '' }}>
                        <label for="m-{{ get_the_ID() }}-{{ $key2 }}">{{ $key2 }}</label>
                      </div>
                      @php($isFirst = false)
                      @endforeach
                    </div>
                    <div class="bundle-title">{!! $site_translate->product_listing['select_the_quantity'] !!}</div>
                  </div>
                @elseif( $product->product_meta->product_type === 'Single' )
                  <div class="bundle">
                    <div class="bundle-list">                      
                      @for( $i=1; $i<=4; $i++ )
                        <div class="bundle-item">
                          <input class="js-selected-bundle-mobile" type="radio" name="esc_amount" id="m-{{ get_the_ID() }}-{{ $i }}" value="{{ $i }}" {{ $i === 1 ? 'checked' : '' }} />
                          <label for="m-{{ get_the_ID() }}-{{ $i }}">{{ $i }}</label>
                        </div>
                      @endfor
                    </div>
                    <div class="bundle-title">{!! $site_translate->product_listing['select_the_quantity'] !!}</div>
                  </div>
                @endif
              </div>
            </div>
            @endforeach
          </div>
          <p class="d-none text-center js-carousel-status carousel-status"></p>
        </div>
        @endif

        <div class="show-tablet price-buttons">
          <button type="submit" class="btn btn-secondary has-icon js-submit-mobile" {!! $addtocart_button->attr !!}>{!! $addtocart_button->text ?? '' !!}</button>
          <div id="js-price-mobile" class="price text-right">
            @if( $product->product_meta->product_type !== 'Special' )
              @if( $product->display_price->is_sale )
                <div class="old-price">{{ $product->display_price->price_before }}</div>
              @endif

              <div class="main">{{ $product->display_price->price }}</div>
            @endif
          </div>
        </div>


        {{-- DESKTOP --}}
        @if( $product->images )
        <div class="d-none d-lg-block" id="js-product-sidebar">
          <div class="product-sidebar">
            <div class="product-box bg-white">
              <div class="product-slides">
                <div class="js-product-slider product-slider">
                  @foreach( $product->images[$imageSize] as $key => $item )
                  <div class="carousel-cell product-image">
                    <div class="wrapper">
                      @if( $product->display_price->is_sale || $product->product_meta->product_type === 'Special' )
                        <div class="sale">{{ $product->display_price->discount_percent }}%</div>
                      @endif

                      <div class="image-block">
                        <div class="image">
                          <img class="img-product" src="{{ $item['url'] }}" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <p class="text-center js-carousel-status carousel-status"></p>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
      <div class="col-lg-7 col-xl-6">
        <div class="product-details">
          <div class="d-flex justify-content-between align-items-center hide-tablet">
            <div class="rating-info d-flex align-items-center">
              <div class="rate">
                @include( 'partials.star-rating', [ 'rating' => $product_rating ] )
              </div>
              <a href="#" class="js-scroll-to review-scroll"  data-target="#review-section">{!! $site_translate->review['listing']['write_a_review'] !!}</a>
            </div>
          </div>
          <div class="product-title d-flex justify-content-between flex-wrap hide-tablet">
            <h1 class="h1 product-name">{!! $post->post_title !!}</h1>
            <div id="js-price" class="h1 price text-right">
              @if( $product->product_meta->product_type !== 'Special' )
                @if( $product->display_price->is_sale )
                  <div class="old-price h4 mb-0">{{ $product->display_price->price_before }}</div>
                @endif

                <div class="h1 d-inline-block">{{ $product->display_price->price }}</div>
              @endif
            </div>
          </div>
          <div class="description">{!! wpautop( $product->product_meta->excerpt ) !!}</div>

          {{-- Form Start --}}
          @php ($product_class->renderStartPurchaseForm())
          <input type="hidden" name="esc_amount" value="1">
          <div class="row product-meta">

            @if( $product->product_meta->product_type === 'Special' && $product->bundles )
              <div class="col-lg-6 d-none d-lg-block">
                <p class="product-option">{!! $site_translate->selected_product['how_many_bars'] !!}</p>
                <div class="bundle">
                  <div class="bundle-list">
                    @php($isFirst = true)
                    @foreach( $product->bundles as $key => $item )
                    <div class="bundle-item">
                      <input class="js-selected-bundle" type="radio" name="bundle" id="d-{{ get_the_ID() }}-{{ $key }}"
                        value="{{ $item['post']->product_post->ID }}"
                        data-price="{{ $item['price']->price }}"
                        data-price-before-discount="{{ $item['price']->price_before }}"
                        data-product-item="{{ $item['product_item'] }}"
                        data-discount="{{ $item['price']->discount_percent }}"
                        {{ $isFirst ? 'checked' : '' }}>
                      <label for="d-{{ get_the_ID() }}-{{ $key }}">{{ $key }}</label>
                    </div>
                    @php($isFirst = false)
                    @endforeach
                  </div>
                </div>
              </div>
            @elseif( $product->product_meta->product_type === 'Single' )
              <div class="col-lg-6 d-none d-lg-block">
                <p class="product-option">{!! $site_translate->selected_product['how_many_bars'] !!}</p>
                <div class="bundle">
                  <div class="bundle-list">
                    @foreach( $product->display_price->quantityPrice as $key => $item )
                      <div class="bundle-item">
                        <input class="js-selected-bundle" type="radio" name="esc_amount" id="b-{{ get_the_ID() }}-{{ $key }}"
                          value="{{ $key }}"
                          {{ $key === 1 ? 'checked' : '' }}
                          data-price="{{ $item['price'] }}"
								          data-price-before-discount="{{ $item['price_before_discount'] }}"
								          data-discount="{{ $product->display_price->discount_percent }}"/>
                        <label for="b-{{ get_the_ID() }}-{{ $key }}">{{ $key }}</label>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endif

            <div class="col-lg-6">
              @if( $product->flavas && count( $product->flavas ) > 1 )
              <p class="product-option">{!! $site_translate->selected_product['whats_your_flava'] !!}</p>
              <select class="custom-select" onchange="document.location.href=this.value">
                <option value="">{{ $product->product_meta->name }}</option>
                @foreach( $product->flavas as $item )
                @if( get_permalink() !== $item['productUri'] )
                <option value="{{ $item['productUri'] }}">{{ $item['name'] }}</option>
                @endif
                @endforeach
              </select>
              @endif
            </div>
          </div>

          @if ( !empty( $addtocart_button->text ) )
          <button type="submit" class="btn btn-secondary has-icon hide-tablet" {!! $addtocart_button->attr !!}>{!! $addtocart_button->text ?? '' !!}</button>
          @endif

          {{-- Form end --}}
          @php ($product_class->renderEndForm())

          {{-- Accordions --}}
          <div id="product-accordion" class="accordion">
            @if( $product_information['contents'] )
            <div class="card mb-0">
              <div class="card-header collapsed" data-toggle="collapse" href="#innhold" aria-expanded="false">
                <a class="card-title text-uppercase">
                  {!! $product_information['contents']->label !!}
                  <div class="arrow">
                    <span class="arrow-icon"></span>
                  </div>
                </a>
              </div>
              <div id="innhold" class="card-body collapse" data-parent="#product-accordion">
                <div class="editor-output">
                  <p><small>{!! $bundle_content !!}{!! $product_information['contents']->content !!}</small></p>
                </div>
              </div>
            </div>
            @endif

            @if( $product_information['nutritional_content'] )
            <div class="card mb-0">
              <div class="card-header collapsed" data-toggle="collapse" href="#næringsinnhold" aria-expanded="false">
                <a class="card-title text-uppercase">
                  {!! $product_information['nutritional_content']->label !!}
                  <div class="arrow">
                    <span class="arrow-icon"></span>
                  </div>
                </a>
              </div>
              <div id="næringsinnhold" class="card-body collapse" data-parent="#product-accordion">
                <div class="editor-output">
                  <div class="info-list">
                    <div class="tabulation">
                      @foreach( $product_information['nutritional_content']->content as $item )
                      <div class="tabulation-row">
                        <div class="tabulation-header">{!! $item[0] !!}</div>
                        <div class="tabulation-info">{!! $item[1] !!}</div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            @if( $product_information['ingredients'] )
            <div class="card mb-0">
              <div class="card-header collapsed" data-toggle="collapse" href="#Ingredienser" aria-expanded="false">
                <a class="card-title text-uppercase">
                  {!! $product_information['ingredients']->label !!}
                  <div class="arrow">
                    <span class="arrow-icon"></span>
                  </div>
                </a>
              </div>
              <div id="Ingredienser" class="card-body collapse" data-parent="#product-accordion">
                <div class="editor-output">
                  <p><small>{!! $product_information['ingredients']->content !!}</small></p>
                </div>
              </div>
            </div>
            @endif

            @if( $product_information['downloads'] )
            <div class="card mb-0">
              <div class="card-header collapsed" data-toggle="collapse" href="#downloads" aria-expanded="false">
                <a class="card-title text-uppercase">
                  {!! $product_information['downloads']->label !!}
                  <div class="arrow">
                    <span class="arrow-icon"></span>
                  </div>
                </a>
              </div>
              <div id="downloads" class="card-body collapse" data-parent="#product-accordion">
                <ul class="list-unstyled download-items">
                  <li class="download-item">
                    <p class="mb-0">
                      <a href="{{ $product_information['downloads']->url }}" target="_blank" rel="nofollow noferrer"> <span class="icon">@include('icons.download')</span>{!! $product_information['downloads']->name !!}</a>
                    </p>
                  </li>
                </ul>
              </div>
            </div>
            @endif
          </div>
          {{-- Accordions end --}}
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Related products --}}
@if( $related_products )
  @include( 'partials.popular-products', [
  'products' => $related_products,
  'title' => $site_translate->selected_product['related_products']
  ] )
@endif

{{-- Reviews --}}
<section id="review-section" class="section section-reviews">
  <div class="review-content">
    <div class="container">
      <div class="review-head">
        <div class="row row align-items-baseline">
          <div class="col-sm-6 d-flex align-items-baseline justify-content-between justify-content-sm-start">
            <h2 class="section-title mb-0 review-label">{!! $site_translate->review['listing']['title'] !!}</h2>
            <div class="h6 mb-0 review-count">({{ count( $reviews ) }} {!! $site_translate->review['listing']['reviews'] !!})</div>
          </div>
          <div class="col-sm-6 text-sm-right">
            <a href="#" class="link-text js-toggle-review-form toggle-review-form">{!! $site_translate->review['listing']['write_a_review'] !!}</a>
          </div>
        </div>
      </div>
      <div class="review-form">
        <form id="js-review-form" class="rating-form">
          <div id="js-message" class="alert" role="alert" style="display:none"></div>
          <div class="rating-content d-flex mb-4 align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <span class="rating-title">{!! $site_translate->review['form']['rating'] !!}</span>
              <div class="rate mb-0 ml-3 js-rating-radio">
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="star-item d-inline-block">@include('icons.star')</div>
                <div class="radio-stars d-none">
                  <input type="radio" name="rating" value="1">
                  <input type="radio" name="rating" value="2">
                  <input type="radio" name="rating" value="3">
                  <input type="radio" name="rating" value="4">
                  <input type="radio" name="rating" value="5">
                </div>
              </div>
            </div>
            <div>
              <a href="#" class="link-text js-toggle-review-form toggle-review-form">{!! $site_translate->review['form']['cancel'] !!}</a>
            </div>
          </div>
          <div class="custom-control custom-checkbox mb-4">
            <input type="checkbox" class="custom-control-input" name="recommend" id="recommended" value="1">
            <label class="custom-control-label custom-control-recommended" for="recommended">{!! $site_translate->review['form']['recommend_this_product'] !!}</label>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" name="title" placeholder="{!! $site_translate->review['form']['title'] !!}">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="{!! $site_translate->review['form']['email'] !!}">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group text-area-form">
                <textarea class="form-control" name="review" cols="30" rows="7" placeholder="{!! $site_translate->review['form']['review'] !!}*" spellcheck="false"></textarea>
              </div>
            </div>
          </div>
          <div class="custom-control custom-checkbox mb-5">
            <input type="checkbox" class="custom-control-input" name="accept_terms" id="recommended2" value="1">
            <label class="custom-control-label" for="recommended2">{!! $site_translate->review['form']['accept_terms'] !!}</label>
          </div>
          <input type="hidden" name="sku" value="{{ $product->product_meta->sku }}">
          <input type="hidden" name="id" value="{{ get_the_ID() }}">
          <button type="submit" class="btn btn-secondary has-icon text-center">{!! $site_translate->review['form']['send_review'] !!}</button>
        </form>
      </div>

      @if( $reviews )
      <div class="d-none">{!! do_shortcode( '[was-this-helpful]' ) !!}</div>
      <div class="review-items">
        @foreach( $reviews as $item )
        @php( $yesCount = get_post_meta( $item->ID, '_wthp_helpfull_post_yes', true ) )
        @php( $noCount = get_post_meta( $item->ID, '_wthp_helpfull_post_no', true ) )
        @php( $rating = get_post_meta( $item->ID, 'rating', true ) )
        <div class="review-item">
          <div class="review-header">
            <div class="review-meta">
              <div class="review-person">
                <div class="name small">{!! $item->post_title !!}</div>
              </div>
              <div class="review-rate">
                @include( 'partials.star-rating', compact( 'rating' ) )
              </div>
            </div>

            @if( get_field( 'recommends_product', $item->ID ) )
            <div class="review-recommended">
              <div class="icon">@include('icons.check')</div>
              <small class="detail">{!! $site_translate->review['listing']['recommended'] !!}</small>
            </div>
            @endif
          </div>
          <p class="description">{!! $item->post_content !!}</p>

          <div class="helpful-block-content-custom">
            <p class="help">{!! $was_this_helpful_data['title'] !!}</p>
            <div>
              <button data-post="{{ $item->ID }}" data-response="1" type="button" class="btn btn-secondary has-icon icon-check">{!! $was_this_helpful_data['textYes'] !!} ({{ $yesCount ?: 0 }})</button>
              <button data-post="{{ $item->ID }}" data-response="0" type="button" class="btn btn-secondary has-icon icon-cross">{!! $was_this_helpful_data['textNo'] !!} ({{ $noCount ?: 0 }})</button>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>
</section>

{{-- Sections  --}}
@include( 'partials.sections' )