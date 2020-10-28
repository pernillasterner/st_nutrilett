<section id="section-{{ $section->id }}" class="section section-product-chooser {{ $section->classes }}">
  @php
    global $productChooser;
    
    $productChooser->showForm();   
  @endphp
</section>