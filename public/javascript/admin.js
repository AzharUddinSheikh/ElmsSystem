$(document).ready(function() {
    $('#dname').blur(function() {
        var dname = $(this).val();

        $.ajax({
            url:'department.php',
            method:"POST",
            data:{dep_name:dname},
            success:function(data)
        
            {   
                if(data == 0)
                {
                    $('#available').html('<span class="text-danger">Department Not Available</span>');
                    $('.hide').show();
                }
                else 
                {
                    $('#available').html('<span class="text-success">Department Available Cant Add</span>');
                    $('.hide').hide();
                }
            }
        })
    })
})

$(document).ready(function() {
    $("#submit").click(function() {
        var dname = $("#myForm :input").serializeArray();
        $.post( $("#myForm").attr("action"), dname, function(info) {
            alert(info);
        });
    });

    $("#myForm").submit(function () {
        $("#myForm")[0].reset();
        return false;

    });

    document.querySelectorAll('.block').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Block This User")){
                window.location = `/elms/view/admin.php?block=${id}`
            }
        })
    })
    
    document.querySelectorAll('.unblock').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To UnBlock This User")){
                window.location = `/elms/view/admin.php?unblock=${id}`
            }
        })
    })

    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Approved")) {
                window.location = `/elms/view/admin.php?approve=${id}`
            }
        })
    })

    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/view/admin.php?reject=${id}`
            }
        })
    })
    
    document.querySelectorAll('.edit').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            location.href = `../view/editprofile.php?id=${id}`;
        })
    })
    
    document.querySelectorAll('.view').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            location.href = `../view/leaveDetail.php?leave=${id}`;
        })
    })

    document.querySelectorAll('.cancel').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Delete This")){
                window.location = `/elms/view/admin.php?cancel=${id}`
            }
        })
    })
})
