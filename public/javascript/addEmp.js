$.validator.addMethod("noSpace", function (value, element) {
    return /^[a-zA-Z]+$/.test(value);
}, "No Space And No Number");

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

$(document).ready(function() {
    $('#dob').blur(function() {
        var date = new Date($(this).val());
        var duration = ((new Date()) - date)/(1000*60*60*24);
        if (duration < 6580) {
            document.getElementById("dobID").innerHTML = "You are not 18";
            document.getElementById("dobID").style.color = "red";
            $('#submit').prop("disabled", true);
        } else if (duration >= 6580) {
            document.getElementById("dobID").innerHTML = "Above 18 ";
            document.getElementById("dobID").style.warnning = "yellow";
            $('#submit').prop("disabled", false);
        }
    })
})

$(function(){
    $("#dob").datepicker({ dateFormat: 'yy-mm-dd' });
});