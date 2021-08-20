$(document).ready(function() {
    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id1 = e.target.name.substr(0,);
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{approve:id1, ids:id},
                success:function(data){
                    if (data > 23) {
                        alert("User Will Exceed Leave For This Year");
                    } 
                    if(confirm("Are You Sure To Approved")) {
                        window.location = `/elms/twig/admin.php?approve=${id}`
                    }
                }
            })
        })
    })

    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            rejectid.value = id;
            $("#rejectUserLeave").modal("toggle");
        })
    })

    document.querySelectorAll('.userdetails').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            id1 = e.target.name.substr(0,);
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{approve:id1, ids:id},
                success:function(data){
                    if (data > 23) {
                        alert("User Will Exceed Leave For This Year");
                    } 
                    tr = e.target.parentNode.parentNode;
                    enddate = tr.getElementsByTagName("td")[1].innerText.slice(0,10);
                    startdate = tr.getElementsByTagName("td")[1].innerText.slice(11,21);
                    dob.value = startdate;
                    userleaveid.value = e.target.id;
                    dob1.value = enddate;
                    $("#editUserLeave").modal("toggle");
                }
            })
        })
    })

    $(function(){
        $(".date").datepicker({ dateFormat: 'yy-mm-dd' });
    });

    $.validator.addMethod("greater", function (value, element) {
        var startdate = $('#dob').val();
        return Date.parse(value) >= Date.parse(startdate);
    }, "End Date Should Be Greater than Start Date");

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

    $("form[name='editleave']").validate({
        rules: {
            dob: {
                required: true,
                userLeave: true,
            },
            dob1: {
                required: true,
                greater: true,
                userLeave1: true,
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#myForm").validate({
        rules: {
            reason: {
                required: true,
                minlength: 5,
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href )
    }

})