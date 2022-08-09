$(document).ready(function() {
    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            id1 = e.target.name.substr(0,);
            filename = window.location.href.replace(/^.*[\\\/]/, '');
            $.ajax({
                url:'../view/department.php',
                method:"POST",
                data:{approve:id1, ids:id},
                success:function(data){
                    if (data > 23) {
                        alert("User Will Exceed Leave For This Year");
                    } 
                    if(confirm("Are You Sure To Approved")) {
                        window.location = '/ElmsSystem-sahil/twig/'+filename+`?approve=${id}`
                    }
                }
            })
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
                    startdate = tr.getElementsByTagName("td")[1].innerText.slice(0,10);
                    enddate = tr.getElementsByTagName("td")[1].innerText.slice(11,21);
                    dob.value = startdate;
                    userleaveid.value = e.target.id;
                    dob1.value = enddate;
                    $("#editUserLeave").modal("toggle");
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
})