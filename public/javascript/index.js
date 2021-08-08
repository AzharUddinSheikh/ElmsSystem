$("#login").validate({
    rules: {
        email: {
            required: true,
            email: true,
        },
        password: {
            required: true,
        },
    },
});

$('#email').blur(function() {
    var uemail = $(this).val();
    $.ajax({
        url:'view/department.php',
        method:"POST",
        data:{email:uemail},
        success:function(data)
        {   
            if(data != 0)
            {
                $('#available').html('<span class="alert alert-danger" role="alert">'+data+'</span>');
                $('#submit').prop("disabled", true);
            } else {
                $('#submit').prop("disabled", false);
            }
        }
    })
})

$("#setpass").validate({
    rules: {
        pass: {
            required: true,
            minlength: 5,
        },
        pass1: {
            required: true,
            minlength: 5,
            equalTo : "#pass"
        }
    },
    messages: {
        pass1: {
            equalTo: "Password Doesnot Match",
        }
    }
});