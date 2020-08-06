function _createForOfIteratorHelper(o) { if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) { var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var it, normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(n); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/*
*  This files cointains the custom JavaScript for the admin panel
*  This files excludes the liberaries
*/

/* Activates modal delete confirmation
*  requires className of modal, elementid ("roleid") end the id from the modal without the dash and modalId
*  like '#deleteUserModal-'+userId == "deleteUserModal"
*/
var activateDeleteModal = function activateDeleteModal(className, elementId, modalId) {
  var elements = document.querySelectorAll("." + className);

  var _iterator = _createForOfIteratorHelper(elements),
      _step;

  try {
    var _loop = function _loop() {
      var element = _step.value;
      element.addEventListener("click", function () {
        var elId = element.dataset[elementId];
        $('#' + modalId + '-' + elId).modal();
      });
    };

    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      _loop();
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
};
/* template for the media gallery when uploading an image
*  this template is used for showing the uploaded images via ajax after uploaded to the media gallery
*/


var templateAddMediaToGallery = function templateAddMediaToGallery(data) {
  var html = "\n            <div class=\"col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12\">\n                <div class=\"card card-figure\">\n                    <figure class=\"figure\">\n                        <div class=\"figure-img\">                                                                                                     <div class=\"figure-description\">\n                            <h6 class=\"figure-title\"> ".concat(data.name, " </h6>\n                            <p class=\"text-muted mb-0\">\n                                <small></small>\n                            </p>\n                            </div>\n                            <div class=\"figure-tools\">\n                                <a href=\"#\" class=\"tile tile-circle tile-sm mr-auto\">   </a>\n                                <p class=\"badge badge-light\">").concat(data.width, " x ").concat(data.height, "px</p>\n                                <p class=\"badge badge-secondary\">image/jpeg</p>\n                            </div>\n                            <div class=\"figure-action\">\n                                <a href=\"").concat(data.link, "\" class=\"btn btn-block btn-sm btn-primary\">Open</a>\n                            </div>\n                            \n                            <div class=\"figure-description\">\n                                <h6 class=\"figure-title\"> ").concat(data.name, "</h6>\n                                <p class=\"text-muted mb-0\">\n                                    <small></small>\n                                </p>\n                            </div> \n\n                            <img class=\"img-fluid card-img\" src=\"").concat(data.path, "\" alt=\"").concat(data.alt, "\" title=\"\">\n                        </div>\n                    </figure>\n                </div>\n            </div>\n        ");
  return html;
};
/* Front-end validation if slug is already used
*  validate if the slug excists after button click and update slug
*  used with create new page or post
*/


var validateSlug = function validateSlug() {
  var btnPath = document.querySelector('#btnPath');
  var path = document.querySelector('#path');
  btnPath.addEventListener('click', function () {
    var pathValue = path.value == "" ? null : path.value;

    if (pathValue == null) {
      path.value = "post";
      pathValue = "post";
    }

    if (pathValue.charAt(0) == '/') pathValue = pathValue.substring(1);
    Promise.all([fetch('/api/slugs').then(function (value) {
      return value.json();
    }), fetch("/api/slugs/".concat(pathValue)).then(function (value) {
      return value.json();
    })]).then(function (value) {
      //sanitize path
      if (value[1].path != null && typeof value[1].path == 'string') {
        path.value = value[1].path;
        pathValue = value[1].path;
      }

      var validated = false;

      do {
        //validate if exists
        var includes = void 0;
        value[0].map(function (slug) {
          if (slug.path == pathValue) includes = true;
        }); //slug already exists
        //update slug and run this function again

        if (includes) {
          pathValue = pathValue + "-1";
        } else {
          validated = true;
        }
      } while (validated == false);

      path.value = pathValue;
    })["catch"](function (err) {
      console.error(err);
    });
  });
};
/* AJAX load selected categories in dropdown
*  for the categories we need a few functions
*  the getCategories function fetches all categories and takes an array of selected category id's
*  this function is called each time a category is selected or deselected and updates the dropdown for primary category
*  The updateSlugwithCategory will update the slug in the slug input field when a category is added
*  This function is for front-end validation only. There is backend validation as well
*/
//Ajax adds the options to the dropdown select to chooce the primary category in the create post page


var getCategories = function getCategories(categories, primary) {
  fetch('/api/categories').then(function (value) {
    return value.json();
  }).then(function (value) {
    var form = document.getElementById('dropdownPrimaryCategory');
    var html = "<option value=\"\" selected=\"selected\">No category</option>";

    if (primary) {
      html = "<option value=\"\">No category</option>";
    }

    value.map(function (x) {
      categories.map(function (cat) {
        if (cat == x.id) {
          if (primary == x.id) html += "<option value=\"".concat(x.id, "\" selected=\"selected\">").concat(x.name, "</option>");else html += "<option value=\"".concat(x.id, "\">").concat(x.name, "</option>");
        }
      });
    });
    form.innerHTML = html;
  })["catch"](function (err) {
    console.error(err);
  });
}; //update the slug when a category is added to a post


var updateSlugwithCategory = function updateSlugwithCategory() {
  var primaryCategory = document.querySelector('#dropdownPrimaryCategory');
  var alertNoPrimaryCategory = document.querySelector('#alertAddCategoryToSlug');
  var slug = document.querySelector('#slug');

  if (primaryCategory.value.length > 0) {
    fetch('/api/category/' + primaryCategory.value).then(function (value) {
      return value.json();
    }).then(function (value) {
      alertNoPrimaryCategory.classList.add('d-none');
      slug.innerHTML = window.location.protocol + '//' + window.location.hostname + '/' + value.path;
    })["catch"](function (err) {
      console.error(err);
    });
  } else {
    //no category so send error message
    var html = '<li>No primary category selected</li>';
    alertNoPrimaryCategory.innerHTML = html;
    alertNoPrimaryCategory.classList.remove('d-none');
    slug.innerHTML = window.location.protocol + '//' + window.location.hostname + '/';
  }
};
/* AJAX Featured image 
*  On the create or edit single posts and pages we like to set a featured image.
*  We want to load an featured image into the featured image modal via ajax
*  for this we fetch al images via the API and add these to the modal content
*  We send the image id to a hidden form field
*  and show the image after completion
* */


var mediaGallery = document.querySelector('#gallery');

var loadGallery = function loadGallery() {
  fetch('/api/media').then(function (value) {
    return value.json();
  }).then(function (value) {
    fillMediaGalleryModal(value);
  })["catch"](function (err) {
    console.error(err);
  });
};

var fillMediaGalleryModal = function fillMediaGalleryModal(images) {
  var modalBody = document.querySelector('#gallery');
  images.map(function (image) {
    //returns the right size image
    //for performance issues we prefer to load the medium image
    var rightSizeImage = function rightSizeImage() {
      var _iterator2 = _createForOfIteratorHelper(image.imagefiles),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var img = _step2.value;
          if (img.size_type == 'medium') return img;
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }

      return image.imagefiles.shift();
    }; //generates the image attribute html


    var imageHtml = function imageHtml(imagefile) {
      var html = "\n                    <div class=\"col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12\">\n                        <div class=\"card card-figure\">\n                            <figure class=\"figure\">\n                                <div class=\"figure-img\">                                                                                                     <div class=\"figure-description\">\n                                    <h6 class=\"figure-title\"> ".concat(image.name, " </h6>\n                                    <p class=\"text-muted mb-0\">\n                                        <small></small>\n                                    </p>\n                                    </div>\n                                    <div class=\"figure-tools\">\n                                        <a href=\"#\" class=\"tile tile-circle tile-sm mr-auto\">   </a>\n                                        <p class=\"badge badge-light\">").concat(imagefile.resolution.width, " x ").concat(imagefile.resolution.height, "px</p>\n                                        <p class=\"badge badge-secondary\">").concat(imagefile.file_type, "</p>\n                                    </div>\n                                    <div class=\"figure-action\">\n                                        <button type=\"button\" data-imageid=\"").concat(image.id, "\" class=\"btn btn-block btn-sm btn-primary btn-featured\">Add to post</button>\n                                    </div>\n                                    \n                                    <div class=\"figure-description\">\n                                        <h6 class=\"figure-title\"> ").concat(image.name, "</h6>\n                                        <p class=\"text-muted mb-0\">\n                                            <small></small>\n                                        </p>\n                                    </div>\n\n                                    <img class=\"img-fluid card-img\" src=\"/").concat(imagefile.path, "\">\n                                </div>\n                            </figure>\n                        </div>\n                    </div>\n                ");
      return html;
    };

    var html = imageHtml(rightSizeImage());
    modalBody.innerHTML += html;
  }); //updates the hidden form field, closes the modal and show the result

  var imageButtons = document.querySelectorAll('.btn-featured');
  var featuredImageHiddenInput = document.querySelector('#featuredImageId');
  var featuredImgaePlaceholder = document.querySelector('#featuredImagePlaceholder');

  var _iterator3 = _createForOfIteratorHelper(imageButtons),
      _step3;

  try {
    for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
      var btn = _step3.value;
      btn.addEventListener('click', function (e) {
        featuredImageHiddenInput.value = e.target.dataset.imageid;
        $('#mediaGalleryModal').modal('hide');
        fetch('/api/media/' + e.target.dataset.imageid).then(function (value) {
          return value.json();
        }).then(function (value) {
          var imagefile = value.image_files.pop();
          var image = "<img src=\"/".concat(imagefile.path, "\" class=\"img-fluid p-2\" alt=\"\">");
          featuredImgaePlaceholder.innerHTML = image;
        })["catch"](function (err) {
          console.error(err);
        });
      });
    }
  } catch (err) {
    _iterator3.e(err);
  } finally {
    _iterator3.f();
  }
}; //this function controls removing the single notifications


