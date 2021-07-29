{% extends 'partials/header.html' %}

{% block body %}Add Emp Panel{% endblock %}
{% block content %}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<body class="bg-secondary">
  {{ include('partials/navigation.php') }}
    <div class="w-50 mx-auto">
      {% if session.added %} 
        <div class="container valid">{{session.added}}</div>
      {% endif %}
      <h2>Fill Out The Detail With Valid Email Address</h2>
      <form action="" method="POST" name='addemp' id='addemp'>
        <div class="mb-3">
          <label for="fname" class="form-label">First Name</label>
          <input type="text" class="form-control" name="fname" id="fname">
        </div>
        <div class="mb-3">
          <label for="lname" class="form-label">Last Name</label>
          <input type="text" class="form-control" name="lname" id="lname">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input id="uEmail" type="text" class="form-control" name="email" id="email">
          <span id="available"></span>
        </div>
        <div class="mb-3">
          <label for="dob" class="form-label">Date Of Birth</label>
          <input type="text" class="form-control" name="dob" id="dob">
          <span id="dobID"></span>
        </div>
        <div class="mb-3">
          <label for="number" class="form-label">Phone Number</label>
          <input type="number" class="form-control" name="number" id="number">
        </div>
        <div class="mb-3">
          <label for="empid" class="form-label">Emp Id</label>
          <input type="number" class="form-control" name="empid" id="empid">
        </div>
        <div class="mb-4 mt-4 text-center ">
        <select class="col px-md-4 py-md-1" name="dname" id="dname">
            <option value="" disabled selected>Select Department</option>
            {% for department in range(0, size-1) %} 
              <option value='{{details[department].id}}'>{{details[department].name}}</option>
            {% endfor %}
        </select>
          <select class="col px-md-4 py-md-1" name="utype" id="utype">
            <option value="" disabled selected>Select User Type</option>
            <option value=0>User</option>
            <option value=1>Admin</option>
          </select>
        </div>
        
        <div class="col-md-12 text-center">
          <span class="submit">
            <button id="submit" type="submit" class="btn btn-primary">Submit</button>
          </span>
          <button type="reset" class="btn btn-primary">Clear</button>
        </div>
      </form>
    </div>
<script src="../public/javascript/addEmp.js"></script>
{% endblock %}