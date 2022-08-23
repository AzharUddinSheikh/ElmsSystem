$(document).ready(function() {

    document.querySelectorAll('.block').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Block This User")){
                window.location = `/ElmsSystem-sahil/twig/empManage.php?block=${id}`
            }
        })
    })

    document.querySelectorAll('.unblock').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To UnBlock This User")){
                window.location = `/ElmsSystem-sahil/twig/empManage.php?unblock=${id}`
            }
        })
    })
})
