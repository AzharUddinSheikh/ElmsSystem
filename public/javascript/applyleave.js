$(document).ready(function() {

    $.validator.addMethod("greaterThan", function (value, element) {
        var today = new Date();
        return Date.parse(value) >= Date.parse(today);
    }, "Date Should be greater than Today");
    
    $.validator.addMethod("greater", function (value, element) {
        var startdate = $('#dob').val();
        return Date.parse(value) >= Date.parse(startdate);
    }, "End Date Should Be Greater than Start Date");
   
    $(function () {
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
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {
                form.submit();
            }
        });
    }); 

    $(function(){
        $(".date").datepicker();
    });

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href )
    }

});