<?php
    //Cim treba nekako da koristimo sesiju, mora ova f-ja da se pozove

    session_start();   // ova f-ja treba na pocetku (kao prva) da se pozove

    if(!isset($_SESSION["bad_logins"])){
        $_SESSION["bad_logins"]=0;
    }                  
    if(isset($_SESSION["id"])){
        header("location: index.php");
    }                       
    require_once "connection.php";

    $usernameError="*";
    $passwordError="*";
    $username="";


    if($_SERVER["REQUEST_METHOD"] =="POST"){
        //Korisnik je poslao username i password i pokusava logovanje
        $username=$conn->real_escape_string($_POST["username"]);
        $password=$conn->real_escape_string($_POST["password"]);

        //Vrsimo validacije

        if(empty($username)){
            $usernameError="Username cannot be blank!";
        }

        if(empty($password)){
            $passwordError="Password cannot be blank";
        }

        if($usernameError == "*" && $passwordError=="*"){
            //Ovde mozemo da pokusamo da logujemo korisnika ako se svi kredencijali za logovanje podudaraju

            $q="SELECT * FROM `users` WHERE `username`= '$username'";
        
            $result=$conn->query($q);
            if($result->num_rows==0){
                $usernameError="This username doesn't exits!";

            }else{
                //Postoji takav korinik proveriti lozinke
                $row=$result->fetch_assoc();
                $dbPassword =$row['password']; //hesirana vrednost iz baze
                if(!password_verify($password,$dbPassword)){ // proveravamo poklapanje unesenog pass i pass iz baze
                    //Poklopili su se username ali lozinka nije dobra
                        
                    $passwordError = "Wrong password, try again!";
                    //$passwordError="Wrong password, try again!";
                }else{
                   
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    header("Location: index.php");
                    
                }

            }

           

        }

        //Ako je sve u uredu,loguj korisnika

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

  <title>Log in</title>
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
                    <header>Please Log in</header>
                
                    <form action ="#" method="POST">
                        <div class="input-field">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" value="<?php echo $username;?>">
                            <span class="error"><?php echo $usernameError; ?></span>
                        </div>

                        <div class="input-field">
                            <label for="password">Password</label>
                            <input type="password" name="password" id ="password" value="">
                            <span class="error"><?php echo $passwordError;?></span>
                        </div>

                        <div class="input-field" >
                            <input class="submit" type="submit" value="Log in">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>

