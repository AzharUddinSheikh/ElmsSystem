$(document).ready(function() {

    $('#email').blur(function() {
        var email = $(this).val();

        if(email == '') {
            $('#available').html('<span class="text-danger">Email Field Should Not Empty</span>');
       
            $('#search').prop('disabled', true);
        
        } else { 
            
            $('#search').prop('disabled', false);
        
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{user_email:email},
                success:function(data)
                {   
                    if(data == 0)
                    {
                        $('#available').html('<span class="text-danger">Email Not Exists</span>');
                        $('#search').prop('disabled', true);
                    }
                    else 
                    {
                        $('#available').html('<span class="text-success">Email Found Click For Reset Link</span>');
                        $('#search').prop('disabled', false);
                    }
                }
            })
        }
    })

    document.querySelectorAll('.approveS').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id2 = e.target.name.substr(0,);
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{approveS:id2},
                success:function(data){
                    if (data > 24) {
                        alert("User Have Exceeded Leave For This Year");
                    } 
                    if(confirm("Are You Sure To Approved")) {
                        window.location = `/elms/twig/checkStatus.php?Sapprove=${id}&userdetails=${id2}`
                    }
                }
            })
        })
    })

    document.querySelectorAll('.rejectS').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id2 = e.target.name.substr(0,);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/twig/checkStatus.php?Sreject=${id}&userdetails=${id2}`
            }
        })
    })
})

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}
