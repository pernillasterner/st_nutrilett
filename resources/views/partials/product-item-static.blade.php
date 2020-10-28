<div class="prod-item">
    <div class="feature">
        <div class="sale">99%</div>
        <div class="image-block">
            <a href="#" class="image" title="Chocolate">
                <img class="img-product" src="@asset('images/temp/product_sample_6.png')" alt="">
            </a>
        </div>
        <div class="bundle">
            <div class="bundle-list">
                <div class="bundle-item">
                    <input type="radio" name="bundle" id="b-01" value="4" />
                    <label for="b-01">4</label>
                </div>
                <div class="bundle-item">
                    <input type="radio" name="bundle" id="b-02" value="12" checked/>
                    <label for="b-02">12</label>
                </div>
                <div class="bundle-item">
                    <input type="radio" name="bundle" id="b-03" value="24"/>
                    <label for="b-03">24</label>
                </div>
                <div class="bundle-item">
                    <input type="radio" name="bundle" id="b-04" value="40" />
                    <label for="b-04">40</label>
                </div>
            </div>
            <div class="bundle-title">Velg antall</div>
        </div>
    </div>
    <div class="name-price">
        <div class="name">
            <h4 class="h5"><a href="#" title="Chocolate">Chocolate</a></h4>
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