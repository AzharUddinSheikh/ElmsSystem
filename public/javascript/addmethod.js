$.validator.addMethod("greater", function (value, element) {
    var startdate = $('#dob').val();
    return Date.parse(value) >= Date.parse(startdate);
}, "End Date Should Be Greater than Start Date");

$.validator.addMethod("greaterThan", function (value, element) {
    var today = new Date();
    return Date.parse(value) >= Date.parse(today);
}, "Date Should be greater than Today");

$.validator.addMethod("userLeave", function (value, element) {
    var startdate = Date.parse($('#dob').val());
    id = document.getElementById("userleaveid").value;
    var data;
    $.ajax({
        async: false,
        type:"POST",
        url: "../view/department.php",
        data: {leave_id: id},
        dataType:"json",
        success: function(resp){
            data = resp;
        }
    });
    return ((startdate >= Date.parse(data[0])));
}, "Start Date Should Not Be Less Than User Start Date");

$.validator.addMethod("userLeave1", function (value, element) {
    var enddate = Date.parse($('#dob1').val());
    id = document.getElementById("userleaveid").value;
    var data;
    $.ajax({
        async: false,
        type:"POST",
        url: "../view/department.php",
        data: {leave_id: id},
        dataType:"json",
        success: function(resp){
            data = resp;
        }
    });
    return (enddate <= Date.parse(data[1]));
}, "End Date Should Not Be Greater Than User End Date");


$.validator.addMethod("noSpace", function (value, element) {
    return /^[a-zA-Z]+$/.test(value);
}, "No Space And No Number");

$.validator.addMethod("greaterD", function (value, element) {
    var today = new Date();
    var dob = new Date(value);
    return (today.getFullYear() - dob.getFullYear()) >= 18;
}, "Age Should be Above 18");
