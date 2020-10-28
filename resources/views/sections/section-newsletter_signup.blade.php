@if( $section->layout === 'large' )
    @include( 'partials.newsletter-signup-large' )
@else
    @include( 'partials.newsletter-signup-small' )
@endif