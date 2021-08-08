{% extends 'partials/header.html' %}

{% block body %}Admin Panel{% endblock %}

{% block head %}
    {{ include('partials/navigation.php') }}
{% endblock %}

{% block content %}
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">ADMIN DASHBOARD</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="twigAdmin.php" class="btn btn-primary">VIEW</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">EMPLOYEE MANAGEMENT</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="twigEmpManage.php" class="btn btn-primary">VIEW</a>
                    </div>
                </div>
            </li>
            <li class="nav-item ">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">DEPARTMENT MANAGEMENT</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the.</p>
                        <a href="twigDepartment.php" class="btn btn-primary">VIEW</a>
                    </div>
                </div>
            </li>
            <li class="nav-item ">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">USER LEAVE MANAGEMENT</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the </p>
                        <a href="twigUserLeaveDetails.php" class="btn btn-primary">VIEW</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
{% endblock %}