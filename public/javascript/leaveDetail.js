function enc(str) {
    var encoded = "";
    for (i=0; i<str.length;i++) {
        var a = str.charCodeAt(i);
        var b = a ^ 123;    // bitwise XOR with any number, e.g. 123
        encoded = encoded+String.fromCharCode(b);
    }
    return encoded;
}

$(document).ready(function() {

    document.querySelectorAll('.approve').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id3 = e.target.id.substr(0,);
            id4 = e.target.name.substr(0,);
            var id = enc(id3);
            var id2 = enc(id4);
            if(confirm("Are You Sure To Approved")) {
                window.location = `/elms/view/leaveDetail.php?approve=${id}&leave=${id2}`
            }
        })
    })
    
    document.querySelectorAll('.reject').forEach((element)=>{
        element.addEventListener("click", (e)=>{
            id3 = e.target.id.substr(0,);
            id4 = e.target.name.substr(0,);
            var id = enc(id3);
            var id2 = enc(id4);
            console.log(id,id2);
            if(confirm("Are You Sure To Reject")) {
                window.location = `/elms/view/leaveDetail.php?reject=${id}&leave=${id2}`
            }
        })
    })
})