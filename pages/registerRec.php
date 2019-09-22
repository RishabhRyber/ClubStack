<?php
session_start();
include_once ("../includesPHP/database.php");
include_once ("../includesPHP/functions.php");

if(!isSomeoneLoggedIn('club')){
    redirect('/clubStack');

}


?>
<html>
<head>
    <?php
    require_once ('../includesPHP/cssIncludes.php');
    ?>
    <title>Register Your Recruitment</title>
    <style>
        .navbar {
        margin-bottom: 0%;
        background-color: #F5F5F5;
        color: #000000;
        padding: 0% 0;
        margin-top: 0.5%;
        font-size: 1.1em;
        border: 0;
    }
    .navbar-1{
        background-color: #0099ff;
        font-size: 4em;

    }
    .navbar-2{

        background-color: #ffffff;
        box-shadow: transparent;
    }

    .navbar-inverse-2{
        color:#000000;
        background-position: center;
        background-color: #E0FFFF;
    }
    .club h1{
        color: #0D47A1;
        font-family: batman;
    }
    .navbar-brand h1{
        float: left;
        color: #0D47A1;
        font-family: batman;
        min-height: 20px;
        margin-top: -5px;
        padding:0 0px 3px;
    }
    #right_nav{
        margin-top: 5px;        
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
    form{
            margin: 0 auto;
            height: auto;
            margin-bottom: 30px;
            margin-top: 0px;
            display: table;
    }
    body{
            background: #66add6;
    }
    .container{
            top: 0%;
            position: relative;
            width: 700px;
            height: auto;
            background: #fff;
            border-radius: 3px;
            border: 15px solid #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
            opacity: 1;
    }
    h2{
        text-align: center;
        font-family: intro;
    }
        #bada-textbox{
            font-family: "Helvetica Neue", Helvetica, sans-serif;
            font-size: 15px;
            outline: none;
            margin-top: 10px; 
            display: inline-block;
            border: 2px solid #c7d0d2;
            border-radius: 3px;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #f5f7f8;
            margin-left: 50px;
        }
    input{
            font-family: "Helvetica Neue", Helvetica, sans-serif;
            font-size: 15px;
            outline: none;
            margin-top: 10px; 
            display: inline-block;
            width: 290px;
            height: 35px;
            border: 2px solid #c7d0d2;
            border-radius: 3px;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #f5f7f8;
            margin-left: 50px;
    }
    input[type=file]{
            font-family: "Helvetica Neue", Helvetica, sans-serif;
            font-size: 17px;
            outline: none;
            margin-top: 10px; 
            display: inline-block;
            width: auto;
            height: auto;
            border: 0px solid #fff;
            border-radius: 3px;
            margin-left: 50px;
    }
    input:hover{
            border: 1px solid #b6bfc0;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .7), 0 0 0 2px #66add6;  
    }
    input:focus{
            border: 1px solid #a8c9e4;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 2px #66add6;
    }
    input[type=file]:hover{
            border: 0px solid #b6bfc0;
            box-shadow: none;  
    }
    input[type=file]:focus{
            border: 0px solid #a8c9e4;
            box-shadow: none;
    }
    input[type=submit]{
        float: left;
        font-family: archive;
        font-size: 20px;
        font-weight: 0;
        outline: none;
        margin-top: 20px; 
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
    </style>

</head>
 <body>
  <?php
  require_once ("../includesPHP/navbar.php");
  ?>
  <div class="container">
      <h2>Enter The Following Details</h2>
  <form action="" method="post" enctype="multipart/form-data">
      <?php
      if (isset($_POST['submit'])) {
          $errors=recRegister();
          if(count($errors)==0){
              echo "<div class='alert alert-success'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              <strong>Congrats!</strong> You have succesfully Registered Your Recruitment.</div>";
          }else displayErrors($errors);
      }
      ?>

      <?php
      //To auto feed club name to forms
      $email=whoIsLoggedIn('club');
      $query="SELECT name FROM clubs WHERE email='{$email}'";
      $res=mysqli_query($connection,$query);
      validateQuery($connection,$query);
      $row=mysqli_fetch_assoc($res);
      $name=$row['name'];
      ?>

      <table>
        <tr>
            <td>
            <label>
            Club Name:
            </label>
            </td>
            <td>
            <input type="text" name="clubName" value="<?php   echo $name;  ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>
            <label>
            Brief Description:
            </label>
            </td>
            <td>
                <textarea name="briefDesc" cols="33" rows="10" wrap="hard" id="bada-textbox"></textarea>
            </td>
        </tr>
        <tr>
            <td>
            <label>
            Required Documents:
            </label>
            </td>
            <td>
            <input type="text" name="recDocs">
            </td>
        </tr>
        <tr>
            <td>
            <label>
            Date:
            </label>
            </td>
            <td>
            <input type="date" name="recDate">
            </td>
        </tr>
        <tr>
            <td>
            <label>
            Time:
            </lable>
            </td>
            <td>
            <input type="time" name="recTime">
            </td>
        </tr>
        <tr>
            <td>
            <label>
            Venue:
            </label>
            </td>
            <td>
            <input type="text" name="recVenue">
            </td>
        </tr>
        <tr>
            <td>
            <label>
            Online Form Link:
            </label>
            </td>
            <td>
            <input type="text" name="recForm">
            </td>
        </tr>
        <tr>
            <td>
            <label>
            Contact Number: 
            </label>
            </td>
            <td>
            <input type="number" name="contactNo">
            </td>
        </tr>
        <tr>
            <td>
            <label>
            Image :
            </label>
            </td>
            <td>
            <input type="file" accept="image/*" name="recLogo">
            </td>
        <tr>
             <tr>
            <td>
                <label>
                    Notify Followers by mail:
                </label>
            </td>
            <td>
                <input type="checkbox"  name="emailNotifyTrigger" >
            </td>
        <tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit"></td>
        </tr>   
        </form>
     </div>
</body>
</html>
