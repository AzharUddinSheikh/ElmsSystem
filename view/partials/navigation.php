<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary mb-5">
		<div class="btn-group dropend">
			<a class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
				<span class="navbar-toggler-icon"></span>
			</a>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
				<li><a class="nav-link" href="twigUserLeave.php">USER LEAVE</a></li>
				<li><a class="nav-link" href="twigEdit.php?id={{ session.emp_id | base64_encode }}">EDIT PROFILE</a></li>
				<li><a class="nav-link" href="twigApplyLeave.php">APPLY LEAVE</a></li>
				{% set currenturl = getUrl() %}
				{% if currenturl == "twigWelcome.php" %}
					<li>
					  <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal">CHANGE PASSWORD</a>
					</li>
				{% endif %}
				<li><a class="nav-link" href="../partials/logout.php">LOGOUT</a></li>
			</ul>
		</div>
	{% if session.user == "1" %}
      <div class="btn-group dropend">
		<a class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
			<span class="fa fa-fw fa-user"></span>
		</a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
              <li><a class="nav-link" href="twigAdmin.php">ADMIN</a></li>
          {% endif %}
          {% if currenturl == "twigAdmin.php" %}
              <li><a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD DEPARTMENT</a></li>
              <li><a class="nav-link" href="twigAddEmp.php">ADD EMPLOYEE</a></li>
          {% endif %}
        </ul>
      </div>
    </nav>
</div>
