$(document).ready(function() {    

    document.querySelectorAll('.approveS').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id2 = e.target.name.substr(0,);
            if(confirm("Are You Sure To Approved")) {
                window.location = `/elms/twig/twigAdmin.php?Sapprove=${id}&userdetails=${id2}`
            }
        })
    })
    
    document.querySelectorAll('.rejectS').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id2 = e.target.name.substr(0,);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/twig/twigAdmin.php?Sreject=${id}&userdetails=${id2}`
            }
        })
    })
})

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}
