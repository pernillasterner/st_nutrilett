<form id="{{ $formID }}"
    class="js-newsletter"
    data-target="{{ $targetContainer }}"
    data-success_type="{{ $newsletter_data->form_settings->success_type ?? '' }}"
    data-messages="{{ json_encode($newsletter_data->form_settings->error_messages ?? '') }}"
    data-alert="{{ strip_tags($newsletter_data->form_settings->success_content, '<a><div><em><strong>') ?? '' }}">

    <input type="hidden" name="esc_action" value="esc_submit_newsletter">
    {!! wp_nonce_field( 'silk_submit_newsletter' ) !!}

    <div class="row m-0 align-items-center justify-content-center justify-content-lg-around newsletter-form">
        <div class="input-group is-invalid align-items-center">
            <input type="text" class="form-control " name="esc_email" id="name" placeholder="{{ $newsletter_data->form_settings->email_placeholder ?? '' }}" aria-label="">
            <span class="input-group-btn align-items-center">
                <button type="submit" class="btn btn-lg btn-icon btn-icon-lg btn-outline-primary border-0">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <img class="lazy" data-src="@asset('images/icon/arrow-right.svg')" alt="" srcset="">
                </button>
            </span>
        </div>
        <div class="invalid-feedback text-left js-form-error" data-field="email"></div>
    </div>

    <div class="mt-2 custom-control custom-checkbox">
        <input id="custom-check{{ $sectionID }}" class="custom-control-input" type="checkbox" name="accept_terms" value="1">
        <label class="custom-control-label" for="custom-check{{ $sectionID }}">
            <span>{!! $newsletter_data->form_settings->terms ?? '' !!}</span>
        </label>
        <div class="invalid-feedback text-left js-form-error" data-field="terms"></div>
    </div>
</form>
