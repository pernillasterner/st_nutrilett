@if( isset( $rating ) )
    @php( $rating = round( $rating ) )
    
    @for( $i=1; $i<=5; $i++ )
        @if( $i <= $rating )
            <div class="icon-fill">
        @endif

        @include('icons.star')

        @if( $i <= $rating )
            </div>
        @endif
    @endfor
@endif