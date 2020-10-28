import StickySidebar from 'sticky-sidebar/dist/sticky-sidebar';

const addressSidebar = {};
let sidebarEl = document.querySelector('.js-sticky-sidebar');

addressSidebar.init = () => {
  if (sidebarEl) {
    var sidebar = new StickySidebar('.js-sticky-sidebar', {
      containerSelector: '.js-as-container',
      innerWrapperSelector: '.fixed-address',
      topSpacing: 230,
      resizeSensor: true,
      minWidth: 767,
    });
    sidebar;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  addressSidebar.init();
});
