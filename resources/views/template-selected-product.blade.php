{{--
  Template Name: Selected Product Template
--}}

@extends('layouts.app')

@section('content')
<section class="section selected-product">
  <div class="container">
    <div class="row">
      <!--
        NOTE: Add `.is-oos` to `.selected-product-preview`, this will add the "out of stock" state for the product.
      -->
      <div class="selected-product-preview col-xxl-6 col-lg-7 p-0 invisible">
        <div class="row justify-content-xxl-start justify-content-center mx-0">
          <div class="selected-product-slider-col p-md-0 m-0">
            <div class="selected-product-slider overflow-hidden p-md-0 shadow-sm">
              @for ($slider = 0; $slider < 3; $slider++)
                <figure class="item align-items-center mb-0">
                  <img src="@asset('images/temp/selected-product-view-2.png')" alt="" srcset="">
                </figure>
              @endfor
            </div>
            <div class="selected-product-blur d-lg-block d-none rounded-circle" style="background: url(@asset('images/temp/selected-product-blur.jpg')) no-repeat center/cover transparent"></div>
            <div class="ie-blur"></div> <!-- NOTE: Keep this tag, this will serve as a fallback for Internet Explorer browsers. -->
          </div>
          <div class="selected-product-thumbnail d-none d-lg-flex flex-column">
            @for ($thumbnail = 0; $thumbnail < 3; $thumbnail++)
              <div class="item bg-white">
                <figure class="">
                  <img src="@asset('images/temp/selected-product-thumb.png')" alt="" srcset="">
                </figure>
              </div>
            @endfor
          </div>
        </div>

        <div class="container-fluid">
          <div class="breadcrumb bg-white d-lg-inline-block d-none mb-0 ">
            <a class="breadcrumb-item" href="#">Home</a>
            <a class="breadcrumb-item" href="#">Level 2</a>
            <span class="breadcrumb-item active">Level 3</span>
          </div>
        </div>
      </div>
      <div class="selected-product-options text-lg-left text-center pt-lg-0 pt-4 col-xxl-6 col-lg-5 pl-md-4">
        <div class="h2 name mb-0">Anja Tank</div>
        <div class="price">
          <span><del>799 kr</del></span> <!-- line through text -->
          <span class="text-red">799 kr</span> <!-- red text -->
        </div>
        <div class="info text-uppercase d-lg-block d-none">Kjolar  |  Underkategori  |  Sea Blue</div>

        <!--
          Selectors
          NOTE: Static looping
        -->
          <div class="selectors">
            <ul class="size-selector d-lg-inline-block d-flex  flex-wrap justify-content-center align-items-center w-100">
              @foreach (['XS', 'S', 'M', 'L', 'XL'] as $size)
                <li class="mx-2">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="sizeCheck[{{ $size }}]" class="custom-control-input" {{ $size == 'L' ? 'disabled="disabled"' : '' }}>
                      <label class="custom-control-label" for="sizeCheck[{{ $size }}]">
                          <span>{{ $size }}</span>
                      </label>
                    </div>
                </li>
              @endforeach
            </ul>

            <ul class="color-selector js-plus-item d-lg-inline-block d-flex flex-wrap justify-content-center align-items-center w-100">
              @for ($color = 0; $color < 10; $color++)
                <li class="mx-2 item d-none is-active">
                  <a href="#" class="custom-control custom-checkbox">
                    <input type="checkbox" id="colorCheck[{{ $color }}]" class="custom-control-input">
                    <label class="custom-control-label" for="colorCheck[{{ $color }}]" style="background-color: #{{ substr(md5(mt_rand()), 0, 6) }}"></label>
                  </a>
                </li>
              @endfor
                <li class="mx-2 js-plus-item-btn">
                  <div class="custom-control custom-checkbox">
                    <label class="align-items-center border custom-control-label d-flex justify-content-center" for="plusItem">+5</label>
                  </div>
                </li>
            </ul>
          </div>

          <button type="button" class="btn btn-lg btn-primary text-uppercase is-loading">
            Lägg i kundkorg
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <!-- Loading spinner, just add '.is-loading' class to '.btn' -->
          </button>

          <ul class="list-group accordion mt-5" id="productAccordion">
            @for ($accordion = 0; $accordion < 4; $accordion++)
              <li class="list-group-item">
                <div class="header d-flex  justify-content-between align-items-center collapsed" data-toggle="collapse" data-target="#collapse{{$accordion}}" aria-expanded="false" aria-controls="collapse{{$accordion}}">
                  <span class="text-uppercase">Collapsible Group Item #{{$accordion}}</span>
                  <button class="btn btn-lg btn-icon btn-icon-lg btn-outline-primary bg-white border-0" type="button">
                    <img src="@asset('images/icon/arrow-down.svg')" alt="" srcset="">
                  </button>
                </div>
                <div id="collapse{{$accordion}}" class="collapse body text-left" aria-labelledby="headingOne" data-parent="#productAccordion">
                  <div class="pb-4">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquid quibusdam reprehenderit eligendi quae voluptatibus quos voluptates nulla quis corrupti sint?
                  </div>
                </div>
              </li>
            @endfor
          </ul>
      </div>
    </div>
  </div>
</section>

@include('partials.content-page')
@endsection
