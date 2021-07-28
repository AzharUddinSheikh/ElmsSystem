<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary mb-5">
      <a class="navbar-brand" href="twigWelcome.php">HOME</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="twigEdit.php?id={{ session.emp_id | base64_encode }}">EDIT PROFILE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../partials/logout.php">LOGOUT</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="twigApplyLeave.php">APPLY LEAVE</a>
          </li>
          {% set currenturl = getUrl() %}
          {% if currenturl == "twigWelcome.php" %}
              <li class="nav-item">
                <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal">CHANGE PASSWORD</a>
              </li>
          {% endif %}
          {% if session.user == "1" %}
              <li class="nav-item">
                  <a class="nav-link" href="twigAdmin.php">ADMIN</a>
              </li>
          {% endif %}
          {% if currenturl == "twigAdmin.php" %}
              <li class="nav-item">
                  <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    ADD DEPARTMENT
                  </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="twigAddEmp.php">ADD EMPLOYEE</a>
              </li>
          {% endif %}
        </ul>
      </div>
    </nav>
</div>
