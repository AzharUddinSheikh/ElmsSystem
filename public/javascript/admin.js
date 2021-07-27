$(document).ready(function() {

    $('#submit').prop("disabled", true);

    $('#dname').blur(function() {
        var dname = $(this).val();

        if( dname.trim().length ==  0) {
            $('#available').html('<span class="text-warning">Provide The Department Name</span>');
            $('#submit').prop("disabled", true);
        } else {
            $.ajax({
                url:'department.php',
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
    })
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
                window.location = `/elms/twigAdmin.php?block=${id}`
            }
        })
    })
    
    document.querySelectorAll('.unblock').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To UnBlock This User")){
                window.location = `/elms/twigAdmin.php?unblock=${id}`
            }
        })
    })
    
    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Approved")) {
                window.location = `/elms/twigAdmin.php?approve=${id}`
            }
        })
    })
    
    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/twigAdmin.php?reject=${id}`
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
            location.href = `twigLeaveDetail.php?leave=${id}`;
        })
    })
    
    document.querySelectorAll('.cancel').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Delete This")){
                window.location = `/elms/twigAdmin.php?cancel=${id}`
            }
        })
    })
})
