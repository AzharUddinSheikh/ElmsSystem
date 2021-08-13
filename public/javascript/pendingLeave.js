$(document).ready(function() {
    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id1 = e.target.name.substr(0,);
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{approve:id1, ids:id},
                success:function(data){
                    if (data > 23) {
                        alert("User Will Exceed Leave For This Year");
                    } 
                    if(confirm("Are You Sure To Approved")) {
                        window.location = `/elms/twig/pendingLeave.php?approve=${id}`
                    }
                }
            })
        })
    })

    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/twig/pendingLeave.php?reject=${id}`
            }
        })
    })

    document.querySelectorAll('.userdetails').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            window.location = `/elms/twig/checkStatus.php?userdetails=${id}`
        })
    })
})