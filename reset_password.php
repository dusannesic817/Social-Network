<?php

require_once "connection.php";
require_once "validation.php";
session_start();

if(!isset($_SESSION["id"])){

    header("Location: index.php");
   
}

$sucMessage = $errMessage = "";
$passwordNewError = $passwordOldError = $retypeError = "";

$id=$_SESSION["id"];
$qPass = "SELECT `password` FROM `users` WHERE `id` = $id;";

$result = $conn->query($qPass);

$row= $result->fetch_assoc(); 
$password = $row['password'];


if($_SERVER["REQUEST_METHOD"] == "POST"){

  $passwordNew = $conn->real_escape_string($_POST['passwordNew']);
  $retype = $conn->real_escape_string($_POST['retype']);
  $passwordOld = $conn->real_escape_string($_POST['passwordOld']);

  $passwordNewError = passwordValidation($passwordNew);
  $passwordOldError = passwordValidation($passwordOld);
  $retypeError = passwordValidation($retype);

  if($passwordNewError == "" && $passwordOldError == "" && $retypeError ==""){

    $q = "";

    if (password_verify($passwordOld, $password)){

      if($passwordNew === $retype){

        $passwordNew = password_hash($passwordNew, PASSWORD_DEFAULT);
        $q = "UPDATE `users`
        SET `password` = '$passwordNew' 
        WHERE `id` = $id;";

        if($conn->query($q)){

          $sucMessage = "You have changed your profile";

        }else{
         
          $errMessage = "Error chaning password: " . $conn->error;
        }
      }else{

        $retypeError = "You must enter two same passwords";

      }
    }else
    {
      $passwordOldError = "Invalid password";
    }

    
  }
}
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <title>Reset Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="success">
      <?php echo $sucMessage ?>
    </div>
    <div class="error">
      <?php echo $errMessage; ?>
    </div>

    <div class="holder">
      <div class="container main">
          <div class="row">
              <div class="col-md-6 image-side">
              
              </div>
              <div class="col md-6 " id="reg">
                  <div class="input-box">
                      <header>Change Password</header>
                      <form action ="#" method="POST">
                          <div class="input-field">
                              <label for="passwordOld">Your old password</label>
                              <input type="password" name="passwordOld" id="passwordOld" value="">
                              <span class="error"><?php echo $passwordOldError; ?></span>
                          </div>
                          <div class="input-field">
                              <label for="passwordNew">Password</label>
                              <input type="password" name="passwordNew" id ="passwordNew" value="">
                              <span class="error"><?php echo $passwordNewError;?></span>
                          </div>
                          <div class="input-field">
                              <label for="retype">Retype</label>
                              <input type="password" name="retype" id ="retype" value="">
                              <span class="error">*<?php echo $retypeError;?></span>
                          </div>
                          <div class="input-field">

                          <div class="input-field" >
                              <input class="submit" type="submit" value="Change Password">
                          </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


?>

<!-- 


-->