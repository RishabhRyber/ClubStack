<?php
 session_start();
 require_once("../includesPHP/database.php");
 require_once ("../includesPHP/functions.php");
?>
<html>
<head>
    <?php
    require_once ('../includesPHP/cssIncludes.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Events ::
        <?php
          if (isset($_GET['q']))
              echo "Result For {$_GET['q']}";
          else
              echo "clubStack";
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
        .register{
            margin-bottom: -2%;
            background-color: #111;
        }
        
        body{
            margin-bottom: 3%;
            background-color: #0099ff;
            width: auto;
        }
        @media screen and (max-width: 768px){
            body{
                margin-bottom: 15%;
            }
        }
    </style>
</head>
<body>
  <?php
      require_once ("../includesPHP/navbar.php");

   ?>
    <?php
        if (isset($_GET['q'])) {
            $q = mysqli_real_escape_string($connection,$_GET['q']);
            $query = "SELECT * FROM events ";
            $query .= "WHERE MATCH(name,tagline,clubHosting,completeDetail) ";
            $query .= " AGAINST ('{$q}') ";
        } else {
          $query="SELECT * FROM events";
        }

  $res=mysqli_query($connection,$query);
  validateQuery($connection,$query);
  echoEventSnippit($res);
?>
  <?php
  $registerButton="
        <div class=\"register text-center\">
        <a href=\"registerEvent.php\">
            <input type=\"submit\" value=\"Register Your Event\">
        </a>
        </div>";

  if(isSomeoneLoggedIn('club')) {
      echo $registerButton;
  }
  ?>
<br>
</body>
</html>