<?php
    session_start();
    require_once("../includesPHP/database.php");
    require_once ("../includesPHP/functions.php");
    if(!isset($_GET['name'])){
        redirect('/');
}
?>

<?php

$name=$_GET['name'];
$query="SELECT * FROM clubs WHERE name='{$name}'";
$res=mysqli_query($connection,$query);
validateQuery($connection,$query);
if(!$row=mysqli_fetch_assoc($res)){
    echo "<div class='alert alert-danger'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        <p class=\"errorMsg\">No Such Club is listed with us.
        </p></div>";
    die();
}

$clubName = $row['name'];
$clubsMotto = $row['tagline'];
$presidentName = $row['president'];
$fields = $row['fields'];
$websiteLink = $row['websiteLink'];
$imageLogo = "/images/clubLogos/" . $row['imageLogo'];
$contactNumber = $row['contactNumber'];
$email = $row['email'];
$followersCount=$row['followersCount'];

?>
<html>
<head>
    <?php
    require_once ('../includesPHP/cssIncludes.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php
        echo $clubName;
        ?>
    </title>
    <style>
        input[type=submit]{
            position: relative;
            margin-top: 15px;
            width: 200px;
            height: 7%;
            font-size: 14px;
            font-weight: bold;
            color: #444;
            background-color: #acd6ef; /*IE fallback*/
            background-image: -webkit-gradient(linear, left top, left bottom, from(#acd6ef), to(#6ec2e8));
            background-image: -moz-linear-gradient(top left 90deg, #acd6ef 0%, #6ec2e8 100%);
            background-image: linear-gradient(top left 90deg, #acd6ef 0%, #6ec2e8 100%);
            border-radius: 30px;
            border: 2px solid #66add6;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .3), inset 0 1px 0 rgba(255, 255, 255, .5);
            cursor: pointer;
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
        #events-full{
            display: block;
            background-color: #0099ff;
        }
        #recruits-full{
            display: none;
            background-color: #0099ff;
        }
        body{
            background-color: #111;
            width: auto;
        }
        #name{
            font-family: batman;
            font-size: 60px;
            color: #003399;
        }
        .motto{
            font-size: 50px;
            font-family: 'Tangerine', serif;
            color: white;
        }
        .new-container{
            padding: 1%;
        }
        .user-head{
            width: 100%;
            background-color: #000;
            color: antiquewhite;
            padding: 1%;
            font-family: intro;
        }
        img{
            max-width: 300px;
            max-height: 400px;
        }
        .image-top{
            padding-top: 3%;
            padding-left: 5%;
        }
        .new-row{
            display: table-row;
            width: 200%;
        }
        .tab-group {
            margin-top: 2%;
            list-style: none;
            padding: 1%;
            background-color: #111;
        }
        .tab-group:after {
          content: "";
          display: table;
          clear: both;
        }
        .tab-group li a {
          display: block;
          text-decoration: none;
          padding: 15px;
          background: rgba(160, 179, 176, 0.25);
          color: #a0b3b0;
            font-family: robo;
          font-size: 20px;
          text-align: center;
          cursor: pointer;
          transition: .5s ease;
        }
        .tab-0{
            width: 100%;
        }
        .tab-1{
            width: 100%;
        }
        .tab-group li a:hover {
          background: #003399;
          color: #ffffff;
        }
        .tab-group .active a {
          background: #003399;
          color: #ffffff;
        }
        .tab-content > div:last-child {
          display: none;
        }
        .club-info table{
            font-size: 20px;
            width: 550px;
            font-family: archive;
            color: #d0d0d0;
        }   
        td,th{
            padding: 2%;
        }
        .club-info table{
            width: 100%;
        }
        @media screen and (max-width: 768px){
            .image-top{
                margin-top: 3%;
            }
            .motto{
                font-size: 30px;
            }
            body{
                margin-bottom: 15%;
            }
        }
        }
    </style>
</head>
<body>
<?php
require_once ("../includesPHP/navbar.php");
?>
<?php
    echo "<div class='new-container'>
            <div class='new-row'>
            <div class='image-top col-sm-6'>
            <img class='card-img-top img-thumbnail' src='{$imageLogo}'>
            </div>
            <div class='col-sm-6 text-center'>
            <div class='club-info text-center'>
            <h1 id='name'>{$clubName}</h1>
            <h4 class='motto'>{$clubsMotto}</h4>
            <h3>
            <div class='table-responsive'>
            <table>
            <tr>
            <th><i class='fa fa-user-circle'></i><b>  Leader </b></th><td>: {$presidentName}</td>
            </tr>
            <tr>
            <th><i class='fa fa-suitcase'></i><b>  Field Of Work </b></th><td>: {$fields}</td>
            </tr>
            <tr>
            <th><i class='fa fa-paper-plane'></i><b>  Contact Here </b></th><td>: {$contactNumber}</td>
            </tr>
            <tr>
            <th><i class='fa fa-users'></i><b>  Followers </th><td>: {$followersCount}</b></td>
            </tr>
            </table>
            </h3>
            </div>
            </div>
            </div>
            </div>
         </div>
         ";
    
?>
<ul class="tab-group">
    <div class="col-sm-6">
        <li class="tab-0 active" id="events-tab"><a href="#"><h3>Events</h3></a></li>
    </div>
    <div class="col-sm-6">
        <li class="tab-1" id="recruits-tab"><a href="#"><h3>Recruitments</h3></a></li>
    </div>
</ul>
<?php
    $query="SELECT * FROM events WHERE clubHosting='{$clubName}'";
    $res=mysqli_query($connection,$query);
    validateQuery($connection,$query);
    $resTemp=mysqli_query($connection,$query);

    if(mysqli_fetch_assoc($resTemp)){
        echo "<div id='events-full'>
        <h3><div class='user-head text-center' id='heading'>Events From Team {$clubName}</div></h3>";
        echoEventSnippit($res);
        echo "</div>";
    }else
        echo"<div id='events-full'>
            <div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <p class=\"errorMsg\">Currently No Event Is Listed From {$clubName}</p></div>
            </div>";

    //Now For Listing recruitments


    $query="SELECT * FROM recruits WHERE name='{$clubName}'";
    $res=mysqli_query($connection,$query);
    validateQuery($connection,$query);
    $resTemp=mysqli_query($connection,$query);

    if(mysqli_fetch_assoc($resTemp)){
        echo "<div id='recruits-full'>
        <h3><div class='user-head text-center' id='heading'>Recruitments From Team {$name}</div></h3>";
        echoRecSnippit($res);
        echo "</div>";
    }else
        echo "<div id='recruits-full'>
            <div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <p class=\"errorMsg\">Currently No Recruitment Is Listed From {$clubName}</p></div>
            </div>";
?>


<br>
<br>
<?php
if(isSomeoneLoggedIn('club')&&whoIsLoggedIn('club')==$email){
    $editProfileButton="
        <div class=\"register text-center\">
        <a href=\"/pages/editProfile.php\">
            <input type=\"submit\" value=\"Edit Your Profile\">
        </a>
        </div>";
    
    echo $editProfileButton;
}
?>

<br>
<br>


</body>
    <script type="text/javascript" src="/js/clubProfile.js"></script>
</html>