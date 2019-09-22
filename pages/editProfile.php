<?php
session_start();
include_once ("../includesPHP/database.php");
include_once ("../includesPHP/functions.php");
if(isSomeoneLoggedIn('club')){
    $clubName = whoIsLoggedIn('club');
    $query="SELECT * FROM clubs WHERE email='{$clubName}'";
    $res=mysqli_query($connection,$query);
    validateQuery($connection,$query);
    $row=mysqli_fetch_assoc($res);
    $clubName = $row['name'];
    $clubsMotto = $row['tagline'];
    $presidentName = $row['president'];
    $fields = $row['fields'];
    $websiteLink = $row['websiteLink'];
    $contactNumber = $row['contactNumber'];
}else {
    redirect('/clubStack');
}
?>
<html>
<head>
    <?php
    require_once ('../includesPHP/cssIncludes.php');
    ?>
    <title>Update Your Club</title>
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
            margin-bottom: 30px;
            margin-top: -30px;
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
            border: 5px solid #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
            opacity: 1;
        }
        h2{
            text-align: center;
            font-family: intro;
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
        input[type=checkbox]{
            font-family: "Helvetica Neue", Helvetica, sans-serif;
            font-size: 15px;
            outline: none;
            margin-top: 10px;
            display: inline-block;
            width: 20x;
            height: 20px;
            border: 0px solid #c7d0d2;
            border-radius: 3px;
            box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #f5f7f8;
            margin-left: 0px;
        }
        input[type=checkbox]:hover{
            border: 0px solid #b6bfc0;
            box-shadow: inset 0 0px 0px rgba(190, 190, 190, .7), 0 0 0 0px #66add6;
        }
        input[type=checkbox]:focus{
            border: 0px solid #a8c9e4;
            box-shadow: inset 0 0px 0px rgba(190, 190, 190, .4), 0 0 0 0px #66add6;
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


<script>
    //To Auto respond form for clubs login
    function imageShowHide(){
        var checkBox = document.getElementById("imageBox");
        if(checkBox.checked === true){
            document.getElementById('imageInput').style.visibility='visible';
        }else {
            document.getElementById('imageInput').style.visibility='hidden';
        }
    };


</script>



<?php
    require_once ("../includesPHP/navbar.php");
?>
<div class="container">
    <?php

        if (isset($_POST['submit'])) {
            $errors=clubUpdate();
            if(count($errors)==0){
                echo "<div class='alert alert-success alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Congrats!</strong> You have succesfully Updated Your Club Info.</div>";
            }else displayErrors($errors);
        }
    ?>
    <h2 style="color: #0D47A1">Edit The Details</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <label>
                        Club Name:
                    </label>
                </td>
                <td>
                    <input type="text" name="clubName" value="<?php echo $clubName ?>" readonly>
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        Club Motto:
                    </label>
                </td>
                <td>
                    <input type="text" name="clubMotto" value="<?php echo $clubsMotto ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        President Name:
                    </label>
                </td>
                <td>
                    <input type="text" name="presidentName" value="<?php echo $presidentName ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        Field Of Work(saperate by space):
                    </label>
                </td>
                <td>
                    <input type="text" name="clubFields" value="<?php echo $fields ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        Link Of Website or FB Page:
                    </label>
                </td>
                <td>
                    <input type="text" name="clubLinks" value="<?php echo $websiteLink ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        Contact Number :
                    </label>
                </td>
                <td>
                    <input type="number" name="contactNumber" value="<?php echo $contactNumber ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label>
                        Check it to change the image
                    </label>
                </td>
                <td>
                    <input type="checkbox" name="imageChange" id="imageBox" onclick="imageShowHide()">
                </td>

            </tr>
            <tr id="imageInput" style="visibility: hidden">
                <td>
                    <label>
                        Image For Club Logo:
                    </label>
                </td>
                <td>
                    <input type="file" accept="image/*" name="clubLogo" >
                </td>
            </tr>
            <tr>

                <td></td>
                <td><input type="submit" name="submit" value="update"></td>
            </tr>
    </form>
    <br><br>
</div>
</body>
</html>
