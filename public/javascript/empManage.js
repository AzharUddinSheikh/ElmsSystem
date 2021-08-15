$(document).ready(function() {

    document.querySelectorAll('.block').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Block This User")){
                window.location = `/elms/twig/empManage.php?block=${id}`
            }
        })
    })
    
    document.querySelectorAll('.unblock').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To UnBlock This User")){
                window.location = `/elms/twig/empManage.php?unblock=${id}`
            }
        })
    })

    document.querySelectorAll('.edit').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            location.href = `edit.php?id=${id}`;
        })
    })
    
    document.querySelectorAll('.view').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            window.location = `/elms/twig/userLeave.php?id=${id}`
        })
    })
})

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}