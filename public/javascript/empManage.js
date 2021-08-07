$(document).ready(function() {

    document.querySelectorAll('.block').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Block This User")){
                window.location = `/elms/twig/twigEmpManage.php?block=${id}`
            }
        })
    })
    
    document.querySelectorAll('.unblock').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To UnBlock This User")){
                window.location = `/elms/twig/twigEmpManage.php?unblock=${id}`
            }
        })
    })

    document.querySelectorAll('.edit').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            location.href = `twigEdit.php?id=${id}`;
        })
    })
    
    document.querySelectorAll('.delete').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Delete This User")){
                window.location = `/elms/twig/twigEmpManage.php?delete=${id}`
            }
        })
    })
})

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}