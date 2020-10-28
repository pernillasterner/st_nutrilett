@php $isReceipt = true @endphp

<section class="section section-half-text has-breadcrumbs has-image">
    <div class="container">
        <div class="row">
        <div class="col-12 col-lg-6">
            <h1 class="h2">{!! $confirmation_title !!}</h1>
            <div class="lead">{!! $confirmation_text !!}</div>
        </div>
        </div>
    </div>
</section>

<section class="section section-cart">
    <div class="container">
        <h2 class="h2">{!! $order_number_label . ' ' . $receipt_info['order'] !!}</h2>
        <div class="cart bg-white">
            <div class="cart-group">
                <div class="cart-list">
                    @if( isset( $receipt_info['receipt_items'] ) && is_array( $receipt_info['receipt_items'] ) )                        
                        @php include( locate_template( 'parts/shop/receipt-selection.php' ) ) @endphp
                    @endif
                </div>
                <div class="cart-meta">
                    <div class="amount">
                        @php include( locate_template( 'parts/shop/totals-selection.php' ) ) @endphp
                    </div>
                </div>
            </div>
        </div>
        <div>
            {!! $receipt_info['paymentMethodData']['snippet'] !!}
        </div>
    </div>
</section>