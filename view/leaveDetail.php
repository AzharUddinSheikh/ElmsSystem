{% extends 'partials/header.html' %}
{% block body %}Leave Panel{% endblock %}
{% block content %}

    {{ include('partials/navigation.php') }}
    <h1 class="text-center mt-3">Leave History Of A User</h1>
    <div class="container mt-5 mb-5">
        <table class="table table-dark table-striped my-3" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Added-On</th>
                    <th scope="col">StartDate</th>
                    <th scope="col">EndDate</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            {% if size > 0 %}
                {% for leave in range(0, size-1) %}                        
                    <tr>
                        <td>{{leave}}</td>
                        <td>{{userleaves[leave].reason}}</td>
                        <td>{{userleaves[leave].added_on}}</td>
                        <td>{{userleaves[leave].start_date}}</td>
                        <td>{{userleaves[leave].end_date}}</td>
                        {% set status = userleaves[leave].status %}
                        {% if status == "1" %} 
                            <td>APPROVED</td>
                        {% elseif status == "2" %} 
                            <td>REJECTED</td>
                        {% else %} 
                            <td>PENDING</td>
                        {% endif %}
                        {% set start_date = diffTime(userleaves[leave].start_date) %}
                        {% if start_date <= 0 %}
                            <td><button class="btn btn-info" disabled>N/A</button></td>
                        {% elseif status == "1" %} 
                            <td><button id='{{ userleaves[leave].id | base64_encode }}' name='{{ userleaves[leave].user_id | base64_encode }}' class='reject btn btn-danger'>Reject</button></td>
                        {% elseif status == "2" %}
                            <td><button id='{{ userleaves[leave].id | base64_encode }}' name='{{ userleaves[leave].user_id | base64_encode }}' class='approve btn btn-success'>Approve</button></td>
                        {% else %}
                            <td></td>
                        {% endif %}
                    </tr>
                {% endfor %}
            {% endif %}
            </tbody>
        </table>
    </div>
    <script src="../public/javascript/leaveDetail.js"></script>
{% endblock %}