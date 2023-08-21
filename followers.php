<?php
    session_start();
    if(empty($_SESSION["id"])){
        header("location: index.php");
    }

    $id= $_SESSION["id"];
    require_once "connection.php";
    require_once "header.php";


    if(isset($_GET['friend_id'])){
        //Zahtev za pracenje drugog korinsnika

        $friendId=$conn->real_escape_string($_GET["friend_id"]);

        $q="SELECT * FROM `followers`
            WHERE `id_sender`=$id
            AND `id_receiver`=$friendId";
    
        $result=$conn->query($q);
        if($result->num_rows==0){

            $upit = "INSERT INTO `followers`(`id_sender`, `id_receiver`)
            VALUE($id,$friendId)
            
            ";
    
            $result1=$conn->query($upit);
    
        }
    }

    if(isset($_GET['unfriend_id'])){

        // Zahtev da se drugi korisnik da se korisnik otprati
        $friendId=$conn->real_escape_string($_GET["unfriend_id"]);

        $q="DELETE FROM `followers`
            WHERE `id_sender`=$id
            AND `id_receiver`=$friendId
                ";

        $conn->query($q);
    }

    if(isset($_GET["id"])){

        $idd=$conn->real_escape_string($_GET["id"]);
            
        $q="SELECT *
         FROM `profiles`
         LEFT JOIN `users` ON `users`.`id`= `profiles`.`id_user`
         WHERE `profiles`.`id`= '$idd' ";
      
        $conn->query($q);

    }

    // odredoto koje druge koriniske prati logovan korisnik
    $upit1="SELECT `id_receiver` FROM `followers` WHERE `id_sender`=$id";
    $res1= $conn->query($upit1);
    $niz1= array();
    while($row=$res1->fetch_array(MYSQLI_NUM)){
        $niz1[]=$row[0];
    }
   // var_dump($niz1);
    //Odrediti koji drugi korisnici prate drugog korisnika
    $upit2="SELECT `id_sender` FROM `followers` WHERE `id_receiver`=$id";
    $res2= $conn->query($upit2);
    $niz2= array();
    while($row=$res2->fetch_array(MYSQLI_NUM)){
        $niz2[]=$row[0];
    }
    //var_dump($niz2);

?>

<!doctype html>
<html lang="en">

<head>
    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Members of Social Newtwork</title>
  <link rel="stylesheet" href="style.css">


</head>

<body>
  
   <?php
    $q="SELECT `u`.`id` , `u`.`username`,
        `p`.`id` as p_id,
        CONCAT(`p`.`first_name`, ' ', `p`.`last_name`) AS full_name,
        `p`.`gender`,
        `p`.`image`
        FROM `users` AS `u`
        LEFT JOIN `profiles` AS `p`
        ON `u`.`id` = `p`.`id_user`
        WHERE `u`.`id` !=$id
        ORDER BY `full_name`
    ";

    $result=$conn->query($q);

    if($result->num_rows==0){

    ?>
        <div class="error">No other users in databese </div>

        <?php

} else {
?>
<div class="holder">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 image-side">
            
            </div>
            <div class="col md-6 " id="reg">
                <div class="input-box">
                    <header>Our other memebers</header>
                        <table class="tabela table table-hover">
                            

                                <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                
                                <td>
                                    <?php
                                
                                    if ($row["image"] == NULL && $row["gender"] == 'm') {
                                        echo "<img src='slike/male.jpg' style='width:40px; height:40px'>";
                                    } elseif ($row["image"] == NULL && $row["gender"] == 'f') {
                                        echo "<img src='slike/fmale.png' style='width:40px; height:40px'>";
                                    } elseif ($row["image"] == NULL || $row["gender"] == 'o') {
                                        echo "<img src='slike/qmark.png' style='width:40px; height:40px'>";
                                    } elseif ($row["image"] !== NULL) {
                                        echo "<img src='slike/".$row['image']."' style='width:50px; height:50px'>";
                                    }
                                    ?>
                                </td>
                                
                                <td>
                                    <?php
                                    
                                        $idd=$row["p_id"];
                                    if ($row["full_name"] !== NULL) {
                                        $ime=$row["full_name"];
                                        
                                        echo "<a href='show_copy.php?id=$idd' id='id'>$ime</a>";
                                        //echo '<a href="show.php?id=$id">$row["full_name"]</a>';
                                        //echo $row["full_name"];
                                    } else {
                                        echo $row["username"];
                                    }
                                
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        //ovde cemo linkove za pracenje
                                        $friendId = $row["id"];
                                        if(!in_array($friendId, $niz1)){

                                            if(!in_array($friendId, $niz2)){
                                                   $text="Follow";
                                                }else{
                                                    $text="Follow back";
                                                }
                                                echo "<a href='followers.php?friend_id=$friendId' class='follow'>$text</a>";
                                              //  
                                        }else{
                                            echo "<a href='followers.php?unfriend_id=$friendId' class='follow'>Unfollow</a>";
                                        }

                                        ?>
                                       
                                </td>
                            </tr>
                            <?php } ?>
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