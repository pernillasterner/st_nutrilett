let fileUpload = {};
let contactFile = $('#js-contact-file');
let fileList = $('#js-file-list');

fileUpload.init = () => {
  fileUpload.displayfilenames();
}

fileUpload.displayfilenames = () => {
  contactFile.change(function () {
    // fileList.empty();
    var fp = contactFile;
    var lg = fp[0].files.length;
    var items = fp[0].files;
    var fragment = '';

    if (lg > 0) {
      for (var i = 0; i < lg; i++) {
        var fileName = items[i].name;
        // var fileSize = items[i].size;
        // var fileType = items[i].type;
        fragment += '<li>' + fileName + '</li>';
        console.log(fileName);
      }

      fileList.append(fragment);
    }
  });
}

$(document).ready(function () {
  fileUpload.init();
});
