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

    document.querySelectorAll('.delete').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id = e.target.id.substr(0,);
            if(confirm("Are You Sure To Delete")) {
                window.location = `/elms/twig/twigDepartment.php?delete=${id}`
            }
        })
    })
    
    document.querySelectorAll('.edit').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            tr = e.target.parentNode.parentNode;
            dep_name = tr.getElementsByTagName("td")[1].innerText;
            departEdit.value = dep_name;
            departid.value = e.target.id;
            $('#exampleModal').modal('toggle');
        })
    })
})

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href )
}