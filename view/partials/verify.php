{% extends 'partials/header.html' %}

{% block body %}Verify Panel{% endblock %}
{% block content %}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<style>
    .error {
    color:red;
    }
</style>
<h1 class="text-center mb-5">You Have Been Verified SET YOUR PASSWORD </h1>
<form method="POST" id="setpass" name="setpass">
    <div class="d-flex align-items-start flex-column">
        <div class="mb-3 align-self-center">
            <input type="password" class="form-control" name="pass" id="pass" placeholder="Password Field">
        </div>
        <div class="mb-3 align-self-center">
            <input type="password" class="form-control" name="pass1" placeholder="Confirm Password Field">
        </div>
        <div class="align-self-center">
            <button type="submit" class="btn btn-primary">SET PASSWORD</button>
        </div>
    </div>
</form>
<script src="../public/javascript/verify.js"></script>
{% endblock %}
