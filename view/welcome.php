{% extends 'partials/header.html' %}

{% block body %}Home Panel{% endblock %}
{% block content %}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<style>
  .error {
    color : red;
  }
</style>
  {{ include('partials/navigation.php') }}
  <div class="text-center">
    <img style="width:150px;height:150px;border-radius: 50%;" src="public/images/{{details[6]}}">
  </div>
  <div class="container">
    <h2 class="text-center my-5" >
      {% if session.user == "1" %}
        ADMIN DETAIL
      {% else %} 
        USER DETAIL 
      {% endif %}
    </h2>
    <table class="table table-striped table-dark">
        <tr>
          <td>Name</td>
          <td>{{details[0]}} {{details[1]}}</td>
        </tr>
        <tr>
            <td>EmpID</td>
            <td>{{details[5]}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{details[2]}}</td>
        </tr>
    </table>
    <h2 class="my-5 text-center"> OTHER DETAILS </h2>
    <table class="table table-striped table-dark">
        <tr>
            <td>Birthday</td>
            <td>{{details[3]}}</td>
        </tr>
        <tr>
            <td>Number</td>
            <td>{{details[4]}}</td>
        </tr>
    </table>
  </div>
    <h2 class="text-center my-5">LEAVE HISTORY OF THE USER</h2>
    <div class="container mt-5 mb-5">
      <table class="table table-dark table-striped my-3" id="myTable">
            <thead>
              <tr>
                <th scope="col">Sno</th>
                <th scope="col">Applied On</th>
                <th scope="col">StartDate</th>
                <th scope="col">EndDate</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            {% for leave in range(0, size-1) %}    
              <tr>
                  <td>{{leave+1}}</td>
                  <td>{{userleave[leave].added_on}}</td>
                  <td>{{userleave[leave].start_date}}</td>
                  <td>{{userleave[leave].end_date}}</td>
                  {% set status = userleave[leave].status %}
                  {% if status == "0" %}
                    <td>PENDING</td>
                  {% elseif status == "1" %}
                    <td>APPROVED</td>
                  {% else %}
                    <td>REJECTED</td>
                  {% endif %}
                  {% set startdate = userleave[leave].start_date %}
                  {% set difference = diffTime(startdate) %}
                  {% if difference <= 0 %} 
                    <td><button class='btn btn-info' disabled>N/A</button></td>
                  {% elseif status == "0" %} 
                    <td><button id='{{ userleave[leave].id | base64_encode }}' class='cancel btn btn-secondary'>Cancel</button></td>
                  {% endif %}
              </tr>
            {% endfor %}
            </tbody>
      </table>
    </div>
  </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                <form class="text-center" id="myForm" action="department.php" autocomplete="off" method="POST">
                  <div class="mb-2">
                      <input name="oldpass" id="oldpass" type="password" class="form-control" placeholder="Enter The Old Password">
                  </div>
                  <div class="mb-2">
                      <input name="pass" id="pass" type="password" class="form-control" placeholder="Enter The Password">
                  </div>
                    <div class="mb-1"><span id="available"></span></div>
                    <div class="hide"><button id="submit" class="btn btn-primary">Change</button></div>
                </form>

            </div>
        </div>
    </div>
  <!-- modal end -->           
</body>
<script src="public/javascript/welcome.js"></script>
{% endblock %}