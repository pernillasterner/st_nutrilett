<section id="section-{{ $section->id }}" class="section section-article-page {{ $section->classes }}">
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">        
              {{-- editor output  --}}
              <div class="editor-output">{!! apply_filters( 'the_content', $section->content ) !!}</div>
          </div>
        </div>
    </div>
</section>