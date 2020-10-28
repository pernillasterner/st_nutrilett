<div class="prod-item is-bundle">
    <div class="feature">
        <a href="#" title="Weekend Warrior">
            <img src="@asset('images/temp/product_bundle_3.jpg')" alt="" class="img-bundle hide-mobile">
            <img src="@asset('images/temp/product_bundle_3-mobile.jpg')" alt="" class="img-bundle show-mobile">
        </a>
        <div class="bundle">
            <div class="bundle-list">
                <div class="bundle-item">
                    <input type="radio" name="bundleitem" id="a-01" value="4" />
                    <label for="a-01">1</label>
                </div>
                <div class="bundle-item">
                    <input type="radio" name="bundleitem" id="a-02" value="12" checked/>
                    <label for="a-02">2</label>
                </div>
                <div class="bundle-item">
                    <input type="radio" name="bundleitem" id="a-03" value="24"/>
                    <label for="a-03">3</label>
                </div>
                <div class="bundle-item">
                    <input type="radio" name="bundleitem" id="a-04" value="40" />
                    <label for="a-04">4</label>
                </div>
            </div>
            <div class="bundle-title">Velg antall uker</div>
        </div>
    </div>
    <div class="name-price">
        <div class="name">
            <h4 class="h5"><a href="#" title="Chocolate">Weekend Warrior</a></h4>
        </div>
        <div class="rate-price d-flex justify-content-between align-items-center">
            <div class="rate">
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                <div class="icon-fill">@include('icons.star')</div>
                @include('icons.star')
                @include('icons.star')
            </div>
            <div class="h5 price">
                <span class="old-price">kr 219</span>
                kr 179
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-secondary has-icon">legg i handlekurv</button>
</div>