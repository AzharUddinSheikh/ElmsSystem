{% extends 'partials/header.html' %}
{% block head %}
    {{ include('partials/navigation.php') }}
{% endblock %}

{% block content %}
<h1 class="mt-4 mb5 text-center">
        {% if session.user == "1" %}
          ADMIN DETAIL EDIT
        {% else %} 
          USER DETAIL EDIT
        {% endif %}
      </h1>
{% if session.update %}
      <div class="alert alert-info" role="alert">{{session.update}}</div>
{% endif %}

    <form action="" method="POST" name='edit' id='edit' enctype="multipart/form-data">
<div class="row mt2">
  <div class="col-md-3">
    <div style="height: 350px;background: #fff;border:1px solid #ccc;border-radius: 4px;overflow: hidden;box-shadow: 0px 0px 5px #ccc;">
      <div class="text-center"><label class="custom-file-label" for="photo">Profile Photo</label></div>
      
      <div class="py-5">
        <div class="text-center">
          <img style="width:100px;height:100px;border-radius: 50%;" src="../public/images/{{userdetail[6]}}">
        </div>
      </div>
      <div class="custom-file my-3 mt5 px-3  text-center">
          <input type="file" class="custom-file-input" id="image" name="image">
      </div>
    </div>
  </div>
  <div class="col-md-7">
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
        
        <div class="col-md-12 my-3 text-center">
          <span class="submit px-3">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          </span>
        </div>
      
  </div>
</div>
</form>


 
  </div>
<script src="../public/javascript/edit.js" type="text/javascript"></script>

{% endblock %}