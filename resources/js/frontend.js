/*
* This file contains the custom JavaScript used on the front-end
* This file excludes the liberaries
*/

//scroll to anchor
(function() {
    // to top right away
    if (window.location.hash) scroll(0, 0);
    // void some browsers issue
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
})();

//comment form handeling when replying to a comment
const commentFormReplyInit = () => {
    const btnReply = document.querySelectorAll('#comments .btn-reply');
    for(let btn of btnReply) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const commentId = document.querySelector('#commentId');
            const commentReact = document.querySelector('#commentReact');

            fetch('/api/comments/' + e.target.dataset.commentid)
            .then(value => value.json())
            .then(value => {
                let msg = `
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Reactie op ${value.user.name} 
                        <button id="commentRefresh" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `;
                commentReact.innerHTML = msg;
                commentId.value = e.target.dataset.commentid;

                document.querySelector('#commentRefresh').addEventListener('click', (e) => {
                    commentId.value = null;
                });
            })
            .catch((err) => {
                console.error(err);
            });
            
            $('html, body').animate({
                scrollTop: $('#commentForm').offset().top - 200
            }, 500);
        });
    }
}