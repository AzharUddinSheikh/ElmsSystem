<!-- navigation -->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="list-group list-group-flush">
                    {% if session.user == "0" %}  
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigWelcome.php">DASHBOARD</a>
                    {% elseif session.user == "1" %}
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ADMIN</a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#!">ADMIN DASHBOARD</a>
                        <a class="dropdown-item" href="#!">DEPARTMENT MANAGEMENT</a>
                        <a class="dropdown-item" href="#!">EMPLOYEE MANAGEMENT</a>
                        <a class="dropdown-item" href="#!">USER LEAVE MANAGEMENT</a>
                    </div>
                    {% endif %}
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigEdit.php?id={{ session.emp_id | base64_encode }}">EDIT PROFILE</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigApplyLeave.php">APPLY LEAVE</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigUserLeave.php">VIEW LEAVE HISTORY</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigChangePassword.php">CHANGE PASSWORD</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../partials/logout.php">LOGOUT</a>
                </div>
            </div>
<!-- navigation end -->
