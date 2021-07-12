$(function () {
    $("form[name='edit']").validate({
        rules: {
        fname: {
            required: true,
        },
        lname: {
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
