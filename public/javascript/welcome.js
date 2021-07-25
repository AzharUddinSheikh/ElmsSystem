function enc(str) {
    var encoded = "";
    for (i=0; i<str.length;i++) {
        var a = str.charCodeAt(i);
        var b = a ^ 123;    // bitwise XOR with any number, e.g. 123
        encoded = encoded+String.fromCharCode(b);
    }
    return encoded;
}

$("#myForm").validate({
    rules:{
        oldpass:{
            required: true
        },
        pass:{
            required: true,
            minlength: 5,
        }
    },
    submitHandler : function (form) {
        var old = $("#oldpass").val();
        var pass = $("#pass").val();
        $.ajax({
            url:'department.php',
            method:"POST",
            data:{oldpass:old, newpass:pass},
            success:function(data)
            {   
                $('#available').html('<span class="text-warning">'+data+'</span>');
            }
        })
    }
})

$("#myForm").submit(function () {
        $("#myForm")[0].reset();
        return false;

});

document.querySelectorAll('.cancel').forEach((element)=>{
        element.addEventListener("click",(e)=>{
            id = e.target.id.substr(0,);
            var encoded = enc(id);
            if(confirm("Are You Sure To Delete This Request")){
                window.location = `/elms/view/welcome.php?cancel=${encoded}`
            }
        })
    })
