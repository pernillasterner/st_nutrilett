@if (!empty($cookie_data->cookie_content) || !empty($cookie_data->cookie_bar_button))
  <div id="js-cookie" class="cookie-bar fixed-bottom" data-cookie="settings_agreedToCookie" style="display: none;">
    <div class="alert alert-ash alert-dismissible fade show mb-0" role="alert">
      <div class="alert-container align-items-center d-flex justify-content-center flex-column flex-sm-row">
        <div class="col d-flex align-items-center p-0 flex-column flex-sm-row">
            <img src="@asset('images/icon/bored.svg')" alt="Alert">

            @if (!empty($cookie_data->cookie_content))
              <span class="alert-text">{!! strip_tags($cookie_data->cookie_content, '<a><div><em><strong>') !!}</span>
            @endif
        </div>

        @if (!empty($cookie_data->cookie_bar_button))
          <button class="btn btn-sm btn-primary text-body js-cookie-approve" type="button">{{ $cookie_data->cookie_bar_button }}</button>
        @endif
      </div>
    </div>
  </div>
@endif
