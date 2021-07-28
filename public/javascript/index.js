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
            if(data == 0)
            {
                $('#available').html('<span class="text-success"></span>');
            }
            else 
            {
                $('#available').html('<span>'+data+'</span>');
            }
        }
    })
  })