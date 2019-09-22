<?php
/**
 * Created by PhpStorm.
 * User: Rishabh
 * Date: 22-Jul-18
 * Time: 10:26 AM
 */
session_start();
require_once ("../includesPHP/functions.php");
require_once ("../includesPHP/database.php");
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    require_once ("../includesPHP/cssIncludes.php");
    ?>
    <title>Reset Password</title>
    <style>
        #full{
            margin-top: 5%;
        }
        .center{
            margin-left: auto;
            margin-right: auto;
        }
        .head1{
            font-family: intro;
        }
        table,td{
            padding: 1%;
        }
        table{
            width: 700px;
        }
        label{
            color: #555;
            font-family: archive;
            display: inline-block;
            margin-left: 18px;
            padding-top: 10px;
            font-size: 20px;
            font-weight: 100;
        }
        input[type=checkbox]{
            width: 20px;
            height: 15px;
            margin-left: 2%;
        }
        input[type=text],input[type=password],input[type=email] {
            color: #777;
            padding: 1%;
            margin: 2%;
            margin-top: 10px;
            width: 290px;
            align-content: right;
            height: 35px;
            border: 2px solid #c7d0d2;
            border-radius: 3px;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #f5f7f8;
            -webkit-transition: all .4s ease;
            -moz-transition: all .4s ease;
            transition: all .4s ease;
        }
        input[type=text]:hover,input[type=password]:hover,input[type=email]:hover {
            border: 1px solid #b6bfc0;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .7), 0 0 0 2px #66add6;
        }
        input[type=text]:focus,input[type=password]:focus,input[type=email]:focus {
            border: 1px solid #a8c9e4;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 2px #66add6;
        }
        input[type=submit]{
            font-family: archive;
            font-size: 20px;
            font-weight: 0;
            outline: none;
            margin: 2%;
            margin-top: 10px; 
            display: inline-block;
            width: 290px;
            height: 35px;
            border: 2px solid #c7d0d2;
            border-radius: 3px;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #f5f7f8;
        }
        input[type=submit]:hover {
            background-image: -webkit-gradient(linear, left top, left bottom, from(#b6e2ff), to(#6ec2e8));
            background-image: -moz-linear-gradient(top left 90deg, #b6e2ff 0%, #6ec2e8 100%);
            background-image: linear-gradient(top left 90deg, #b6e2ff 0%, #6ec2e8 100%);
        }
        input[type=submit]:active {
            background-image: -webkit-gradient(linear, left top, left bottom, from(#6ec2e8), to(#b6e2ff));
            background-image: -moz-linear-gradient(top left 90deg, #6ec2e8 0%, #b6e2ff 100%);
            background-image: linear-gradient(top left 90deg, #6ec2e8 0%, #b6e2ff 100%);
        }
        @media screen and (max-width: 768px){
            input[type=text],input[type=password],input[type=email],input[type=submit]{
                display: table-row;
            }
        }
    </style>
</head>
<body>
<?php
require_once ("../includesPHP/navbar.php");
?>



<?php
    $emailForm="
       <div class=\"container-fluid text-center\" id='full'>
        <h3 class='head1'>
            Enter the registered email to reset the password:
        </h3><br>
        <div class='table-responsive'>
        <table class='center'>
        <form action=\"\" method=\"post\">
            <div class='rpass'><label>This is a club account</label>
            <input type='checkbox' name='club' ><br>
            <input type=\"email\" name=\"email\"  class=\"text-lg-center\" required>
            <input type=\"submit\" class=\"btn-outline-success\" name=\"submit\" value=\"Submit\"></div>
        </form>
        </table>
        </div>
       </div>";

    $passwordForm="<div class=\"container-fluid text-center\" id='full'>
            <h3 class='head1'>
                Please enter the new password:
            </h3><br>
            <div class='table-responsive'>
            <table class='center'>
            <form action=\"\" method=\"post\">
                <tr>
                <td><label>Enter Password</label></td>
                <td><input type=\"password\" name=\"pwd1\"  class=\"text-lg-center\" required></td>
                </tr>
                <tr>
                <td><label>Confirm Password</label></td>
                <td><input type=\"password\" name=\"pwd1\"  class=\"text-lg-center\" required></td>            
                <tr>
                <td></td><td><input type=\"submit\" class=\"btn-outline-success\" name=\"pwdSubmit\" value=\"Submit\"></td>
                </tr>
            </form>
            </table>
            </div>
        </div>";

?>
<?php
if (isset($_POST['submit'])){ //Submit is when the very first form to reset password is filled.
    $email=mysqli_real_escape_string($connection,$_POST['email']);
    $query="SELECT COUNT(*) AS cunt FROM ";
    if (isset($_POST['club'])&&$_POST['club']=='on'){
        $query.="clubs ";
        $type="clubs";
    }else {
        $query .= "users ";
        $type='user';
    }
    $query.=" WHERE email= '{$email}'";
    $res=mysqli_query($connection,$query);
    validateQuery($connection,$query);
    $row=mysqli_fetch_assoc($res);
    if($row['cunt']==0){
        echo "You have entered a wrong Email-id";
        die();
    }
    $resetKey=md5(rand());
    $query="INSERT INTO pwdresetkey (email, type,resetKey ) ";
    $query.="VALUES ('{$email}','{$type}','{$resetKey}')";
    mysqli_query($connection,$query);
    validateQuery($connection,$query);
    require_once ('../includesPHP/sendMail.php');

    $head="Password Reset For clubStack";
    $body="Please visit the Link to reset your password\n";
    $body.="https://clubstack.000webhostapp.com/pages/resetPassword.php?resetKey={$resetKey}";
    sendMail($email,$body,$head);
    echo "<div class='jumbotron text-center'><B>Password reset URL has been sent to your email. Please visit it.</B></div>";

}

else if ((!isset($_POST['pwdSubmit']))&&isset($_GET['resetKey'])){
    echo $passwordForm;
}
else if(isset($_POST['pwdSubmit'])&&isset($_GET['resetKey'])){
    $resetKey=mysqli_real_escape_string($connection,$_GET['resetKey']);
    $password=mysqli_real_escape_string($connection,$_POST['pwd1']);
    $password=md5($password);
    $query="SELECT * FROM pwdresetkey WHERE resetKey='{$resetKey}'";
    $res= mysqli_query($connection,$query);
    validateQuery($connection,$query);
    $row=mysqli_fetch_assoc($res);
    if($row['type']=='user'){
        $query="UPDATE users SET pwd= '{$password}' WHERE email= '{$row['email']}'";
    }else if($row['type']=='clubs'){
        $query="UPDATE clubs SET password= '{$password}' WHERE email= '{$row['email']}'";

    }
    mysqli_query($connection,$query);
    validateQuery($connection,$query);
    $query="DELETE from pwdresetkey WHERE email='{$row['email']}'";
    mysqli_query($connection,$query);
    validateQuery($connection,$query);

    echo "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Congrats!</strong> You have successfully Changed Your Password.</div>";

}else
    echo $emailForm;

?>



</body>
</html>