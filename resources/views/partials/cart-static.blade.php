<div class="cart">
    <div class="cart-group">
        <div class="cart-list">
            @for ($i = 0; $i <= 1; $i++)
            <div class="cart-item d-flex justify-content-between">
                <div class="cart-start d-md-flex">
                    <a href="#" class="align-self-center">
                        <figure class="image">
                            <img src="@asset('images/temp/cart/cart-01.jpg')" alt="" />
                        </figure>
                    </a>
                    <div class="info align-self-center">
                        <div class="rate">
                            <div class="icon-fill">@include('icons.star')</div>
                            <div class="icon-fill">@include('icons.star')</div>
                            <div class="icon-fill">@include('icons.star')</div>
                            @include('icons.star')
                            @include('icons.star')
                        </div>
                        <a href="#" class="name">Toffie Fudge {{$i}}</a>
                    </div>
                    <div class="quantity d-flex align-self-center align-items-center">
                        <button class="q-control">-</button>
                        <input type="text" class="form-control" placeholder="1">
                        <button class="q-control">+</button>
                    </div>
                </div>
                <div class="cart-end d-flex flex-column flex-md-row align-self-md-center align-items-end align-items-md-center justify-content-md-end">
                    <div class="price">kr 179</div>
                    <button class="delete-btn d-flex align-items-center">
                        <div class="close-text small">Fjern</div>
                        @include('icons.cross')
                    </button>
                </div>
            </div><!-- /.cart-item -->
            @endfor

            <div class="cart-item d-flex justify-content-between">
                <div class="cart-start d-md-flex">
                    <a href="#" class="align-self-center">
                        <figure class="image">
                            <img src="@asset('images/temp/cart/cart-01.jpg')" alt="" />
                        </figure>
                    </a>
                    <div class="info align-self-center">
                        <div class="rate">
                            <div class="icon-fill">@include('icons.star')</div>
                            <div class="icon-fill">@include('icons.star')</div>
                            <div class="icon-fill">@include('icons.star')</div>
                            @include('icons.star')
                            @include('icons.star')
                        </div>
                        <a href="#" class="name">Chocolate berry</a>
                    </div>
                    <div class="quantity d-flex align-self-center align-items-center">
                        <button class="q-control">-</button>
                        <input type="text" class="form-control" placeholder="1">
                        <button class="q-control">+</button>
                    </div>
                </div>
                <div class="cart-end d-flex flex-column flex-md-row align-self-md-center align-items-end align-items-md-center justify-content-md-end">
                    <div class="price"><div class="old-price">kr 1279 </div>kr 1179</div>
                    <button class="delete-btn d-flex align-items-center">
                        <div class="close-text small">Fjern</div>
                        @include('icons.cross')
                    </button>
                </div>
            </div><!-- /.cart-item -->

        </div>
    </div><!-- /.cart-group -->
</div><!-- /.cart -->