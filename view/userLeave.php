{% extends 'partials/header.html' %}

{% block body %}Home Panel{% endblock %}
{% block head %}
  {{ include('partials/navigation.php') }}
{% endblock %}

{% block content %}
  <div class="container">
    {% if session.message %} 
      <div class="valid alert alert-warning" role="alert">{{session.message}}</div>
    {% endif %}
    <h2 class="text-center my-5">LEAVE HISTORY OF THE USER</h2>
    <div class="container mt-5 mb-5">
      <table class="table table-dark table-striped my-3" id="myTable">
          <thead>
            <tr>
              <th scope="col">Sno</th>
              <th scope="col">Reason</th>
              <th scope="col">Applied On</th>
              <th scope="col">StartDate</th>
              <th scope="col">EndDate</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          {% if size > 0 %}
            {% for leave in range(0, size-1) %}    
              <tr>
                  <td>{{leave+1}}</td>
                  <td>{{userleave[leave].reason}}</td>
                  <td>{{userleave[leave].added_on}}</td>
                  <td>{{userleave[leave].start_date}}</td>
                  <td>{{userleave[leave].end_date}}</td>
                  {% set userid = userleave[leave].user_id %}
                  {% set difference = diffTime(userleave[leave].start_date) %}
                  <td>
                  {% if (session.user == "1" or session.user == "0") and session.id == userid %}
                      {% if difference > 0 %} 
                        <button id='{{ userleave[leave].id | base64_encode }}' class='cancel btn btn-secondary btn-sm'>CANCEL</button>
                      {% else %}
                        <button class='btn btn-info btn-sm' disabled>N/A</button>
                      {% endif %}
                  {% endif %}
                  {% if session.user == "1" %}
                      <button id='{{ userleave[leave].id | base64_encode }}' class="userdetails btn btn-info btn-sm">CHECK STATUS</button>
                  {% endif %}
                  <button id='{{ userleave[leave].id | base64_encode }}' class="view btn btn-info mx-1 btn-sm" data-toggle="modal" data-target="#exampleModal">VIEW</button>
                  </td>
              </tr>
            {% endfor %}
          {% endif %}
          </tbody>
      </table>
    </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModal">User Leave Detail</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              </div>
          </div>
        </div>
      </div>

  </div>
</body>
<script src="../public/javascript/welcome.js"></script>
{% endblock %}