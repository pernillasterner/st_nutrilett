let contact = {};

contact.init = () => {
  var contactButton = document.querySelector('.js-show-contact');

  if (contactButton) {
    contactButton.addEventListener('click', function (e) {
      e.preventDefault();
      $('.section-contact').fadeToggle('slow');
    });
  }
}

$(document).ready(function () {
  contact.init();
});
