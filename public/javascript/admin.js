$(document).ready(function() {

    $('#submit').prop("disabled", true);

    $('#dname').blur(function() {
        var dname = $(this).val();

        if( dname.trim().length ==  0) {
            $('#available').html('<span class="text-warning">Provide The Department Name</span>');
            $('#submit').prop("disabled", true);
        } else {
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{dep_name:dname},
                success:function(data)
            
                {   
                    if(data == 0)
                    {
                        $('#available').html('<span class="text-info">Department Not Available</span>');
                        $('#submit').prop("disabled", false);
                    }
                    else 
                    {
                        $('#available').html('<span class="text-danger">Department Available Cant Add</span>');
                        $('#submit').prop("disabled", true);
                    }
                }
            })
        }
    });

    $.validator.addMethod("greaterThan", function (value, element) {
        var today = new Date();
        return Date.parse(value) >= Date.parse(today);
    }, "Date Should be greater than Today");

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
        }); return ((startdate >= Date.parse(data[0]) && startdate <= Date.parse(data[1])));
    }, "User Didn't Apply For That Date");

    $("form[name='editleave']").validate({
        rules: {
            dob: {
                required: true,
                greaterThan: true,
                userLeave: true,
            },
            dob1: {
                required: true,
                greater: true,
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(function(){
        $(".date").datepicker({ dateFormat: 'yy-mm-dd' });
    });
})

$(document).ready(function() {
    $("#submit").click(function() {
        var dname = $("#myForm :input").serializeArray();
        $.post( $("#myForm").attr("action"), dname, function(info) {
            $('#available').html(`<span class="text-success">${info}</span>`);
        });
    });

    $("#myForm").submit(function () {
        $("#myForm")[0].reset();
        $('#submit').prop("disabled", true);
        return false;
    });

    document.querySelectorAll('.block').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Block This User")){
                window.location = `/elms/twig/twigAdmin.php?block=${id}`
            }
        })
    })
    
    document.querySelectorAll('.unblock').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To UnBlock This User")){
                window.location = `/elms/twig/twigAdmin.php?unblock=${id}`
            }
        })
    })
    
    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Approved")) {
                window.location = `/elms/twig/twigAdmin.php?approve=${id}`
            }
        })
    })
    
    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/twig/twigAdmin.php?reject=${id}`
            }
        })
    })
    
    document.querySelectorAll('.edit').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            location.href = `twigEdit.php?id=${id}`;
        })
    })
    
    document.querySelectorAll('.view').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            location.href = `twigLeaveDetail.php?leave=${id}`;
        })
    })
    
    document.querySelectorAll('.userLeave').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            tr = e.target.parentNode.parentNode;
            startdate = tr.getElementsByTagName("td")[3].innerText;
            enddate = tr.getElementsByTagName("td")[4].innerText;
            dob.value = startdate;
            userleaveid.value = e.target.id;
            dob1.value = enddate;
            $('#editLeave').modal('toggle');
        })
    })
    
    document.querySelectorAll('.cancel').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Delete This")){
                window.location = `/elms/twig/twigAdmin.php?cancel=${id}`
            }
        })
    })
})

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}
