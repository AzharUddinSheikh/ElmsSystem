{% extends 'partials/header.html' %}

{% block body %}Admin Panel{% endblock %}

{% block head %}
    {{ include('partials/navigation.php') }}
{% endblock %}

{% block content %}
<div class="container mt-3 text-center">
    {% if session.message %}
        <div class="alert alert-primary" role="alert">
            {{session.message}}        
        </div>
    {% endif %}
</div>
<div class="container mt-5">
    <h1 class="text-center">EMPLOYEE DETAIL CAN BE EDITED OR BLOCKED/UNBLOCKED AND DELETE</h1>
</div>
<div class="mt-5 mb-5">
    <a href="twigAddEmp.php" class="btn btn-primary mb-3" style="float:right;">Add New Employee</a>
    <table class="table table-dark table-striped my-3" id="myTable">
        <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Emp-ID</th>
                    <th scope="col">First-Name</th>
                    <th scope="col">Last-Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Department-Name</th>
                    <th scope="col">Action</th>
                </tr>
        </thead>
        <tbody>
            {% if size > 0 %}
                {% for employee in range(0, size-1) %}                        
                    <tr>
                        <td>{{employee+1}}</td>
                        <td>{{employees[employee].emp_id}}</td>
                        <td>{{employees[employee].first_name}}</td>
                        <td>{{employees[employee].last_name}}</td> 
                        <td>{{employees[employee].email}}</td> 
                        <td>{{employees[employee].name}}</td>
                        {% set empid = employees[employee].emp_id %}
                        {% set status = employees[employee].status %}
                        <td>
                        {% if empid == session.emp_id %}
                            <button class='block btn btn-danger' disabled>BLOCK</button>
                            <button type='button' class='btn btn-secondary' disabled>DELETE USER</button>
                        {% else %}
                            {% if status == "1" %}
                                <button id='{{ employees[employee].id | base64_encode }}' class='block btn btn-danger'>BLOCK</button>
                            {% elseif status == "2" %}
                                <button id='{{ employees[employee].id | base64_encode }}' class='unblock btn btn-warning'>UNBLOCK</button>
                            {% endif %}
                            <button id='{{ employees[employee].emp_id | base64_encode }}' type='button' class='delete btn btn-secondary'>DELETE USER</button>
                        {% endif %}
                        <button id='{{ employees[employee].emp_id | base64_encode }}' type='button' class='edit btn btn-warning'>EDIT</button>  
                        </td>
                    </tr>
                {% endfor %}
            {% endif %}
        </tbody>
    </table>
</div>
    <script src="../public/javascript/empManage.js"></script>
{% endblock %}