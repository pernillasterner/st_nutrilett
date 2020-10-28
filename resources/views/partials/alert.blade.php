<div id="js-alert" data-class-default="alert fade show fixed-top" role="alert"
     style="display:none; z-index:1031"
     data-class-success="alert-success" data-class-warning="alert-warning" data-class-danger="alert-danger">
    <div class="alert-container align-items-center d-flex justify-content-center flex-column flex-sm-row">
        <div class="col d-flex align-items-center p-0 flex-column flex-sm-row">
            <img id="js-alert-image" alt="Alert" data-icon-success="@asset('images/icon/smile.svg')"
                 data-icon-warning="@asset('images/icon/yawn.svg')"
                 data-icon-danger="@asset('images/icon/sadface.svg')">
            <span id="js-alert-text" class="alert-text text-center text-sm-left"></span>
        </div>
        <button id="js-alert-button" data-class-default="btn btn-sm btn-primary text-body"
                data-class-special="btn btn-sm btn-primary bg-white text-body"
                type="button" data-text="{{ $site_translate->general['close'] ?? '' }}"></button>
    </div>
</div>