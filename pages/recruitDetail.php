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
$query="SELECT * FROM recruits WHERE id={$id}";
$res=mysqli_query($connection,$query);
validateQuery($connection,$query);
$row=mysqli_fetch_assoc($res);

$recName=$row['name'].' Recruitment';
$briefDesc=$row['completeDetail'];
$recDocs=$row['requiredDocs'];
$imageLogo=$row['imageLogo'];
$contactNumber=$row['contactNumber'];
$recDate=$row['date'];
$recTime=$row['time'];
$recVenue=$row['venue'];
$formLink=$row['formLink'];
$completeDetail=$row['completeDetail'];
$completeDetail=explode('.',$completeDetail);
?>
<html>
<head>
    <?php
    require_once ('../includesPHP/cssIncludes.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php
           echo $recName;
        ?>
    </title>
    <style>
        body{
            margin-bottom: 5%;
            background-color: #111;
            width: auto;
            color: white;
        }
        #head{
            font-family: 'Monoton';
            font-size: 5vw;
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
            td{
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
      <h2 id='head' class='col-sm-12'>{$recName}</h2>
      <img class='img-thumbnail' src='/images/recLogos/{$imageLogo}'></img>
      <div class='descBox col-sm-8 col-sm-offset-2'>
      <h2>What it is About?</h2>
      <ul type='square'>
      ";

for ($i=0;$i<count($completeDetail);$i++){
    echo"<li>{$completeDetail[$i]}</li>";
}

echo "</ul></div>";
    
echo "<div class='col-sm-12'>
      <div class='table-responsive'>
      <table class='center'>
      <tr><th> Schecduled At </th><td> : {$recVenue}</td></tr>
      <tr><th> Date & Time </th><td> : {$recDate} at sharp {$recTime}</td></tr>
      <tr><th> Form Available at </th><td> : {$formLink}</td></tr>
      <tr><th> Requirements </th><td> : {$recDocs}</td></tr>
      <tr><th> For Further Reference Contact </th><td> : {$contactNumber}</td></tr>
      </table>
      </div>
      </div>
      </div>";
    
?>

</body>
</html>