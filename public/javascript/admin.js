$(document).ready(function() {
    $('#email').blur(function() {
        var email = $(this).val();
        if(email == '') {
            $('#available').html('<span></span>');
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
                        $('#available').html('<span></span>');
                        $('#search').prop('disabled', false);
                    }
                }
            })
        }
    })
})

