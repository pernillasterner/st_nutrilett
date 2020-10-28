@if (!empty($content) && is_array($content))

    @foreach($content as $section)
        @includeIf( 'sections.section-'.$section->acf_fc_layout )
    @endforeach

@endif