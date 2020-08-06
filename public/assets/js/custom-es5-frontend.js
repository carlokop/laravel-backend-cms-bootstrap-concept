function _createForOfIteratorHelper(o) { if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) { var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var it, normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(n); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/*
* This file contains the custom JavaScript used on the front-end
* This file excludes the liberaries
*/
//scroll to anchor
(function () {
  // to top right away
  if (window.location.hash) scroll(0, 0); // void some browsers issue

  setTimeout(scroll(0, 0), 1);
  var hashLink = window.location.hash;

  if ($(hashLink).length) {
    $(function () {
      // *only* if we have anchor on the url
      // smooth scroll to the anchor id
      $('html, body').animate({
        scrollTop: $(window.location.hash).offset().top - 200
      }, 500);
    });
  }
})(); //comment form handeling when replying to a comment


var commentFormReplyInit = function commentFormReplyInit() {
  var btnReply = document.querySelectorAll('#comments .btn-reply');

  var _iterator = _createForOfIteratorHelper(btnReply),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var btn = _step.value;
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var commentId = document.querySelector('#commentId');
        var commentReact = document.querySelector('#commentReact');
        fetch('/api/comments/' + e.target.dataset.commentid).then(function (value) {
          return value.json();
        }).then(function (value) {
          var msg = "\n                    <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n                        Reactie op ".concat(value.user.name, " \n                        <button id=\"commentRefresh\" type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n                            <span aria-hidden=\"true\">&times;</span>\n                        </button>\n                    </div>\n                ");
          commentReact.innerHTML = msg;
          commentId.value = e.target.dataset.commentid;
          document.querySelector('#commentRefresh').addEventListener('click', function (e) {
            commentId.value = null;
          });
        })["catch"](function (err) {
          console.error(err);
        });
        $('html, body').animate({
          scrollTop: $('#commentForm').offset().top - 200
        }, 500);
      });
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
};
