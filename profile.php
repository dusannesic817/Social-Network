<?php
    session_start();
    if(!isset($_SESSION["id"])){
        header("location: index.php");
    }
    require_once "connection.php";
    require_once "validation.php";


    $id=$_SESSION["id"];
    $firstName=$lastName =$dob= $gender =$image="";
    $firstNameError = $lastNameError= $dobError =$genderError=$imageError="";
    
    
    $profileRow= profilExists($id,$conn);
    // profileRow = false, ako profil ne postoji
    // profileROw = asocijativni niz, ako profil postoji

    if($profileRow!==false){
        $firstName=$profileRow["first_name"];
        $lastName=$profileRow["last_name"];
        $gender=$profileRow["gender"];
        $dob=$profileRow["dob"];
        $image=$profileRow["image"];
    }

    if(isset($_POST['sub']) && isset($_FILES['image'])){
       /* echo "<pre>";
        print_r($_FILES['image']);
        echo "</pre>";*/

        $img_name=$_FILES['image']['name'];
        $img_size=$_FILES['image']['size'];
        $tmp_name=$_FILES['image']['tmp_name'];
        $error=$_FILES['image']['error'];

        if($error === 0){
            if($img_size> 125000){
                $em = "Sorry your file is too large";
                header("location: index.php?error=$em");
            }else{
               $img_ex= pathinfo($img_name, PATHINFO_EXTENSION);
               $img_ex_lc=strtolower($img_ex);

               $allowed_exs=array("jpg", "jpeg", "png");

               if(in_array($img_ex_lc, $allowed_exs)){
                $image= uniqid("IMG-", true). ".". $img_ex_lc;
                $img_upload_path= 'slike/'.$image;
                move_uploaded_file($tmp_name, $img_upload_path );

               }else{
                    $em ="You cannot uploud files of this type";
                    header("location: index.php?error=$em");
               }
            }


        }else{
            $em ="unkown error occured";
        }

    }else{
       // header("location:index.php");
    }



   

    $sucMessage="";
    $errMessage="";
    


    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $firstName=$conn->real_escape_string($_POST["first_name"]);
        $lastName=$conn->real_escape_string($_POST["last_name"]);
        $gender=$conn->real_escape_string($_POST["gender"]);
        $dob=$conn->real_escape_string($_POST["dob"]);
       // $text=$conn->real_escape_string($_POST["text"]);
   //     $image=$conn->real_escape_string($_POST["image"]);

        //vrsimo validaciju polja
            $firstNameError=nameValidation($firstName);
            $lastNameError=nameValidation($lastName);
            $genderError=genderValidation($gender);
            $dobError=dobValidation($dob);
            
           // $imageError=imgValidation($image);
           

        //ako je sve u redu ubacujemo novi red u tabelu profiles
        if($firstNameError=="" && $lastNameError=="" && $genderError=="" && $dobError=="" &&  $imageError==""){

        $q="";
        if($profileRow === false){
            
            $q= "INSERT INTO `profiles`(`first_name`,`last_name`,`gender`,`dob`,`id_user`,`image`)
            VALUE
            ('$firstName','$lastName','$gender','$dob',$id,'$image')";

        }else{
           
            $q="UPDATE `profiles` 
            SET `first_name`='$firstName',
            `last_name`='$lastName',
            `gender`='$gender',
            `dob`='$dob',
            `image`='$image',
            WHERE `id_user`=$id 
            ";
        }
       
            if($conn->query($q)){
                //uspesno kreiran ili editovan profil
                if($profileRow!==false){
                    $sucMessage="You have edit your profile";
                }else{
                    $sucMessage="You have created your profile";
                }
               
            }else{
                // Desila se greska u upitu
                $errMessage="Error creating profile" .$conn->error;
            }
        
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
  <title>Profile</title>
  <link rel="stylesheet" href="style.css">


</head>

<body>
    <div class="success">
        <?php echo $sucMessage; ?>
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
                    <header>Please fill the profile details</header>
                
                    <form action ="#" method="POST"  enctype="multipart/form-data">
                        <div class="input-field">
                            <label for="first_name">First name:</label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo $firstName;?>">
                            <span class="error">*<?php echo $firstNameError; ?> </span>
                        </div>

                        <div class="input-field">
                            <label for="last_name">Last name:</label>
                            <input type="text" name="last_name" id ="last_name" value="<?php echo $lastName;?>">
                            <span class="error">* <?php $lastNameError;?></span>
                        </div>
                     
                        <div class="choose-holder">
                            <div class="choose" id="ch">
                                <label for="gender"></label>
                                <input type="radio" name="gender" id="m" value="m" <?php if($gender=='m'){echo "checked";} ?>> Male
                                <input type="radio" name="gender" id="f" value="f" <?php if($gender=='f'){echo "checked";} ?>> Female
                                <input type="radio" name="gender" id="o" value="o" <?php if($gender=='o' || $gender==""){echo "checked";}  ?> > Other
                                <span class="error"><?php echo $genderError;?></span>
                            </div>
                        

                            <div class="choose" id="dob">
                                <label for="dob">Date of birth</label>
                                <input type="date" name="dob" id="dob" value="<?php echo $dob; ?>">
                                <span class="error"><?php echo $dobError?></span>
                            </div>
                            <div class="choose" id="cPhoto">
                               <label for="image">Profile photo</label>
                               <input type="file" name="image" id="image" accept="image/*">
                               
                               <span class="error"></span>
                                
                            </div>
                            </div>


                                <?php
                                $poruka;
                                if($profileRow==false){
                                    $poruka="Create profile";
                                }else{
                                    $poruka="Edit profile";
                                }
                            ?>
                        <div class="input-field">
                            <input class="submit" type="submit"  name="sub" value="<?php echo $poruka; ?>">
                        </div>                     

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

  
</body>

</html>


