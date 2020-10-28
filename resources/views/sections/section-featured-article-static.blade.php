{{-- Featured Article section --}}
{{-- figure and content-info are interchangeable whether its left or right --}}
{{-- if the image was on right side, kindly add order-lg-0 to
            the text container and add order-lg-1 for image container. See the example below --}}
<section class="section section-featured-article">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-lg-6 is-column">
        <figure class="article-item">
          <img src="@asset('images/temp/block_feature_1.jpg')" alt="">
        </figure>
      </div>
      <div class="col-lg-6 is-column">
        <div class="content-info d-flex justify-content-center flex-column">
          <div class="h1 headtext">
            Smarte valg og sunne alternativer for deg på farten.
          </div>
          <div>
            <a href="#" class="link-text has-icon">Les artikkel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Featured Article section --}}
{{-- figure and content-info are interchangeable whether its left or right --}}
{{-- if the image was on right side, kindly add order-lg-0 to
                          the text container and add order-lg-1 for image container. See the example below --}}
<section class="section section-featured-article">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-lg-6 is-column order-lg-1">
        <figure class="article-item">
          <img src="@asset('images/temp/block_feature_1.jpg')" alt="">
        </figure>
      </div>
      <div class="col-lg-6 is-column order-lg-0">
        <div class="content-info d-flex justify-content-center flex-column">
          <div class="h1 headtext">
            Smarte valg og sunne alternativer for deg på<br>farten.
          </div>
          <div>
            <a href="#" class="link-text has-icon">Les artikkel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
