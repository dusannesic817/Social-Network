<?php
session_start();

if(!isset($_SESSION["id"])){
    header("location: index.php");
}
require_once "connection.php";
require_once "header.php";


    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["id"])){

        $id=$conn->real_escape_string($_GET["id"]);
        
        $q="SELECT concat(`profiles`.first_name,' ',`profiles`.last_name) as osoba
        FROM profiles
        LEFT join followers ON followers.id_receiver=profiles.id_user
        WHERE followers.id_sender='$id'";

        $rezultat=$conn->query($q);

        $following=array();
        if($rezultat->num_rows>0){

            while($row=$rezultat->fetch_assoc()){
                $osobe=$row["osoba"];
                $following[]=$osobe;       
            }
        }
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
        <title>Following</title>
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
                                <header>Following</header>
                        <?php
                            if(!empty($following)){
                                foreach($following as $v){
                        ?>
                            <table  class="table table-hover">
                                <tr>    
                                    <td style="text-align:center;"><?php echo $v?></td>
                                </tr>
                            </table>
                            <?php
                                }
                            ?>        
                        </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php
                }else{
                    
                }
                ?>
    </body>
</html>
