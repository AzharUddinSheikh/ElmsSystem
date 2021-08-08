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
                    if (data > 24) {
                        alert("User Have Exceeded Leave For This Year");
                    } 
                    if(confirm("Are You Sure To Approved")) {
                        window.location = `/elms/twig/twigPendingLeave.php?approve=${id}`
                    }
                }
            })
        })
    })

    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/twig/twigPendingLeave.php?reject=${id}`
            }
        })
    })

    document.querySelectorAll('.userdetails').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            window.location = `/elms/twig/twigCheckStatus.php?userdetails=${id}`
        })
    })
})