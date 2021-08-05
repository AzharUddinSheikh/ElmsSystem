<!-- navigation -->
<div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigWelcome.php">Home</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigEdit.php?id={{ session.emp_id | base64_encode }}">Edit Profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigChangePassword.php">Change Password</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigApplyLeave.php">Apply Leave</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="twigUserLeave.php">View Leave History</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../partials/logout.php">Logout</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle">Menu</button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    </div>
                </nav>
                <!-- Page content-->
            </div>
        </div>
<!-- navigation end -->
