<section id="section-{{ $section->id }}" class="section instagram  {{ $section->classes ?? '' }}">
    <div class="instagram-gallery d-none d-md-block lazy" data-bg="url('{{ $section->image }}')">

        @if ( (!empty($section->instagram_link->url) && !empty($section->instagram_link->title)) || $section->title || $section->text )
            <div class="col-wrap instagram-info-margin">
                <div class="col-group">
                    <div class="col-side"></div>
                    <div class="col-side">
                        <div class="instagram-info">
                            <div class="btn-header d-flex justify-content-center align-items-center">
                                @if (!empty($section->instagram_link->url) && !empty($section->instagram_link->title))
                                    <a href="{{ $section->instagram_link->url }}"
                                        class="btn btn-sm btn-primary text-uppercase js-section-link"
                                        target="{{ $section->instagram_link->target }}">{!! $section->instagram_link->title !!}</a>
                                @endif

                                @if ($section->title)
                                    @if($section->is_h1)
                                        <h1 class="h3">{!! $section->title !!}</h1>
                                    @else
                                        <h3 class="h3">{!! $section->title !!}</h3>
                                    @endif                                    
                                @endif
                            </div>

                            @if ($section->text)
                                <div class="info">{!! $section->text !!}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($section->instagram_images)
            <div class="col-wrap">
                <div class="col-group">
                    <div class="col-side">
                        <div class="tile-group justify-content-end align-items-end">

                            @include( 'partials.instagram-image', [
                                'image' => isset($section->instagram_images[0]) ? $section->instagram_images[0] : '',
                                'isLarge' => true,
                                'tileClass' => 'is-three'
                            ] )

                            <div class="tile-block">

                                @for ($i = 1; $i <= 2; $i++)
                                    @include( 'partials.instagram-image', [
                                        'image' => isset($section->instagram_images[ $i ]) ? $section->instagram_images[ $i ] : '',
                                        'isLarge' => false,
                                        'tileClass' => ''
                                    ] )
                                @endfor
                                @php $lastIndex = $i @endphp

                            </div>
                        </div>
                        <div class="tile-group justify-content-end">

                            @for ($i = $lastIndex; $i < $lastIndex+3; $i++)
                                @include( 'partials.instagram-image', [
                                    'image' => isset($section->instagram_images[ $i ]) ? $section->instagram_images[ $i ] : '',
                                    'isLarge' => false,
                                    'tileClass' => ''
                                ] )
                            @endfor
                            @php $lastIndex = $i @endphp

                        </div>
                    </div>
                    <div class="col-side">
                        <div class="tile-group">
                            <div class="tile-block-hidden"></div>
                        </div>
                        <div class="tile-group">

                            @for ($i = $lastIndex; $i < $lastIndex+3; $i++)
                                @include( 'partials.instagram-image', [
                                    'image' => isset($section->instagram_images[ $i ]) ? $section->instagram_images[ $i ] : '',
                                    'isLarge' => false,
                                    'tileClass' => ''
                                ] )
                            @endfor
                            @php $lastIndex = $i @endphp

                        </div>
                        <div class="tile-group">
                            <div class="tile-block">

                                @for ($i = $lastIndex; $i < $lastIndex+2; $i++)
                                    @include( 'partials.instagram-image', [
                                        'image' => isset($section->instagram_images[ $i ]) ? $section->instagram_images[ $i ] : '',
                                        'isLarge' => false,
                                        'tileClass' => ''
                                    ] )
                                @endfor
                                @php $lastIndex = $i @endphp

                            </div>

                            @include( 'partials.instagram-image', [
                                'image' => isset($section->instagram_images[ $lastIndex ]) ? $section->instagram_images[ $lastIndex ] : '',
                                'isLarge' => true,
                                'tileClass' => 'is-three'
                            ] )

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="instagram-gallery-mobile d-block d-md-none lazy" data-bg="url('{{ $section->image }}')">
        @if ( ($section->instagram_link->url && $section->instagram_link->title) || $section->title || $section->text )
            <div class="instagram-info text-center">
                <div class="btn-header">
                    @if ($section->title)
                        @if($section->is_h1)
                            <h1 class="h3 mb-0">{!! $section->title !!}</h1>
                        @else
                            <h3 class="h3 mb-0">{!! $section->title !!}</h3>
                        @endif                          
                    @endif

                    @if ($section->instagram_link->url && $section->instagram_link->title)
                        <a href="{{ $section->instagram_link->url }}"
                            class="btn btn-sm btn-primary text-uppercase js-section-link"
                            target="{{ $section->instagram_link->target }}">{!! $section->instagram_link->title !!}</a>
                    @endif
                </div>

                @if ($section->text)
                    <div class="info">{!! $section->text !!}</div>
                @endif
            </div>
        @endif

        @if ($section->instagram_images)
            @php
            $isLarge = false;
            $isMobile = true;
            @endphp

            <div class="instagram-col">
                @foreach ($section->instagram_images as $image)
                    @if ($loop->iteration === 1)
                        <div class="row">
                            @include( 'partials.instagram-image' )
                        </div>

                    @elseif ($loop->iteration <= 5)
                        @if ($loop->iteration % 2 === 0)
                        <div class="row">
                        @endif

                            @include( 'partials.instagram-image' )

                        @if ($loop->iteration % 2 === 1)
                        </div>
                        @endif
                    @else
                        @if ($loop->iteration % 4 === 2)
                        <div class="row">
                        @endif

                            @include( 'partials.instagram-image' )

                        @if ($loop->iteration % 4 === 1 || $loop->iteration === count($section->instagram_images))
                        </div>
                        @endif
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>