(function () {
  var notificationClearButtons = document.querySelectorAll('.notificationClear');

  var _iterator4 = _createForOfIteratorHelper(notificationClearButtons),
      _step4;

  try {
    for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
      var notificationClearButton = _step4.value;
      notificationClearButton.addEventListener('click', function (e) {
        e.preventDefault(); //call delete method

        var options = {
          url: '/admin/notifications/' + e.target.dataset.id,
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json;charset=UTF-8'
          }
        }; //remove notification via ajax from screen

        axios(options).then(function (response) {
          if (response.data) {
            document.querySelector('#notification-' + response.data).remove();
          } //check if all notifications are cleared


          var group = document.querySelector('#notificationListGroup');

          if (group.childElementCount == 0) {
            document.querySelector('#notificationDropdown').remove();
            var indicator = document.querySelectorAll('#navbarDropdownMenuLink1 .indicator');
            indicator[0].remove();
          }
        })["catch"](function (err) {
          console.error(err);
        });
      });
    }
  } catch (err) {
    _iterator4.e(err);
  } finally {
    _iterator4.f();
  }
})(); //this controls removing all notifications


(function () {
  var notificationClearAll = document.querySelector('#notificationClearAll');
  notificationClearAll.addEventListener('click', function (e) {
    e.preventDefault(); //call delete method

    var options = {
      url: '/admin/notifications/destroyAll',
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json;charset=UTF-8'
      }
    }; //remove notification via ajax from screen

    axios(options).then(function (response) {
      if (response.data) {
        document.querySelector('#notificationDropdown').remove();
        var indicator = document.querySelectorAll('#navbarDropdownMenuLink1 .indicator');
        indicator[0].remove();
      }
    })["catch"](function (err) {
      console.error(err);
    });
  });
})();
