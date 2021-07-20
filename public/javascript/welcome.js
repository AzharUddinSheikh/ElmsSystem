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
            url:'department.php',
            method:"POST",
            data:{oldpass:old, newpass:pass},
            success:function(data)
            {   
                $('#available').html('<span class="text-warning">'+data+'</span>');
            }
        })
    }
})

$("#myForm").submit(function () {
        $("#myForm")[0].reset();
        return false;

});

document.querySelectorAll('.cancel').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Delete This Request")){
                window.location = `/elms/view/welcome.php?cancel=${id}`
            }
        })
    })
