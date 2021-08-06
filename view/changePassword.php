{% extends 'partials/header.html' %}

{% block body %}Change Password Panel{% endblock %}
{% block head %}
    {{ include('partials/navigation.php') }}
{% endblock %}

{% block content %}
<div class="container">
    <h1 class="text-center my-5">User Change Password</h1>
    <form class="text-center px-5" id="myForm" action="department.php" autocomplete="off" method="POST">
        <div class="mb-4">
            <input name="oldpass" id="oldpass" type="password" class="form-control" placeholder="Enter The Old Password">
        </div>
    <div class="mb-4">
        <input name="pass" id="pass" type="password" class="form-control" placeholder="Enter The Password">
    </div>
    <div class="mb-1"><span id="available"></span></div>
    <div class="hide"><button id="submit" class="btn btn-primary">Change</button></div>
</form>
</div>
<script src="../public/javascript/welcome.js"></script>
{% endblock %}