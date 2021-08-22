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

$("form[name='applyLeave']").validate({
    rules: {
        textarea: {
            required: true,
            minlength: 6
        },
        dob: {
            required: true,
            date: true,
            greaterThan: true
        },
        dob1: {
            required: true,
            date: true,
            greaterThan: true,
            greater: true,
        }
    },

    submitHandler: function (form) {
        form.submit();
    }
});

document.querySelectorAll('.export').forEach((element)=>{
    element.addEventListener("click", (e)=>{
        id = e.target.id;
        $.ajax({
            url:'../view/department.php',
            method:"POST",
            data:{export:id},
            success:function(data)
            {
                $('#exported').html('<span class="alert alert-danger mx-5" role="alert">'+data+'</span>');
            }
        })
    })
})