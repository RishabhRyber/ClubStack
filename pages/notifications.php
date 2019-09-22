<?php
session_start();
 require_once("../includesPHP/database.php");
 require_once ("../includesPHP/functions.php");
  if (!isSomeoneLoggedIn('user')){
      redirect('/clubStack/pages/UserLogin.php');
  }else if(isSomeoneLoggedIn('club')){
      redirect('/clubStack');
  }
 ?>
<html>
<head>
    <?php
    require_once ('../includesPHP/cssIncludes.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Home :: ClubStack
    </title>
    <style>
        body{
            background-color: #111;
            width: auto;
        }
        .user-head{
            font-size: 40px;
            width: 100%;
            background-color: #333;
            color: white;
            padding: 1%;
            font-family: robo;
        }
        .container_new{
            background-color: #0099ff;
        }
        input[type=submit]{
            position: relative;
            margin-top: 15px;
            margin-bottom: 30px;
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
        body{
            background-color: #111;
            width: auto;
        }
        #name{
            font-family: batman;
            font-size: 40px;
            color: #003399;
        }
        .new-container{
            padding: 1%;
        }
        img{
            border-radius: 50%;
            max-width: 400px;
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
        .club-info h2{
            color: white;
            font-family: robo;
        }
        .club-info table{
            font-size: 20px;
            width: 100%;
            font-family: archive;
            color: #fff;
        }
        td,th{
            padding: 5%;
        }
        @media screen and (max-width: 768px){
            .image-top{
                margin-top: 3%;
            }
        }
    </style>
</head>
<body>
<?php
require_once ("../includesPHP/navbar.php");
?>
<?php
$userName=whoIsLoggedIn('user');
$query="SELECT * from users WHERE userName='{$userName}'";
$res=mysqli_query($connection,$query);
validateQuery($connection,$query);
$row=mysqli_fetch_assoc($res);
$name=$row['name'];
$email=$row['email'];
$contactNumber=$row['contactNumber'];
$gender=$row['gender'];
$followedClubs=explode(',',$row['followedClubs']);
$followedClubsCount=count($followedClubs);

if($gender === 'M'){
    $imageLogo = '/images/male.jpg';
} else {
    $imageLogo = '/images/female.jpg';
}
    
echo "<div class='new-container'>
            <div class='new-row'>
            <div class='image-top col-sm-4'>
            <img class='card-img-top' src='{$imageLogo}'>
            </div>
            <div class='col-sm-6 col-sm-offset-2 text-center'>
            <div class='club-info text-center'>
            <h1 id='name'>Hey {$name}!</h1>
            <h2>Followed Clubs</h2>
            <h3>
            <div class='table-responsive'>
            <table>";
for($i=1;$i<$followedClubsCount;$i++){    
    echo "<tr><th>
        <i class='fa fa-user-circle'></i>&ensp;<b><a href=\"/pages/clubProfile/?name='{$followedClubs[$i]}'\"> $followedClubs[$i]</a></b>
        </th></tr>";
}
            
echo "</table>
        </h3>
        </div>
        </div>
        </div>
        </div>
     </div>";

if ($followedClubsCount>1){
    $iota = 0;
    $error_count = 0;
    echo "<div class='container_new'>";
    echo "<table>";
    for ($i=1;$i<$followedClubsCount;$i++){

        $query="SELECT * FROM events WHERE clubHosting='{$followedClubs[$i]}'  ORDER BY date DESC ";
        $res=mysqli_query($connection,$query);
        $res1=mysqli_query($connection,$query);
        validateQuery($connection,$query);
        $row1=mysqli_fetch_assoc($res1);
        if($i === 1) {
            echo "<h3><div class='user-head text-center' id='heading'>Recent Events</div></h3>";
        }
        if(count($row1)>0) {
            while($row=mysqli_fetch_assoc($res)){
                $eventName=$row['name'];
                $eventTagline=$row['tagline'];
                $clubHosting=$row['clubHosting'];
                $imageLogo="/images/eventLogos/" . $row['imageLogo'];
                $contactNumber=$row['contactNumber'];
                $regFee=$row['regFee'];
                $eventID=$row['id'];
                if($regFee==0){
                    $regFee='Free';
                }
                $eventDate=$row['date'];
                $eventTime=$row['time'];
                $eventVenue=$row['venue'];

                if(($iota%3==0)&&($iota>0)){
                    echo "</tr>";
                }
                if($iota%3==0){
                    echo "<tr class='row'>";
                }
                $snippit="<td class='Snippit'>
                        <div id='snippitTop'>
                             <div id='logo'><img class='img_logo img-thumbnail' src='{$imageLogo}'></div>
                        </div>
                        <div id='snippitBottom'>
                             <h2 class='title'><a href='/pages/eventDetail/?id={$eventID}'>{$eventName}</a></h2>
                             <p> {$eventTagline} </p>
                             <p>Hosted By : {$clubHosting}</p>
                             <p>Regestration Fee : {$regFee}</p>
                             <p>At {$eventVenue} at {$eventTime} {$eventDate}</p>
                             <p>Contact : {$contactNumber}</p>
                             </td>
                        </div>";
                echo $snippit;
                $iota++;
            }
        }else{
            $snip[$error_count] = "<div class='alert alert-danger'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <p class=\"errorMsg\"><b>No recent events from {$followedClubs[$i]}</b></p>
                    </div>";
            $error_count++;
        }
    }
    echo "</tr>";
    echo "</table>";
    for ($i = 0; $i < $error_count; $i++)
        echo $snip[$i];
    $error_count = 0;
    echo "<table>";
    $iota = 0;
    for ($i=1; $i<$followedClubsCount;$i++){
        
        $query="SELECT * FROM recruits WHERE name='{$followedClubs[$i]}' ORDER BY date DESC ";
        $res=mysqli_query($connection,$query);
        $res1=mysqli_query($connection,$query);
        validateQuery($connection,$query);
        $row1=mysqli_fetch_assoc($res1);
        if($i === 1) {
            echo "<h3><div class='user-head text-center' id='heading'>Recent Recruitments</div></h3>";
        }
        if(count($row1)>0) {
            while($row=mysqli_fetch_assoc($res)){
                $id=$row['id'];
                $recName=$row['name'];
                $briefDesc=$row['completeDetail'];
                $recDocs=$row['requiredDocs'];
                $imageLogo="/images/recLogos/" . $row['imageLogo'];
                $contactNumber=$row['contactNumber'];
                $recDate=$row['date'];
                $recTime=$row['time'];
                $recVenue=$row['venue'];

                if(($iota%3==0)&&($iota>0)){
                    echo "</tr>";
                }
                if($iota%3==0){
                    echo "<tr class='row'>";
                }
                $snippit="<td class='Snippit'>
                        <div id='snippitTop'>
                             <div id='logo'><img class='img_logo img-thumbnail' src='{$imageLogo}'></div>
                        </div>
                        <div id='snippitBottom'>
                             <h2 class='title'><a href='/pages/recruitDetail/?id={$id}'>{$recName}</a></h2>
                             <p> {$briefDesc} </p>
                             <p> Required Documents : {$recDocs}</p>
                             <p>At {$recVenue} @ {$recTime} on {$recDate}</p>
                             <p>Contact : {$contactNumber}</p>
                             </td>
                        </div>";
                echo $snippit;
                $iota++;
            }
        }else{
            $snip[$error_count] = "<div class='alert alert-danger'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <p class=\"errorMsg\"><b>No recent recruitments from {$followedClubs[$i]}</b></p>
                    </div>";
            $error_count++;
        }
    }
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    for ($i = 0; $i < $error_count; $i++)
        echo $snip[$i];
}else{
    echo "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <p class=\"errorMsg\"><b>You don't follow any club. Follow them to get all their updates here. Here are few trending clubs</b></p>
            </div>";

    $query="SELECT * FROM clubs ORDER BY followersCount DESC LIMIT 6";
    $res=mysqli_query($connection,$query);
    validateQuery($connection,$query);
    echoClubSnippit($res);

}
?>
</body>
    <script>                    document.getElementById('name').addEventListener('mouseover', function () {
            document.getElementById('name').style.color = 'white';
        });
        document.getElementById('name').addEventListener('mouseout', function () {
            document.getElementById('name').style.color = '#003399';
        });
    </script>
</html>