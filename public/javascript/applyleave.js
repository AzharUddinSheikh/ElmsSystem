$(document).ready(function() {
    // Wait for the DOM to be ready
    $(function () {
        $("form[name='applyLeave']").validate({
            rules: {
                textarea: {
                    required: true,
                    minlength: 15
                },
                dob: {
                    required: true,
                    date: true
                },
                dob1: {
                    required: true,
                    date: true
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
    
  });