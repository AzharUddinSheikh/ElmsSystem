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
            greaterThan: true,
            isPrivalage:true
        },
        dob1: {
            required: true,
            date: true,
            greaterThan: true,
            greater: true,
            isPrivalage:true
        },
        leavetype: {
            required:true,
        },
        docx: {
            required: $("#leavetype").val() === "1",  
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
});


$("form[name='myFormyear']").validate({
    rules: {
        enyear: {
            required: true,
            minlength: 4,
            maxlength: 4,
            
        }
    },

    

    submitHandler: function (form) {
        form.submit();
    }
});

$(document).ready(function () {
    $("#enyear").keypress(function (e) {
       if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          $("#errmsg").html("Only digits allowed").show();
                 return false;
      }
     });
  });