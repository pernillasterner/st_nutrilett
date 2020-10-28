{{--
  Template Name: Reseller Template
--}}

@include('page')
{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
{{-- @include('partials.sections') --}}
{{-- @while(have_posts()) @php the_post() @endphp
@include('partials.page-header')

<section class="section resellers">
  <div class="resellers-container p-3 m-auto">

    <div class="d-block">
      <h2 class="text-center">Återförsäljare</h2>
      <p  class="preamble text-center">
        In hac habitasse platea dictumst. Vivamus adipiscing fermentum quam volutpat aliquam. Integer et elit eget elit facilisis tristique. Nam vel iaculis mauris. Sed ullamcorper tellus erat, non ultrices sem tincidunt euismod. Fusce rhoncus
      </p>
    </div>


    @for ($table = 0; $table < 3; $table++)
      <div class="h3">Sweden</div>
      <div class="resellers-table d-md-table w-100" data-limit="5">
        @for ($row = 0; $row < 15; $row++)
          <div class="resellers-table-row d-md-table-row"> <!-- NOTE:  -->
            <div class="resellers-table-cell d-md-table-cell head">Item - {{ $row }}</div>
            <div class="resellers-table-cell d-md-table-cell">Country House</div>
            <div class="resellers-table-cell d-md-table-cell">www.countryhouse.se</div>
          </div>
        @endfor
        <button type="button" class="btn btn-sm btn-primary js-more d-md-none">Visa alla</button>
      </div>
    @endfor

  </div>
</section>
@include('partials.content-page')
@endwhile --}}
{{-- @endsection --}}
