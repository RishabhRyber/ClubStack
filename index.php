<?php
session_start();
include_once ('includesPHP/database.php');
include_once ("includesPHP/functions.php");
?>
<html>
<head>
    <?php
    require_once ('includesPHP/cssIncludes.php');
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-control" content="no-cache">
    <title>CLUBSTACK</title>
    <style>

        body{
            background-color: #111;
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
    </style>
</head>

<body> 
<?php
    require_once ("includesPHP/navbar.php");    
?>
<nav class="navbar-1 navbar-inverse text-center">
	<div class="container-fluid">
		<div class="navbar-header-3">
			<div class="col-sm-6">
                <div class="wrapper">  
                    <div class="focus">GET INVOLVED</div>
                    <div class="mask">
                        <div class="text">GET INVOLVED</div>
                    </div>
                </div>
                <h4 id="para1"></h4>
                <h4 id="para2"></h4>

             </div>
		</div>

		<div class="navbar-header-3">
			<div class="col-sm-6">
			   <img src="images/cover.jpg" id="icon" class="img-responsive">			
		     </div>
	    </div>
	</div>

</nav>

    
<div id= "main_container">
 <div id="clubs"  class="grow" onmouseover="show(1)">
  <h3 id="headClub">CLUBS</h3>
  <p  id="moreClub"><a href="pages/clubs.php">Click Here</a></p>
 </div>


 <div id="events" class="grow" onmouseover="show(2)">
   <h3 id="headEvents">EVENTS</h3>
   <p id="moreEvents"><a href=""><a href="pages/events.php">Click Here</a></p>
 </div>

 <div id="recruitments"  class="grow" onmouseover="show(3)">
 <h3 id="headRec">RECRUITMENTS</h3>
 <p id="moreRec"><a href=""><a href="pages/recruitments.php">Click Here</a></p>
 </div>
</div>


</body>
</html>