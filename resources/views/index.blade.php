@extends('layouts.app')

@section('content')
    @if( is_category() )
        <section class="section has-breadcrumbs section-articles">
            <div class="container">
                <div class="title-header has-info d-flex justify-content-between">
                    <div class="title align-self-center align-self-md-start">
                        <h2 class="h2 is-small-mob">{{ single_term_title() }}</h2>
                        <p class="hide-mobile">{!! term_description() !!}</p>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="card-lists js-articles-masonry">
                    @while (have_posts()) @php the_post() @endphp
                        @php $category = get_the_category() @endphp

                        @include('partials.article-item', [
                            'item' => array(
                                'id' => get_the_ID(),
                                'cat_url' => get_category_link($category[0]->cat_ID),
                                'cat_name' => $category[0]->cat_name
                            ) 
                        ])
                    @endwhile
                </div><!-- /.card-lists -->

                @if( $GLOBALS['wp_query']->max_num_pages > 1 )
                    <div class="load-more text-center">
                        <div class="spinner-border d-none article-spinner" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <a href="javascript:void(0);" class="btn btn-secondary article-loadmore" 
                            data-currentpage = "1"
                            data-ajaxurl = "{{ site_url() }}/wp-json/wp/v2/articles"
                            data-order="desc"
                            data-orderby="date"
                            data-postsperpage = "{{ get_option( 'posts_per_page' ) }}"
                            data-currentterm_id = "{{ get_queried_object()->term_id ?? '' }}{{ ','.$children_category_id ?? '' }}"
                            >{!! $site_translate->articles['load_more'] ?: 'Load more' !!}</a>
                    </div>
                @endif
            </div>
        </section>

        @include( 'partials.sections' )
    @else
        @include( 'partials.sections' )
    @endif
@endsection