<?php
//ne dozvoljavamo pristup ovoj straniici logovanim korisnicima
    session_start();
    if(isset($_SESSION["id"])){
        header("location: index.php");
    }
require_once "connection.php";
require_once "validation.php";

    $usernameError="";
    $passwordError="";
    $retypeError="";
    $username="";
    $password="";
    $retype="";

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        // forma je poslatam treba pokupiti vrednost iz polja

        $username=$conn->real_escape_string($_POST["username"]);
        $password=$conn->real_escape_string($_POST["password"]);
        $retype=$conn->real_escape_string($_POST["retype"]);

       //1)izvrsiti validaciju za $username
       $usernameError= usernameValidation($username, $conn);
       
       //2)izvrsiti validaciju za $password

       $passwordError= passwordValidation($password);

       //3)izvrsiti validaciju za $retype
       $retypeError= passwordValidation($retype);
      
       if($password!== $retype){
        $retypeError="You must enter two same passwords";
       }

       //4.1) Ako su sva polja validna, onda treba dodati novog korisnika
       //(treba izvrsiti INSERT upit nad tabelom users)
       if($usernameError=="" && $passwordError=="" && $retypeError==""){
            // lozinka treba prvo da se sifruje
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $q="INSERT INTO `users`(`username`,`password`)
            VALUES 
            ('$username','$hash');";
            
            if($conn->query($q)){
                //kreirali smo novog korisnika, vodi ga na stranicu za logovanje
                header("location: index.php?p=ok");
            }else{
                header("location: error.php?" .http_build_query(['m'=> 'Greska kod kreiranja usera']));
            }
       }


       //4.2) Ako postoji neko polje koje nije validno, ne raditi upit 
       // nego vratiti korisnika na stricu i prikazati poruke

     

    }

    
?>
 
<!doctype html>
<html lang="en">

<head>
    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <title>Register new user</title>
  <link rel="stylesheet" href="style.css">


</head>

<body>

<div class="holder">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 image-side">
            
            </div>
            <div class="col md-6 " id="reg">
                <div class="input-box">
                    <header>Register to our site</header>
                
                    <form action ="register.php" method="POST">
                        <div class="input-field">
                            <label for="username">Username</label>
                            <input type ="text" name="username" id ="username" value="<?php echo $username; ?>">
                            <span class="error">* <?php echo $usernameError;?></span>
                        </div>

                        <div class="input-field">
                            <label for="password">Password</label>
                            <input type ="password" name="password" id ="password" value="">
                            <span class="error">* <?php echo $passwordError;?></span>
                        </div>

                        <div class="input-field">
                            <label for="retype">Retype password</label>
                            <input type ="password" name="retype" id ="retype" value="">
                            <span class="error">* <?php echo $retypeError;?></span>
                        </div>

                        <div class="input-field" >
                            <input class="submit" type="submit" value="Register me">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    
  

</body>

</html>