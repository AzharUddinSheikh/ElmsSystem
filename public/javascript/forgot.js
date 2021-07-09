$(document).ready(function() {
    $('#email').blur(function() {
        var email = $(this).val();

        if(email == '') {
            $('#available').html('<span class="text-danger">Email Field Should Not Empty</span>');
       
            $('.submit').hide();
        
        } else { 
            
            $('.submit').show();
        
            $.ajax({
                url:'department.php',
                method:"POST",
                data:{user_email:email},
                success:function(data)
                {   
                    if(data == 0)
                    {
                        $('#available').html('<span class="text-danger">Email Not Exists</span>');
                        $('.submit').hide();
                    }
                    else 
                    {
                        $('#available').html('<span class="text-success">Email Found Click For Reset Link</span>');
                        $('.submit').show();
                    }
                }
            })
        }
    })
})