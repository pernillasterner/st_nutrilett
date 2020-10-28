<div class="product-details-inline {{$classname}}">
  @if($is_link)
  <a href="#" class="image-wrap">
  @else
  <div class="image-wrap">
  @endif
    <div class="image">
      <figure>
        <img src="@asset('images/temp/erika-skirt.jpeg')" alt="">
      </figure>
    </div>
  @if($is_link)
  </a>
  @else
  </div>
  @endif
  
  <div class="info">
    @if($is_link)
    <a href="#" class="name">ERIKA SKIRT</a>
    @else
    <div class="name">ERIKA SKIRT</div>
    @endif
    <div class="category">Kategori - Kjolar</div>
    <div class="color">Färg - OCEAN BLUE</div>
    <div class="size">Storlek - M</div>
    <div class="price">Pris - 799 kr</div>
    <div class="price is-sale">Pris - <span class="old-price">799 kr</span> <span class="new-price">799 kr</span></div>
  </div>
  @if($has_close)
  <div class="close-pos">
    <button class="close-btn"></button>
  </div>
  @endif
</div>
