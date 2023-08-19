<?php
require_once "connection.php";
session_start();

if(!isset($_SESSION["id"])){
    header("location: index.php");
}





if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])){  // da li sam dosao na stranicu get metodom i da li ima prosledjen parametar M

    $id=$conn->real_escape_string($_GET["id"]);

    $q= "SELECT *
    FROM `profiles`
    LEFT JOIN `users` ON `users`.`id`= `profiles`.`id_user`
    WHERE `profiles`.`id`= '$id' ";

    $result=$conn->query($q);

    

    if($result->num_rows> 0){
      

    while($row=$result->fetch_assoc()){

    
    $firsName= $row["first_name"];
    $lastName= $row["last_name"];
    $username= $row["username"];
    $birth= $row["dob"];
    $gender= $row["gender"];

}
    }

    $q1="SELECT COUNT(*) as `following_number`
    FROM `followers`
    WHERE `id_sender` = $id;";

    $result1=$conn->query($q1);

    if($result1->num_rows>0){

        $row1= $result1->fetch_assoc(); 

         $following=$row1["following_number"];
        


    }

    $q2="SELECT COUNT(*) as `followers_number`
    FROM `followers`
    WHERE `id_receiver` = $id;";

    $result2=$conn->query($q2);

    if($result2->num_rows>0){

        $row2= $result2->fetch_assoc(); 
            $followers=$row2["followers_number"];
        


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
    <title>Profiles</title>
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
                    <table  class="tabela table table-hover">
                        <tr>
                            <td>First Name</td>
                            <td><?php echo $firsName?></td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><?php echo $lastName?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><?php echo $username?></td>
                        </tr>
                        <tr>
                            <td>Date of birth></td>
                            <td><?php echo $birth?></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td><?php echo $gender?></td>
                        </tr>

                        <tr>
                            <td>Following</td>
                            <td>
                            <a href="following_name.php?id=<?php echo $id; ?>"><?php echo $following; ?></a>
                        
                            </td>
                        </tr>
                        <tr>
                            <td>Followers</td>
                            <td>
                            <a href="followers_name.php?id=<?php echo $id; ?>"><?php echo $followers; ?></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
}
    ?>

</body>
</html>