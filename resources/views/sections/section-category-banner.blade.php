{{-- @if ($breadcrumbs)
    <section class="section breadcrumb-vertical no-mb d-none d-lg-block">
    {!! $breadcrumbs !!}
    </section>
@endif --}}

@if ($hero_banner->image || $hero_banner->image_mobile)
    <section class="section category-banner d-flex no-mb lazy"
        data-bg="url( {{ wp_is_mobile() ? $hero_banner->image_mobile : $hero_banner->image }} )">  
        <div class="box-wrapper d-flex align-self-end">
            <div class="container">
                <div class="category-banner-info text-center text-sm-left">

                    @if ($hero_banner->title)
                        <h1 class="title h3">{!! $hero_banner->title !!}</h1>
                    @endif

                    @if ($hero_banner->text)
                        <div class="content">
                            <p>{!! $hero_banner->text !!}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif