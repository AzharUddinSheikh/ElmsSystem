{% extends 'partials/header.html' %}

{% block body %}Home Panel{% endblock %}
{% block content %}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
  {{ include('partials/navigation.php') }}
  <div class="container">
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
                  {% else %}
                    <td></td>
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
<script src="../public/javascript/welcome.js"></script>
{% endblock %}