$(document).ready(function() {
    $('#pass').blur(function() {
        var pass = $(this).val();
        if(pass == '' || pass.length <= 4) {
          $('#available').html('<span class="text-danger">Should Not Be Empty and Atleast 5 character</span>');
          $('.hide').hide();
        } else { 
          $('#available').html('<span class="text-success">Password Is Valid</span>');
          $('.hide').show();
          }
    });
    
    $("#submit").click(function() {
          var pass = $("#myForm :input").serializeArray();
          $.post( $("#myForm").attr("action"), pass, function(info) {
              alert(info);
          });
      });
  
  $("#myForm").submit(function () {
          $("#myForm")[0].reset();
          return false;

  });

  document.querySelectorAll('.cancel').forEach((element)=>{
          element.addEventListener("click",(e)=>{
              id = e.target.id.substr(0,);
              if(confirm("Are You Sure To Delete This Request")){
                  window.location = `/elms/view/welcome.php?cancel=${id}`
              }
          })
      })
})