$("#myForm").validate({
    rules:{
        oldpass:{
            required: true
        },
        pass:{
            required: true,
            minlength: 5,
        }
    },
    submitHandler : function (form) {
        var old = $("#oldpass").val();
        var pass = $("#pass").val();
        $.ajax({
            url:'../view/department.php',
            method:"POST",
            data:{oldpass:old, newpass:pass},
            success:function(data)
            {   
                $('#available').html('<span class="text-danger">'+data+'</span>');
                document.getElementById("myForm").reset(); 
            }
        })
    }
})

document.querySelectorAll('.cancel').forEach((element)=>{
    element.addEventListener("click",(e)=>{
        id = e.target.id.substr(0,);
        if(confirm("Are You Sure To Delete This Request")){
            window.location = `twigUserLeave.php?cancel=${id}`
        }
    })
})

document.querySelectorAll('.view').forEach((element)=>{
    element.addEventListener("click",(e)=>{
        id = e.target.id.substr(0,);
        $.ajax({
            url: '../view/department.php',
            method: 'POST',
            data:{id : id},
            success: function(data){
                $('.modal-body').html(data);
                $('#exampleModal').modal('toggle');
            }
        })
    })
})

document.querySelectorAll('.userdetails').forEach((element)=>{
    element.addEventListener("click",(e)=>{
        id = e.target.id.substr(0,);
        window.location = `/elms/twig/twigCheckStatus.php?userdetails=${id}`
    })
})