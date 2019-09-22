<?php
  session_start();
  require_once ("../includesPHP/database.php");
  require_once ("../includesPHP/functions.php");
  ob_start();
  if(isSomeoneLoggedIn('user')||isSomeoneLoggedIn('club')){
      redirect('/');
  }
?>
<html>
  <head>
      <?php
    require_once ('../includesPHP/cssIncludes.php');
    ?>
      <title>Login or Register</title>
    <style>
        #login{
            display: none;
        }
        #signup{
            display: block;
        }
        html, body {
            width: 100%;
            height: 100%;
            color: #444;
            font-family: "Helvetica Neue", Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;    
            background: #66add6;
            background-size: cover;
        }
        .container{
            left: 0%;
            position: relative;
            width: 697.5px;
            height: auto;
            background: #fff;
            border: 5px solid #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
            opacity: 1;
            margin-top: -5.4%;
        } 
        form{
            margin: 0 auto;
            margin-top: 20px;
            display: table;
        }
        label{
            color: #555;
            display: inline-block;
            margin-left: 18px;
            padding-top: 10px;
            font-size: 20px;
            font-weight: 600;
        }
        #logged_in{
            font-weight: 300;
            font-size: 15px;
            margin-left: 5px;
        }
        #lower {
            background: #ecf2f5;
            width: 100%;
            height: 69px;
            margin-top: 20px;
        }
        select{
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
        input[type=text],input[type=password],input[type=email] {
            color: #777;
            padding-left: 10px;
            margin: 10px;
            margin-top: 10px;
            margin-left: 50px;
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
        input[type=checkbox]{
            margin-left: 20px;
            margin-top: 10px;
            height: 15px;
            width: 50px;
        }
        input[type=submit]{
            margin-right: 33px;
            margin-top: 20px;
            margin-bottom: 20px;
            float: right;
            width: 150px;
            height: 40px;
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
        .form1{
            background: rgba(19, 35, 47, 0.9);
            border-radius: 4px;
            box-shadow: 0 4px 10px 4px rgba(19, 35, 47, 0.3);
            height: auto;
            width: 720px;
            margin: auto;
            padding-bottom: 1%;
        }
        .tab-group {
          list-style: none;
          padding: 0;
          margin: 0 0 40px 0;
          padding-left: 0%;
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
          font-size: 20px;
          width: 150%;
          text-align: center;
          cursor: pointer;
          transition: .5s ease;
        }
        .tab-group li a:hover {
          background: #4d4dff;
          color: #ffffff;
        }
        .tab-group .active a {
          background: #4d4dff;
          color: #ffffff;
        }
        #btn_sign{
            float: left;
            width: 230px;
            margin-left: 1.5%;
        }
        #btn_login{
            float: left;
            margin-left: 13%;
            width: 230px;
        }
        .tab-content > div:last-child {
          display: none;
        }
        h3{
            font-family: intro;
        }
    </style>

  </head>
  <body oncontextmenu="return false">
   <?php
    require_once ("../includesPHP/navbar.php");
   ?>
    <div class="form1">
    <ul class="tab-group">
        <li class="tab-0 active" id="btn_sign"><a href="#signup"><h3>Sign Up</h3></a></li>
        <li class="tab-1" id="btn_login"><a href="#login"><h3>Log In</h3></a></li>
    </ul>  
  <div class="container">

      <div id="login">
      <?php
        if (isset($_POST['submitLogin'])&&!isset($_POST['club'])) {
            $errors = validateLogin();
            if ($errors === 1){
                login($_POST['userName'],'user');
                $loginMsg = "Successful";
            }
            else displayErrors($errors);
        }
        else if(isset($_POST['submitLogin'])&&isset($_POST['club'])&&$_POST['club']=='on'){
            $errors = validateClubLogin();
            if($errors === 1){
                login($_POST['email'],'club');
                $loginMsg = "Successful";
            }else
                displayErrors($errors);
        }
      ?>
          <script>
              //To Auto respond form for clubs login
              function userNameSwitch(){
                  var checkBox = document.getElementById("clubBox");
                  if(checkBox.checked === true){
                      document.getElementById('name').innerText='Email:';
                      document.getElementById('username').name='email';
                  }else {
                      document.getElementById('username').name='userName';
                      document.getElementById('name').innerText = 'Username:';
                  }
              };


          </script>
      <form action="" method="post">
          <table>
            <tr>
                <td>
                    <input type="checkbox" name="club" onclick="userNameSwitch()" id="clubBox"><label for="checkbox" >Login As a club</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="username" id="name">Username:</label>
                </td>
                <td>
                <input type="text" id="username" name="userName">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Password:</label>
                </td>
                <td>
                    <input type="password" id="password" name="password" required>
                </td>
            </tr>
            <tr>
                <div id="lower">
                <td>
                    <input type="checkbox" name="rememberMe"><label for="checkbox" id="logged_in">Keep me logged in!</label>
                </td>
                <td>
                    <input type="submit" name="submitLogin" value="Login">
                </td>
                </div>
            </tr>
          </table>
      </form>
    </div>
    <div id="signup">
    <?php
      if(isset($_POST['submitSignUp'])){
          $errors = validateSignUp();
            if ($errors === 1)
                $loginMsg = "SignUp Successful";
            else displayErrors($errors);
        }
      ?>
      <form action="" method="post">
          <table>
              <tr>
                  <td>
                  <label>Name :</label>
                  </td>
                  <td>
                      <input type="text" name="name" required>
                  </td>
              </tr>
              <tr>
                  <td>
                  <label>Email :</label>
                  </td>
                  <td>
                      <input type="email" name="email" required>
                  </td>
              </tr>
              <tr>
                  <td>
                  <label>Username (Must be Unique) :</label>
                  </td>
                  <td>
                      <input type="text" name="userName" required>
                  </td>
              </tr>
              <tr>
                  <td>
                    <label>Password :</label>
                  </td>
                  <td>
                      <input type="password" name="pwd1" required>
                  </td>
              </tr>
              <tr>
                  <td>
                      <label>Confirm Password :</label>
                  </td>
                  <td>
                      <input type="password" name="pwd2" required>
                  </td>
              </tr>
              <tr>
                  <td>
                      <label>Gender :</label>
                  </td>
                  <td>
                      <select name="formGender">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                      </select>
                  </td>
              </tr>
              <tr>
                  <td>
                      <label>Contact Number :</label>
                  </td>
                  <td>
                      <input type="number" name="contactNumber" required>
                  </td>
              </tr>
              <tr>
                  <td></td>
                  <td>
                    <input type="submit" name="submitSignUp" value="Submit">
                  </td>
              </tr>
          </table>
      </form>
    </div>
    </div>
  </body>
    <script type="text/javascript" src="/js/login.js"></script>
</html>