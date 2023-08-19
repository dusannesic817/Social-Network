<?php

  require_once "connection.php";
  //session_start();

?>

<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Members of Social Newtwork</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="https://itbootcamp.rs/">IT Bootcamp</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNav">
      <ul class="navbar-nav text-light ">
        <?php if(!isset($_SESSION["id"])) {?>
        <li class="nav-item  ">
          <a class="nav-link text-light " aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="login.php">Log in</a>
        </li>
        <?php }else{?>
          <li class="nav-item">
          <a class="nav-link text-light " aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="profile.php">Profiles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="followers.php">Members</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="reset_password.php">Change Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="logout.php">Log Out</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
    
    </body>

</html>