<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary mb-5">
      <a class="navbar-brand" href="../view/welcome.php">HOME</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="editprofile.php?id=<?php echo base64_encode($_SESSION["emp_id"]); ?>">EDIT PROFILE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../partials/logout.php">LOGOUT</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="applyleave.php">APPLY LEAVE</a>
          </li>
          <?php 
            if (basename($_SERVER['PHP_SELF']) == 'welcome.php'){
              echo 
              '<li class="nav-item">
                <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal">CHANGE PASSWORD</a>
              </li>';
            }
            if ($_SESSION["user"] == "1") {
            echo 
            '<li class="nav-item">
                <a class="nav-link" href="admin.php">ADMIN</a>
            </li>
            ';
            }
            if (basename($_SERVER['PHP_SELF']) == 'admin.php'){
              echo 
              '<li class="nav-item">
                <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  ADD DEPARTMENT
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="addEmp.php">ADD EMPLOYEE</a>
              </li>
              ';
            }
            ?>
        </ul>
      </div>
    </nav>
</div>
