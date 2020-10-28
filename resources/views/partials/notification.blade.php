@if( $notification_bar && is_front_page() )
    <div class="notification-container d-none d-lg-block">
        <div class="container">
            {{-- <div class="row justify-content-center align-items-center">
                <div class="col-lg-5 text-right pr-0">{!! $notification_bar->texts[0]['text'] !!}</div>
                <div class="col-lg-auto">
                    <div class="bullet"></div>
                </div>
                <div class="col-lg-5 text-left pl-0">{!! $notification_bar->texts[1]['text'] !!}</div>
            </div> --}}
            <div class="row">
              <ul>
                <li>{!! $notification_bar->texts[0]['text'] !!}</li>
                <li>{!! $notification_bar->texts[1]['text'] !!}</li>
              </ul>
            </div>
        </div>
    </div>
@endif
