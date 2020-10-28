import { viewportWidth } from './viewPort';

var BgimageJS = {};

BgimageJS.switchBG = function () {
    var mobiledataBG = $('.js-background-image').data('mobilebackground');
    var desktopBG = $('.js-background-image').css('background-image');

    if (viewportWidth().width < 767) {
        $('.js-background-image').css({ 'background-image': 'url(' + mobiledataBG + ')' });
    } else {
        $('.js-background-image').css({ 'background-image': desktopBG });
    }
};

$( window ).on( 'resize', function(){
    BgimageJS.switchBG();
});

$( document ).ready( function(){
    BgimageJS.switchBG();
});