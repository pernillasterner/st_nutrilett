@include( 'partials.popular-products', [
  'products' => $section->productsSlider,
  'title' => $section->title,
  'link' => $section->link,
  'mobile_link_text' => $section->mobile_link_text,
] )