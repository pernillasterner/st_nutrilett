@if ($section->title || $section->preamble || $section->items)
    <section id="section-{{ $section->id }}" class="section resellers  {{ $section->classes ?? '' }}">
        <div class="resellers-container p-3 m-auto">

            @if ($section->title || $section->preamble)
                <div class="d-block">
                    @if ($section->title)
                        @if($section->is_h1)
                            <h1 class="text-center">{!! $section->title !!}</h1>
                        @else
                            <h2 class="text-center">{!! $section->title !!}</h2>
                        @endif 
                    @endif                    

                    @if ($section->preamble)
                        <p  class="preamble text-center">{!! $section->preamble !!}</p>
                    @endif
                </div>
            @endif

            @if ($section->items)
                @foreach ($section->items as $item)
                    <div class="h3">{!! $item->label !!}</div>
                    <div class="resellers-table d-md-table w-100" data-limit="{{ $section->count }}">

                        @foreach ($item->posts as $post)
                            @php ($ctr = $loop->iteration)
                            <div class="resellers-table-row d-md-table-row">
                                <div class="resellers-table-cell d-md-table-cell head">{!! $post['city'] !!}</div>
                                <div class="resellers-table-cell d-md-table-cell">{!! $post['title'] !!}</div>
                                <div class="resellers-table-cell d-md-table-cell">
                                    <a class="js-section-link" href="{!! $post['link']['url'] ?? null !!}" target="{!! $post['link']['target'] ?? null !!}">
                                        {!! $post['link']['title'] ?? null !!}
                                    </a>
                                </div>
                            </div>                        
                        @endforeach
                        
                        @if ( $section->count && $ctr > $section->count && $section->view_all_btn )
                            <button type="button" class="btn btn-sm btn-primary js-more d-md-none">{!! $section->view_all_btn !!}</button>
                        @endif

                    </div>
                @endforeach
            @endif

        </div>
    </section>
@endif
