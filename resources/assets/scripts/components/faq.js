// FORMAT
// #faqID
let FAQ = {};

FAQ.init = () => {
  let hash = location.hash;
  let navHeight = $('.nav-bar').height();
  let spacing;
  if ($('body').hasClass('admin-bar')) {
    spacing = navHeight + 32;
  } else {
    spacing = navHeight;
  }

  if (hash) {
    var FAQItem = document.querySelector(hash);
    if (FAQItem) {
      $(FAQ.addDash(hash, '-', 4)).collapse('toggle');
      var new_position = $(hash).offset().top - spacing;
      $('html, body').animate({
          scrollTop: new_position,
        },
        1500,
        'linear'
      )
    }
  }
}

FAQ.addDash = (main_string, ins_string, pos) => {
  if (typeof (pos) == 'undefined') {
    pos = 0;
  }
  if (typeof (ins_string) == 'undefined') {
    ins_string = '';
  }
  return main_string.slice(0, pos) + ins_string + main_string.slice(pos);
}

document.addEventListener('DOMContentLoaded', function () {
  FAQ.init();
});
