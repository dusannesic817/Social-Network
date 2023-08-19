<?php
    $message="";
    if($_SERVER["REQUEST_METHOD"]== "GET" && isset($_GET['m'])){
        $message=$_GET['m'];
    }
?>
<!doctype html>
<html lang="en">

<head>
    
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Social Network</title>
  <link rel="stylesheet" href="style.css">


</head>

<body>
    
    <h1 >Oooops! An error occured!</h1>
    <div class="error">
        <?php echo $message ?>
    </div>

    Return to <a href="index.php">Home page</a>

  

</body>

</html>