{% extends 'partials/header.html' %}

{% block body %}Admin Panel{% endblock %}

{% block content %}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<body>
    {{ include('partials/navigation.php') }}

    <span id="result"></span>
    
    <!-- table leave  -->
    <h1 class="text-center">EMPLOYEE LEAVE PROPOSAL REJECT OR APPROVED</h1>
    <div class="container mt-5 mb-5">
        <table class="table table-dark table-striped my-3" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Emp-ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">StartDate</th>
                    <th scope="col">EndDate</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            {% if count > 0 %}
                {% for leave in range(0, count-1) %}                        
                    <tr>
                        <td>{{leave+1}}.</td>
                        <td>{{leaves[leave].emp_id}}</td>
                        <td>{{leaves[leave].first_name | title}} {{leaves[leave].last_name}}</td>
                        <td>{{leaves[leave].start_date}}</td>
                        <td>{{leaves[leave].end_date}}</td>
                        {% set start_date = diffTime(leaves[leave].start_date) %}
                        {% if start_date <= 0 %} 
                            <td><button id='{{ leaves[leave].id | base64_encode }}' class="cancel btn btn-secondary">Cancel</button></td>
                        {% else %} 
                            <td><button id='{{ leaves[leave].id | base64_encode }}' class="approve btn btn-success">Approve</button>  <button id='{{ leaves[leave].id | base64_encode }}' class="reject btn btn-danger">Reject</button></td>
                        {% endif %}
                    </tr>
                {% endfor %}
            {% endif %}
            </tbody>
        </table>
    </div>

    <div class="container mt-5">
        <h1 class="text-center">EMPLOYEE DETAIL CAN BE EDITED OR BLOCKED </h1>
    </div>
    <div class="container mt-5 mb-5">
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
                    {% else %}
                        {% if status == "1" %}
                            <button id='{{ employees[employee].id | base64_encode }}' class='block btn btn-danger'>BLOCK</button>
                        {% elseif status == "2" %}
                            <button id='{{ employees[employee].id | base64_encode }}' class='unblock btn btn-warning'>UNBLOCK</button>
                        {% endif %}
                    {% endif %}
                    <button id='{{ employees[employee].emp_id | base64_encode }}' type='button' class='edit btn btn-warning'>EDIT</button>  <button id='{{ employees[employee].id | base64_encode }}' type='button' class='view btn btn-secondary'>View</button>
                    </td>
                </tr>
            {% endfor %}
        </tbody>
        </table>
        
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal">Department Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                <form id="myForm" action="department.php" autocomplete="off" method="POST">
                    <div class="mb-2">
                        <input name="dname" id="dname" type="text" class="form-control" placeholder="Enter The Department Name">
                    </div>
                    <div class="mb-1"><span id="available"></span></div>
                    <div class="hide"><button id="submit" class="btn btn-primary">ADD</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script src="../public/javascript/admin.js"></script>
{% endblock %}