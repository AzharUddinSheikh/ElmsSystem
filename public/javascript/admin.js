
$(document).ready(function() {

    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id1 = e.target.name.substr(0,);
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{approve:id1},
                success:function(data){
                    console.log(data);
                    if (data >= 3) {
                        alert("User Have Exceeded Leave For This Year");
                    } 
                    if(confirm("Are You Sure To Approved")) {
                        window.location = `/elms/twig/twigAdmin.php?approve=${id}`
                    }
                }
            })
        })
    })
    
    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/twig/twigAdmin.php?reject=${id}`
            }
        })
    })

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

    document.querySelectorAll('.userdetails').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            window.location = `/elms/twig/twigAdmin.php?userdetails=${id}`
        })
    })
})

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}
