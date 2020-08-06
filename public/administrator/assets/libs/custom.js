

if(document.getElementById("deleteUserModal")) {

    const userDeleteButtons = document.querySelectorAll(".userDelete");
    for(let userDelete of userDeleteButtons) {
        userDelete.addEventListener("click",function(){
            let userName = userDelete.dataset.username;
            let userId = userDelete.dataset.userid;
            document.querySelector("#modalUserName").innerHTML = userName+ ' ';
            $('#deleteUserModal').modal();
        });
    }
    
}

