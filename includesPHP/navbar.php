<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"> </span>
				<span class="icon-bar"> </span>
				<span class="icon-bar"> </span>
			</button>
		    <a class="navbar-brand" href="/index.php"> 
                <h1><B>CLUBSTACK</B></h1>
		    </a>

	   </div>

        <div class="collapse navbar-collapse" id="myNavbar">
	        <ul class="nav navbar-nav navbar-right">
	    	        <li class="club"><a href="/pages/clubs.php"><B>CLUBS </B></a></li>
		        <li class="event"><a href="/pages/events.php"><B>EVENTS </B></a></li>
		        <li class="recruit"><a href="/pages/recruitments.php"><B>RECRUITMENTS</B></a></li>
                <?php
                    if (isSomeoneLoggedIn('user')){
                        echo "<li class=\"login\"><a href='/pages/logOut.php'><B>LOGOUT</B></a></li>";
                        echo"<li class=\"notifyIcon\"><a href='/pages/notifications.php'><B>HOME</B></a></li>";
                    }
                    elseif (isSomeoneLoggedIn('club')){

                        global $connection;
                        $userName=whoIsLoggedIn('club');
                        $query="SELECT name FROM clubs WHERE email='{$userName}'";
                        $res=mysqli_query($connection,$query);
                        validateQuery($connection,$query);
                        $row=mysqli_fetch_assoc($res);
                        $name=$row['name'];




                        echo "<li class=\"login\"><a href='/pages/logOut.php'><B>LOGOUT</B></a></li>";
                        echo"<li class=\"notifyIcon\"><a href='/pages/clubProfile.php/?name={$name}'><B>PROFILE</B></a></li>";
                    }
                    else{
                        echo"<li class=\"login\"><a href='/pages/UserLogin.php'><B>SIGN UP/LOGIN</B></a></li>";
                    }

                ?>
		    </ul>
	    </div>
    </div>
</nav>
<style>
    .navbar {
        margin-bottom: 0;
        background-color: #111;
        color: #000000;
        padding: 0% 0;
        margin-top: 0%;
        font-size: 1.1em;
        border: 0;
    }
.navbar-brand{
       position: absolute;
    }
    .navbar-inverse-2{
        color:#000000;
        background-position: center;
        background-color: #111;
    }

    .navbar-brand h1{
        float: left;
        color: #0D47A1;
        font-family: batman;
        max-height: 100px;
        margin-top: 0px;
        padding:0 0px 3px;
    }
</style>

