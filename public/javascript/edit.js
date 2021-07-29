$.validator.addMethod("noSpace", function (value, element) {
    return /^[a-zA-Z]+$/.test(value);
}, "No Space And No Number Begin With");

$.validator.addMethod("greater", function (value, element) {
    var today = new Date();
    var dob = new Date(value);
    return (today.getFullYear() - dob.getFullYear()) >= 18;
}, "Age is Invalid Should be Above 18");

$(function(){
    $("#dob").datepicker({ dateFormat: 'yy-mm-dd' });
});

$(function () {
    $("form[name='edit']").validate({
        rules: {
        fname: {
            required: true,
            noSpace: true,
        },
        lname: {
            required: true,
            noSpace: true,
        },
        dob: {
            required: true,
            date: true,
            greater: true
        },
        number: {
            required: true,
            minlength: 10,
            maxlength: 10,
        },
        email: {
            required: true,
            email: true
        },
        photo: {
            required: false,
            }
        },
    });
});

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}