$("#addemp").validate({
    rules: {
        fname: {
            required: true,
            noSpace: true,
        },
        lname: {
            required: true,
            noSpace: true,
        },
        dname: {
            required: true,
        },
        dob: {
            required: true,
            date: true,
            greaterD: true,
        },
        number: {
            required: true,
            minlength: 10,
            maxlength: 10,
        },
        empid: {
            required: true,
            minlength: 6,
            maxlength: 6,
        },
        utype: {
            required: true,
        },
        email: {
            required: true,
            email: true
        },
    },
});

$('#uEmail').blur(function() {
  var uemail = $(this).val();

  $.ajax({
      url:'../view/department.php',
      method:"POST",
      data:{user_email:uemail},
      success:function(data)
      {   
          if(data == 0)
          {
              $('#available').html('<span class="text-success"></span>');
              $('#submit').prop("disabled", false);
          }
          else 
          {
              $('#available').html('<span class="text-warning">Email Available Unable to Submit</span>');
              $('#submit').prop("disabled", true);
          }
      }
  })
})