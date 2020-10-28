var Platform = {};

(function () {

  Platform.detectDevice = function () {
    var body = document.body;
    var ua = navigator.userAgent;
    var checker = {
      // OS
      Windows: ua.match(/Windows/),
      MacOS: ua.match(/Mac/),
      Android: ua.match(/Android/),

      // Browser
      Msie: ua.match(/Trident/),
      Edge: ua.match(/Edge/),
      Chrome: ua.match(/Chrome/),
      Firefox: ua.match(/Firefox/),
      Safari: ua.match(/Safari/),

      // Device
      isApple: ua.match(/(iPhone|iPod|iPad)/),
      iPhone: ua.match(/iPhone/),
      iPad: ua.match(/iPad/),
      iPod: ua.match(/iPod/),
    };

    if (checker.isApple) {
      // Apple
      body.classList.add('isApple');
      Platform.webbing('isApple');

      if (checker.iPhone) {
        // Apple iPhone
        body.classList.add('iphone');
        Platform.webbing('iphone');
      } else if (checker.iPad) {
        // Apple iPad
        body.classList.add('ipad');
        Platform.webbing('ipad');

        if (checker.Chrome) {
          // Chrome Browser
          body.classList.add('chrome');
          Platform.webbing('chrome');
        } else if (checker.Safari) {
          // Safari Browser
          body.classList.add('safari');
          Platform.webbing('safari');
        } else if (checker.Firefox) {
          // Firefox Browser
          body.classList.add('firefox');
          Platform.webbing('firefox');
        }
      } else if (checker.iPod) {
        // Apple iPod
        body.classList.add('ipod');
        Platform.webbing('ipod');
      }

    } else if (checker.Windows) {
      // Windows OS
      body.classList.add('windowsOS');

      if (checker.Edge) {
        // Edge Browser
        body.classList.add('edge');
        Platform.webbing('edge');
      } else if (checker.Chrome) {
        // Chrome Browser
        body.classList.add('chrome');
        Platform.webbing('chrome');
      } else if (checker.Safari) {
        // Safari Browser
        body.classList.add('safari');
        Platform.webbing('safari');
      } else if (checker.Firefox) {
        // Firefox Browser
        body.classList.add('firefox');
        Platform.webbing('firefox');
      } else if (checker.Msie) {
        // Firefox Browser
        body.classList.add('msie');
        Platform.webbing('msie');
      }

    } else if (checker.MacOS) {
      // Mac OS
      body.classList.add('macOS');
      Platform.webbing('macOS');

      if (checker.Chrome) {
        // Chrome Browser
        body.classList.add('chrome');
        Platform.webbing('chrome');
      } else if (checker.Safari) {
        // Safari Browser
        body.classList.add('safari');
        Platform.webbing('safari');
      } else if (checker.Firefox) {
        // Firefox Browser
        body.classList.add('firefox');
        Platform.webbing('firefox');
      }

    } else if (checker.Android) {
      // Android OS
      body.classList.add('AndroidOS');
      Platform.webbing('AndroidOS');
    }


    // Really basic check for the ios platform
    // https://stackoverflow.com/questions/9038625/detect-if-device-is-ios
    var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    // Get the device pixel ratio
    var ratio = window.devicePixelRatio || 1;

    // Define the users device screen dimensions
    var screen = {
      width: window.screen.width * ratio,
      height: window.screen.height * ratio,
    };

    // iPhone X Detection
    if (iOS && screen.width == 1125 && screen.height === 2436) {
      $('body').addClass('iphoneX');
      Platform.webbing('iphoneX');
    }
  },

  Platform.webbing = (e) => {
    let isDefaultEle = document.getElementsByClassName('js-platform');
    if (!isDefaultEle) return;

    for(let i = 0; i < isDefaultEle.length; i++) {
      isDefaultEle[i].classList.add(e);

      if(i > 10000) break;
    }
  }

  Platform.detectDevice();
})($);
