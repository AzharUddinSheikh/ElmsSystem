$(document).ready(function() {

    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id2 = e.target.name.substr(0,);
            if(confirm("Are You Sure To Approved")) {
                window.location = `/elms/twig/twigLeaveDetail.php?approve=${id}&leave=${id2}`
            }
        })
    })
    
    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id2 = e.target.name.substr(0,);
            console.log(id,id2);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/twig/twigLeaveDetail.php?reject=${id}&leave=${id2}`
            }
        })
    })
})