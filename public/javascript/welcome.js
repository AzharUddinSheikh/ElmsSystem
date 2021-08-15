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

$.validator.addMethod("greaterThan", function (value, element) {
    var today = new Date();
    return Date.parse(value) >= Date.parse(today);
}, "Date Should be greater than Today");

$.validator.addMethod("greater", function (value, element) {
    var startdate = $('#dob').val();
    return Date.parse(value) >= Date.parse(startdate);
}, "End Date Should Be Greater than Start Date");

$("form[name='applyLeave']").validate({
    rules: {
        textarea: {
            required: true,
            minlength: 15
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
    messages: {
        textarea: {
            required: "Please Provide Reason",
            minlength: "reason should be atleast 15 character"
        }
    },
    submitHandler: function (form) {
        form.submit();
    }
});

$(function(){
    $(".date").datepicker({ dateFormat: 'yy-mm-dd' });
});

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}
