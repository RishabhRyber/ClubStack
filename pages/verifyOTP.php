<?php
session_start();
require_once ("../includesPHP/functions.php");
require_once ("../includesPHP/database.php");
?>

<?php
function userVerified(){
    global $connection;
    $verifyURL= mysqli_real_escape_string($connection,$_POST['verifyURL']);
    $query="SELECT * FROM userstemp where verifyURL='{$verifyURL}'";
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    $name=$res['name'];
    $userName=$res['userName'];
    $pwd=$res['pwd'];
    $email=$res['email'];
    $contactNumber=$res['contactNumber'];
    $gender=$res['gender'];

    $query="INSERT INTO users(name,userName,pwd,email,contactNumber,gender) ";
    $query.="VALUES('{$name}','{$userName}','{$pwd}','{$email}','{$contactNumber}','{$gender}')";
    mysqli_query($connection,$query);
    $query="DELETE FROM userstemp where verifyURL='{$verifyURL}'";
    mysqli_query($connection,$query);
    require_once ("../includesPHP/sendMail.php");
    $body="Congrats {$name} You have succesfully Signed Up For ClubStack \n
     Your Login Credentials are:\n
     UserName: {$userName}\n
     Password: As if we will send it in plain text.\n
     Contact Number: {$contactNumber}\n
     Email-ID: {$email}\n
    ";
    $subject="User Verified :: ClubStack";
    sendMail($email,$body,$subject);
    echo "<div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        <p class=\"text-center\">Congrats. You have successfully signed up to clubStack.</p>
        </div>";

}
function verifyOTP(){
    global $connection;
    $verifyURL= $_POST['verifyURL'];
    $query="SELECT OTP from userstemp where verifyURL='{$verifyURL}'";
    $res=mysqli_query($connection,$query);
    if(!$res){
        echo "It's a Wrong URL.";
        die();
    }
    $res=mysqli_fetch_assoc($res);
    $dbotp=$res['OTP'];
    if($dbotp==$_POST['OTP']){
        userVerified();
        die();
    }else{
        echo "The OTP you entered was incorrect. Try reopening the link.";
    }
  }

?>
<html>
   <head>
       <?php
       require_once ("../includesPHP/cssIncludes.php");
       ?>
       <title>Verify Your OTP</title>
   </head>
   <body>
   <?php
   require_once ("../includesPHP/navbar.php");
   ?>


   <?php
   if (!isset($_GET['key'])){
       echo "<h2 class='text-center'>You visited a wrong Page. Please go back.</h2>";
       die();
   }
   if(isset($_POST['OTP'])){
       verifyOTP();
   }
   ?>
   <div class="jumbotron text-center">
   <h3>
       Enter the OTP you received through SMS:
   </h3><br>
       <form action="" method="post">
       <input type="text" name="verifyURL"  value="<?php echo $_GET['key'];?>" hidden>
       <input type="text" name="OTP"  class="text-lg-center" required>
       <input type="submit" class="btn-outline-success" name="submitOTP" value="Submit OTP">
   </form>
   </div>
   </body>

</html>