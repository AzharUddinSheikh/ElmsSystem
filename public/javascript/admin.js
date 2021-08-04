$(document).ready(function() {

    $('#submit').prop("disabled", true);

    $('#dname').blur(function() {
        var dname = $(this).val();

        if( dname.trim().length ==  0) {
            $('#available').html('<span class="text-warning">Provide The Department Name</span>');
            $('#submit').prop("disabled", true);
        } else {
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{dep_name:dname},
                success:function(data)
            
                {   
                    if(data == 0)
                    {
                        $('#available').html('<span class="text-info">Department Not Available</span>');
                        $('#submit').prop("disabled", false);
                    }
                    else 
                    {
                        $('#available').html('<span class="text-danger">Department Available Cant Add</span>');
                        $('#submit').prop("disabled", true);
                    }
                }
            })
        }
    });

    $(function(){
        $(".date").datepicker({ dateFormat: 'yy-mm-dd' });
    });
})

$(document).ready(function() {
    $("#submit").click(function() {
        var dname = $("#myForm :input").serializeArray();
        $.post( $("#myForm").attr("action"), dname, function(info) {
            $('#available').html(`<span class="text-success">${info}</span>`);
        });
    });

    $("#myForm").submit(function () {
        $("#myForm")[0].reset();
        $('#submit').prop("disabled", true);
        return false;
    });

    document.querySelectorAll('.block').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Block This User")){
                window.location = `/elms/twig/twigAdmin.php?block=${id}`
            }
        })
    })
    
    document.querySelectorAll('.unblock').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To UnBlock This User")){
                window.location = `/elms/twig/twigAdmin.php?unblock=${id}`
            }
        })
    })
    
    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Approved")) {
                window.location = `/elms/twig/twigAdmin.php?approve=${id}`
            }
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
    
    document.querySelectorAll('.edit').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            location.href = `twigEdit.php?id=${id}`;
        })
    })
    
    document.querySelectorAll('.view').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            $.ajax({
                url: '../view/department.php',
                method: 'POST',
                data:{user_leave_id : id},
                success: function(data){
                    $('.modal-body').html(data);
                    $('#leaveModal').modal('toggle');
                }
            })
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
