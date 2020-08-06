    /*
    *  This files cointains the custom JavaScript for the admin panel
    *  This files excludes the liberaries
    */


    /* Activates modal delete confirmation
    *  requires className of modal, elementid ("roleid") end the id from the modal without the dash and modalId
    *  like '#deleteUserModal-'+userId == "deleteUserModal"
    */
    const activateDeleteModal = (className,elementId,modalId) => {

        const elements = document.querySelectorAll("."+className);
        for(let element of elements) {
            element.addEventListener("click",function(){
                let elId = element.dataset[elementId];
                $('#'+modalId+'-'+elId).modal();
            });
        }
    };

    /* template for the media gallery when uploading an image
    *  this template is used for showing the uploaded images via ajax after uploaded to the media gallery
    */
    const templateAddMediaToGallery = (data) => {

        let html = `
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card card-figure">
                    <figure class="figure">
                        <div class="figure-img">                                                                                                     <div class="figure-description">
                            <h6 class="figure-title"> ${data.name} </h6>
                            <p class="text-muted mb-0">
                                <small></small>
                            </p>
                            </div>
                            <div class="figure-tools">
                                <a href="#" class="tile tile-circle tile-sm mr-auto">   </a>
                                <p class="badge badge-light">${data.width} x ${data.height}px</p>
                                <p class="badge badge-secondary">image/jpeg</p>
                            </div>
                            <div class="figure-action">
                                <a href="${data.link}" class="btn btn-block btn-sm btn-primary">Open</a>
                            </div>
                            
                            <div class="figure-description">
                                <h6 class="figure-title"> ${data.name}</h6>
                                <p class="text-muted mb-0">
                                    <small></small>
                                </p>
                            </div> 

                            <img class="img-fluid card-img" src="${data.path}" alt="${data.alt}" title="">
                        </div>
                    </figure>
                </div>
            </div>
        `;
        return html;
    }


    /* Front-end validation if slug is already used
    *  validate if the slug excists after button click and update slug
    *  used with create new page or post
    */
    const validateSlug = () => {

        const btnPath = document.querySelector('#btnPath');
        const path = document.querySelector('#path');

        btnPath.addEventListener('click', () => {
            let pathValue = path.value == "" ? null : path.value;
            
            if(pathValue == null) {
                path.value = "post";
                pathValue = "post";
            }

            if(pathValue.charAt(0) == '/') pathValue = pathValue.substring(1);
        
            Promise.all([
                fetch('/api/slugs').then(value => value.json()),
                fetch(`/api/slugs/${pathValue}`).then(value => value.json())
            ]).then((value) => {

                //sanitize path
                if(value[1].path != null && typeof value[1].path == 'string') {
                    path.value = value[1].path;
                    pathValue = value[1].path;
                }

                let validated = false;
                do {
                    //validate if exists
                    let includes;
                    value[0].map(slug => {
                        if(slug.path == pathValue) includes = true;
                    });

                    //slug already exists
                    //update slug and run this function again
                    if(includes) {
                        pathValue = pathValue + "-1";
                    } else {
                        validated = true;
                    }
                }
                while(validated == false);

                path.value = pathValue;

            })
            .catch((err) => {
                console.error(err);
            });
        
        })
    }


    /* AJAX load selected categories in dropdown
    *  for the categories we need a few functions
    *  the getCategories function fetches all categories and takes an array of selected category id's
    *  this function is called each time a category is selected or deselected and updates the dropdown for primary category
    *  The updateSlugwithCategory will update the slug in the slug input field when a category is added
    *  This function is for front-end validation only. There is backend validation as well
    */

    //Ajax adds the options to the dropdown select to chooce the primary category in the create post page
    const getCategories = (categories,primary) => {
        fetch('/api/categories')
        .then(value => value.json())
        .then(value => {
            let form = document.getElementById('dropdownPrimaryCategory');
            let html = `<option value="" selected="selected">No category</option>`;
            if(primary) {
                html = `<option value="">No category</option>`;
            }
            value.map((x) => {
                categories.map((cat) => {
                    if(cat == x.id) {
                        if(primary == x.id) html += `<option value="${x.id}" selected="selected">${x.name}</option>`;
                        else html += `<option value="${x.id}">${x.name}</option>`;
                    }
                });
            });
            form.innerHTML = html;
        })
        .catch((err) => {
            console.error(err);
        });
    } 

    //update the slug when a category is added to a post
    const updateSlugwithCategory = () => {

        const primaryCategory = document.querySelector('#dropdownPrimaryCategory');
        const alertNoPrimaryCategory = document.querySelector('#alertAddCategoryToSlug');
        const slug = document.querySelector('#slug');

        if(primaryCategory.value.length > 0) {
            fetch('/api/category/' + primaryCategory.value)
            .then(value => value.json())
            .then(value => {
                alertNoPrimaryCategory.classList.add('d-none');
                slug.innerHTML = window.location.protocol + '//' + window.location.hostname + '/' + value.path;
            })
            .catch((err) => {
                console.error(err);
            });
        } else {
            //no category so send error message
            const html = '<li>No primary category selected</li>';
            alertNoPrimaryCategory.innerHTML = html;
            alertNoPrimaryCategory.classList.remove('d-none');
            slug.innerHTML = window.location.protocol + '//' + window.location.hostname + '/';
        }
    }


    /* AJAX Featured image 
    *  On the create or edit single posts and pages we like to set a featured image.
    *  We want to load an featured image into the featured image modal via ajax
    *  for this we fetch al images via the API and add these to the modal content
    *  We send the image id to a hidden form field
    *  and show the image after completion
    * */
    const mediaGallery = document.querySelector('#gallery');
    const loadGallery = () => {

        fetch('/api/media')
        .then(value => value.json())
        .then(value => {
            fillMediaGalleryModal(value);
        })
        .catch((err) => {
            console.error(err);
        });
    }

    const fillMediaGalleryModal = (images) => {

        const modalBody = document.querySelector('#gallery');

        images.map((image) => {

            //returns the right size image
            //for performance issues we prefer to load the medium image
            const rightSizeImage = () => {
                for(let img of image.imagefiles) {
                    if(img.size_type == 'medium') return img;
                }
                return image.imagefiles.shift();
            };

            //generates the image attribute html
            const imageHtml = (imagefile) => {
                let html = `
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="card card-figure">
                            <figure class="figure">
                                <div class="figure-img">                                                                                                     <div class="figure-description">
                                    <h6 class="figure-title"> ${image.name} </h6>
                                    <p class="text-muted mb-0">
                                        <small></small>
                                    </p>
                                    </div>
                                    <div class="figure-tools">
                                        <a href="#" class="tile tile-circle tile-sm mr-auto">   </a>
                                        <p class="badge badge-light">${imagefile.resolution.width} x ${imagefile.resolution.height}px</p>
                                        <p class="badge badge-secondary">${imagefile.file_type}</p>
                                    </div>
                                    <div class="figure-action">
                                        <button type="button" data-imageid="${image.id}" class="btn btn-block btn-sm btn-primary btn-featured">Add to post</button>
                                    </div>
                                    
                                    <div class="figure-description">
                                        <h6 class="figure-title"> ${image.name}</h6>
                                        <p class="text-muted mb-0">
                                            <small></small>
                                        </p>
                                    </div>

                                    <img class="img-fluid card-img" src="/${imagefile.path}">
                                </div>
                            </figure>
                        </div>
                    </div>
                `;
                return html;
            }

            let html = imageHtml(rightSizeImage());
            modalBody.innerHTML += html;

        });

        //updates the hidden form field, closes the modal and show the result
        const imageButtons = document.querySelectorAll('.btn-featured');
        const featuredImageHiddenInput = document.querySelector('#featuredImageId');
        const featuredImgaePlaceholder = document.querySelector('#featuredImagePlaceholder');

        for(let btn of imageButtons) {
            btn.addEventListener('click', (e) => {
                featuredImageHiddenInput.value = e.target.dataset.imageid;
                $('#mediaGalleryModal').modal('hide');
                fetch('/api/media/' + e.target.dataset.imageid)
                .then(value => value.json())
                .then(value => {
                    let imagefile = value.image_files.pop();
                    let image = `<img src="/${imagefile.path}" class="img-fluid p-2" alt="">`;
                    featuredImgaePlaceholder.innerHTML = image;
                })
                .catch((err) => {
                    console.error(err);
                });
            });
        }

        
    }


    //this function controls removing the single notifications
    (() => {
        const notificationClearButtons = document.querySelectorAll('.notificationClear');
        for(let notificationClearButton of notificationClearButtons) {
            notificationClearButton.addEventListener('click', (e) => {
                e.preventDefault();

                //call delete method
                const options = {
                    url: '/admin/notifications/' + e.target.dataset.id,
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json;charset=UTF-8'
                    }
                };

                //remove notification via ajax from screen
                axios(options)
                .then(response => {
                    if(response.data) {
                        document.querySelector('#notification-' + response.data).remove();
                    }

                    //check if all notifications are cleared
                    let group = document.querySelector('#notificationListGroup');
                    if (group.childElementCount == 0) {
                        document.querySelector('#notificationDropdown').remove();
                        const indicator = document.querySelectorAll('#navbarDropdownMenuLink1 .indicator');
                        indicator[0].remove();
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
            });
        }
    })();
    

    //this controls removing all notifications
    (() => {
        const notificationClearAll = document.querySelector('#notificationClearAll');
        notificationClearAll.addEventListener('click', (e) => {
            
            e.preventDefault();

            //call delete method
            const options = {
                url: '/admin/notifications/destroyAll',
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json;charset=UTF-8'
                }
            };

            //remove notification via ajax from screen
            axios(options)
            .then(response => {
                if(response.data) {
                    document.querySelector('#notificationDropdown').remove();
                    const indicator = document.querySelectorAll('#navbarDropdownMenuLink1 .indicator');
                    indicator[0].remove();
                }
            })
            .catch((err) => {
                console.error(err);
            });
        })
    })();
    


    

 

