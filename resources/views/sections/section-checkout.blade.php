@php( $isCheckoutPage = true )

{!! TemplateCheckout::startSelectionForm() !!}
    <section id="js-checkout-content" class="section section-cart has-default">
        <div class="container">
            <div class="go-back">
                <a href="{!! $order_content->go_back_to_shop_url ? get_permalink($order_content->go_back_to_shop_url) : $home_url !!}">
                    {!! $order_content->go_back_to_shop ?: 'Go back to shop' !!}
                </a>
            </div>

            <h2 class="h2 js-h2 {{ ($no_items) ? 'd-none' : '' }}">1. {!! $order_content->title ?: 'Your Order' !!}</h2>
            <div class="cart bg-white">
                @if ($no_items)
                    {{-- NO CART ITEM --}}
                    <div class="text-center p-5 js-no-item-holder">
                        @if ( !empty( $no_selected_item_content->title ) )
                            <h2 class="h2">{!! $no_selected_item_content->title !!}</h2>
                        @endif

                        @if ( !empty( $no_selected_item_content->text ) )
                            <p class="mb-0">{!! $no_selected_item_content->text !!}</p>
                        @endif
                    </div>
                @endif

                <div class="cart-group js-cart-item-holder {{ ($no_items) ? 'd-none' : '' }}">
                    <div id="js-selectedItems" class="cart-list">
                        @php( include( locate_template( 'parts/shop/checkout-selection.php' ) ) )
                    </div>
                    <div class="cart-meta">
                        <div id="js-selectedTotals" class="amount">
                            @php( include( locate_template( 'parts/shop/totals-selection.php' ) ) )
                        </div>
                        <div id="js-voucher-field" class="row align-items-center">
                            @php( include( locate_template( 'parts/shop/voucher.php' ) ) )
                        </div>
                        {{-- <div id="js-selectedNewsletter" class="custom-control custom-checkbox second-checkbox">
                            {!! TemplateCheckout::newsletterField() !!}
                        </div> --}}
                        {{-- <div class="custom-control custom-checkbox second-checkbox">
                            {!! $oocd_field !!}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section js-payment-holder {{ ($no_items) ? 'd-none' : '' }}">
        <div class="container">
            <h2 class="h2">2. {!! $payments_content->title ?: 'Payment' !!}</h2>
            <div class="bg-white checkout-iframe">
                {{-- <div id="js-selectedPaymentMethod" class="radios">
                    @php (include( locate_template( 'parts/shop/payment-options.php' ) ))
                </div> --}}
                <div id="js-paymentFields">
                    @php (include( locate_template( 'parts/shop/payments-selection.php' ) ))
                </div>
            </div>
        </div>
    </section>
{!! TemplateCheckout::endSelectionForm() !!}

{{-- product status show --}}
<div class="modal fade product-status show" id="js-product-status-popup" tabindex="-1" role="dialog" aria-labelledby="product-status-popup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
            {{-- add class modifier to product-status-container class like .success for sucess and .error for error --}}
            <div class="product-status-container success">
                <div class="modal-close" data-dismiss="modal">
                @include('icons.cross')
                </div>
                {{-- icon for success --}}
                <img class="product-status-icon-success" src="@asset('images/icon/success.svg')" alt="">
                {{-- icon for error --}}
                <img class="product-status-icon-error" src="@asset('images/icon/error.svg')" alt="">
                <div class="product-content">
                {{-- text for success --}}
                <p class="h2 mb-0 mt-0 p-success">{!! $page_content->success_add_to_cart ?: 'Product added to Cart' !!}</p>
                {{-- text for error --}}
                <p class="h2 mb-0 mt-0 p-error">{!! $page_content->failed_add_to_cart ?: 'Product failed to add in Cart' !!}</p>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
{{-- product status show --}}
