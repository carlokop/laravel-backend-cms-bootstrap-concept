//delete user
if(document.getElementsByClassName("userDelete")) {

    const userDeleteButtons = document.querySelectorAll(".userDelete");
    for(let userDelete of userDeleteButtons) {
        userDelete.addEventListener("click",function(){
            let userId = userDelete.dataset.userid;
            $('#deleteUserModal-'+userId).modal();
        });
    }
    
}

if(document.getElementsByClassName("userRole")) {

    const userDeleteButtons = document.querySelectorAll(".userRole");
    for(let userDelete of userDeleteButtons) {
        userDelete.addEventListener("click",function(){
            let roleId = userDelete.dataset.roleid;
            $('#deleteRoleModal-'+roleId).modal();
        });
    }
    
}
