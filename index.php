<?php 

  session_start();
  require_once "connection.php";
  require_once "validation.php";

  $poruka="";
  if(isset($_GET["p"]) && $_GET["p"]=="ok"){

    $poruka="You've succesfully register";
  // header("location:index.php");

  }
  
    $username="";
    if(isset($_SESSION["username"])){  // da lu je logovan korisnik

        $username=$_SESSION["username"];  // id logovanog korisnika
        
        $id=$_SESSION["id"]; // id logovanog korisnika
        $row= profilExists($id,$conn);
        $m="";
        if($row===false){
          //Logavani korisnik nema profil
          $m="Create";

        }else{
          //Logovani korisnik ima profil
          $m="Edit";
          $username=$row["first_name"] . " ". $row["last_name"];
        }

    }
   require_once "header.php";
  ?>
<!doctype html>
<html lang="en">

<head>
    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <title>Social Network</title>
  <link rel="stylesheet" href="style.css">


</head>
  <body class="vh-100 overflow-hidden">
    <div class="success">  <!-- zameniti nekim elementom iz boorstrapa-->
        <?php echo $poruka?>
    </div>
      <div class="holder">
        <div class="container main">
          <div class="row">
            <div class="col md-6  image-side">
              
            </div>
            <div class="col md-6 text-side" id="pic">
                <img src="images/reg.png" alt="#" class="img-fluid">
            <div>
                <h1 class=" py-4">Welcome <?php echo $username ?> to our Social Network</h1>
                </div> 
            </div>
          </div>
        </div>
      </div>


  </body>

</html>