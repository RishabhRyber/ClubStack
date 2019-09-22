<?php

session_start();
require_once("../includesPHP/database.php");
require_once ("../includesPHP/functions.php");
if(!isset($_GET['id'])){
    redirect('/');
}
?>

<?php

$id=$_GET['id'];
$query="SELECT * FROM events WHERE id={$id}";
$res=mysqli_query($connection,$query);
validateQuery($connection,$query);
$row=mysqli_fetch_assoc($res);

$eventName=$row['name'];
$tagLine=$row['tagline'];
$logo=$row['imageLogo'];
$completeDetail=$row['completeDetail'];
$completeDetail=explode('.',$completeDetail);
$date=$row['date'];
$time=$row['time'];
$regFee=$row['regFee'];
$clubhosting=$row['clubHosting'];
$contactNumber=$row['contactNumber'];
$venue=$row['venue'];
$visitors = $row['visitorsCount'];

if($regFee==0){
    $regFee='Just Your Capability';
}
?>
<html>
<head>
    <?php
    require_once ('../includesPHP/cssIncludes.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php
           echo $eventName;
        ?>
    </title>
    <style>
        body{
            margin-bottom: 3%;
            background-color: #111;
            width: auto;
            color: white;
        }
        #head{
            font-family: 'Monoton', serif;
            font-size: 6vw;
            color: #0033ff;
            word-spacing: 10px;
            background-color: #111;
            padding: 1%;
            padding-bottom: 2%;
            margin-top: 0%;
        }
        img{
            max-height: 600px;
            margin-bottom: 3%;
        }
        .everything{
            background-color: #111;
            color: white;
        }
        .everything table{
            font-family: archive;
            font-size: 2vw;
            width: 70%;
            margin-bottom: 2%;
        }
        .everything h2{
            font-family: 'Bubblegum Sans';
            font-size: 40px;
        }
        th, td{
            padding: 2%;
        }
        th{
            color: #0088ff;
        }
        .center{
            margin-left: auto;
            margin-right: auto;
        }
        body p {
            font-size: 50px;
            margin-bottom: 3%;
            font-family: 'Amatic SC';
        }
        .descBox{
            border: 5px solid #fff;
            margin-bottom: 3%;
        }
        .descBox ul{
            color: #0088ff;
            font-family: cursive;
            font-size: 18px;
        }
        @media screen and (max-width: 768px){
            #head{
                font-size: 13vw;
            }
            .everything table{
                font-size: 4vw;
                width: 90%;
            }
            th, td{
                padding: 0%;
            }
        }
    </style>
</head>
<body>
<?php
require_once ("../includesPHP/navbar.php");
?>
<?php
echo "<div class='everything container-fluid text-center'>
    <h2 id='head' class='col-sm-12'>{$eventName}</h2>
      <img class='img-thumbnail' src='/images/eventLogos/{$logo}'></img><br>
      <p>{$tagLine}</p>
      <div class='descBox col-sm-8 col-sm-offset-2'>
      <h2>What it is About?</h2>
      <ul type='square'>";

for ($i=0;$i<count($completeDetail);$i++){
    echo"<li>{$completeDetail[$i]}</li>";
}    

echo "</ul></div>";
    
echo "<div class='col-sm-12'>
      <div class='table-responsive'>
      <table class='center'>
      <tr><th><b>Posted By </th><td>: <a href='/pages/clubProfile.php/?name={$clubhosting}' style='color: #888;'> {$clubhosting}</a></b></td></tr>
      <tr><th><b>Date & Time  </th><td> : {$date} {$time}</b></td></tr>
      <tr><th><b>Venue Of Event </th><td> : {$venue}</b></td></tr>
      <tr><th><b>Regestration Fee </th><td> : {$regFee}</b></td></tr>
      <tr><th><b>No Of Interested Students </th><td> : {$visitors}</b></td></tr>
      <tr><th><b>For Further Reference Contact</th><td> : {$contactNumber}</b></td></tr>
      </table>
      </div>
      </div>";

echo "</div>";



?>

</body>
</html>