{% extends 'partials/header.html' %}
{% block content %}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js" type="text/javascript"></script>
<style>
  .error {
    color:red;
  }
  .valid {
    color:green;
  }
</style>
</head>
<body class="bg-secondary">
    {{ include('partials/navigation.php') }}
  
  <div class="w-50 mx-auto">
    {% if session.update %}
      <div class="container">{{session.update}}</div>
    {% endif %}
    <h2 class="text-center">EDIT PROFILE</h2>
    <form action="" method="POST" name='edit' id='edit' enctype="multipart/form-data">
    <div class="mb-3">
      <label for="fname" class="form-label">First Name</label>
      <input type="text" class="form-control" name="fname" id="fname" value="{{ userdetail[0] }}">
    </div>
        <div class="mb-3">
          <label for="lname" class="form-label">Last Name</label>
          <input type="text" class="form-control" name="lname" id="lname" value="{{ userdetail[1] }}">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input id="uEmail" type="email" class="form-control" name="email" id="email" value="{{ userdetail[2] }}">
          <span id="available"></span>
        </div>
        <div class="mb-3">
            <div class="mb-3">
              <label for="number" class="form-label">Phone Number</label>
              <input type="number" class="form-control" name="number" id="number" value="{{ userdetail[4] }}">
        </div>
        <div>
            <label for="dob" class="form-label">Date Of Birth</label>
            <input type="text" class="form-control" name="dob" id="dob" value="{{ userdetail[3] }}">
            <span id="dobID"></span>
        </div>
        <div class="custom-file my-5">
            <input type="file" class="custom-file-input" id="image" name="image">
            <label class="custom-file-label" for="photo">Profile Photo</label>
        </div>
        <div class="col-md-12 my-3 text-center">
          <span class="submit px-3">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          </span>
        </div>
      </form>
    </div>
  </body>
</html>
<script src="../public/javascript/edit.js" type="text/javascript"></script>

{% endblock %}