<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    <!--[if lte IE 9]>  
      <div class="ie-below">
        <div class="container">
          This website may not be compatible with your outdated Internet Explorer version. <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie" target="_blank" style="color: #fff; text-decoration: underline;">Please upgrade here.</a>
        </div>
      </div>
    <![endif]-->
    @include('partials.icon')
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div class="wrap" role="document">
      <div class="content">
        <main class="main">
          @yield('content')
        </main>
        @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
      </div>
    </div>
    @php do_action('get_footer') @endphp

    @if ($display_footer)
      @include('partials.footer')
    @endif

    @include('partials.page-loader')
    @php wp_footer() @endphp
  </body>
</html>
