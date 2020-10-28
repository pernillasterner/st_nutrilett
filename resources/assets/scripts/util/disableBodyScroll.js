// export function disableBodyScroll() {
var disableBodyScroll = (function () {

    var _selector = false,
        _element = false,
        _clientY;

    if (!Element.prototype.matches)
        Element.prototype.matches = Element.prototype.msMatchesSelector ||
            Element.prototype.webkitMatchesSelector;

    if (!Element.prototype.closest)
        Element.prototype.closest = function (s) {
            var el = this;
            if (!document.documentElement.contains(el)) return null;
            do {
                if (el.matches(s)) return el;
                el = el.parentElement || el.parentNode;
            } while (el !== null && el.nodeType === 1);
            return null;
        };

    var preventBodyScroll = function (event) {
        if (false === _element || !event.target.closest(_selector)) {
            event.preventDefault();
        }
    };

    var captureClientY = function (event) {
        if (event.targetTouches.length === 1) {
            _clientY = event.targetTouches[0].clientY;
        }
    };

    var preventOverscroll = function (event) {
        if (event.targetTouches.length !== 1) {
            return;
        }

        var clientY = event.targetTouches[0].clientY - _clientY;

        if (_element.scrollTop === 0 && clientY > 0) {
            event.preventDefault();
        }

        if ((_element.scrollHeight - _element.scrollTop <= _element.clientHeight) && clientY < 0) {
            event.preventDefault();
        }
    };

    return function (allow, selector) {
        if (typeof selector !== 'undefined') {
            _selector = selector;
            _element = document.querySelector(selector);
        }

        if (true === allow) {
            if (false !== _element) {
                _element.addEventListener('touchstart', captureClientY, {
                    passive: false,
                });
                _element.addEventListener('touchmove', preventOverscroll, {
                    passive: false,
                });
            }
            document.body.addEventListener('touchmove', preventBodyScroll, {
                passive: false,
            });
        } else {
            if (false !== _element) {
                _element.removeEventListener('touchstart', captureClientY, {
                    passive: false,
                });
                _element.removeEventListener('touchmove', preventOverscroll, {
                    passive: false,
                });
            }
            document.body.removeEventListener('touchmove', preventBodyScroll, {
                passive: false,
            });
        }
    };
}());

// }

module.exports = disableBodyScroll;