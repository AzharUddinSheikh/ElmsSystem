$("#setpass").validate({
    rules: {
        pass: {
            required: true,
            minlength: 5,
        },
        pass1: {
            required: true,
            minlength: 5,
            equalTo : "#pass"
        }
    },
    messages: {
        pass1: {
            equalTo: "Password Doesnot Match",
        }
    }
});