<?php
ob_start();
?>

<style>
    html{
        background-color: #fff;
    }
    body{
        background-color: #0099ff;
        width: auto;
    }
    .title{
        text-align: center;
        font-family: robo;
    }
    p{
        font-family: "Comic Sans MS";
    } 
    .img_logo{
        max-height: 20%;
        max-width: 100%;
        height: auto;
        width: auto;
    }
    .Snippit{
        width: 34%;
        border: 20px solid #0099ff;
        border-top: 20px solid #0099ff;
        border-bottom: 20px solid #0099ff;
        height: auto;    
        background: #222;
        text-align: center;
        position: relative;
        padding: 4%;
        color: antiquewhite;
        display: table-cell;
    }
    .row{
        margin-left: 0%;
        display: table-row;
        background: #0099ff;
        width: 100%;
        height: 93%;
        position: relative;
    }
    .scroll	{
        min-height: 67.5%;
        width: 26.5%;
        position: absolute;
        top: 162%;
        overflow: scroll;
    }
    @media screen and (max-width: 800px){
        .Snippit{
            display: block;
            width: 100%;
        }
        .row{
            display: table-row;
        }
        #logo{
            margin-top: 8%;
        }
    }
</style>

<?php

function redirect($location){

    header('Location:'.$location);
    die();
}

function validateImage($flag){
    $allowedFormats=array("jpg","png","jpeg");
    $errors=[];
    $fileName=$_FILES[$flag]['name'];
    echo $fileName;
    echo $flag;
    $fileExtension=strtolower(end(explode(".",$fileName)));
    if(!in_array($fileExtension,$allowedFormats)){
        array_push($errors,"Invalid File Extension.");
    }else if($_FILES[$flag]['size']>500000) {
        array_push($errors, "Image Size is too big.");
    }
    return $errors;
}

function validateQuery($connection,$query){
    if(mysqli_errno($connection)){
        echo mysqli_error($connection).'  ';
        echo $query;
        Die("There was some sort of problem with Connection. We are working on it.");

    }

}

function validateClubLogin(){
    global $connection;
    $email= mysqli_real_escape_string($connection,$_POST['email']);
    $pwd=md5($_POST['password']);
    $i=0;
    $errors=[];

    $query="SELECT password FROM clubs WHERE email='{$email}'";
    $res=mysqli_query($connection,$query);
    validateQuery($connection,$query);
    $row=mysqli_fetch_assoc($res);
    $dbpwd=$row['password'];
    if($pwd==$dbpwd){
        return 1;
    }else{
        array_push($errors,'Invalid Credentials');
        return $errors;
    }
}

function recRegister(){
    global $connection;

    $recName=mysqli_real_escape_string($connection,$_POST['clubName']);
    $recDocs=mysqli_real_escape_string($connection,$_POST['recDocs']);
    $briefDesc=mysqli_real_escape_string($connection,$_POST['briefDesc']);
    $recDate=mysqli_real_escape_string($connection,$_POST['recDate']);
    $recTime=mysqli_real_escape_string($connection,$_POST['recTime']);
    $contactNumber=mysqli_real_escape_string($connection,$_POST['contactNo']);
    $venue=mysqli_real_escape_string($connection,$_POST['recVenue']);
    $recForm=mysqli_real_escape_string($connection,$_POST['recForm']);

    $errors=validateImage("recLogo");
    if(count($errors)!=0)
        return $errors;
    $imageName= $_FILES['recLogo']['name'];
    $fileExtension=end(explode(".",$imageName));
    $newName=md5(rand().time().$imageName). '.' .$fileExtension;
    $target="../images/recLogos/".$newName;
    if(!move_uploaded_file($_FILES["recLogo"]["tmp_name"],$target)){

        array_push($errors,"Error Copying recLogo.");
        return $errors;
    }
    $query="INSERT INTO recruits (name, completeDetail, imageLogo, date, time, contactNumber, requiredDocs, venue, formLink) ";
    $query.=" VALUES ('{$recName}', '{$briefDesc}', '{$newName}', '{$recDate}', '{$recTime}', '{$contactNumber}', '{$recDocs}', '{$venue}','{$recForm}')";
    mysqli_query($connection,$query);
    validateQuery($connection,$query);
     if(isset($_POST['emailNotifyTrigger'])&&$_POST['emailNotifyTrigger']=='on'){
        $subject="Recruitments for  {$recName}";
        $body="Hello, We are here to inform you about an upcoming recruitment from {$recName}\n
             Brief :: {$briefDesc}\n
             Requirements:: {$recDocs} \n
             Schedule:: {$recDate} , {$recTime} at {$venue}\n
       
      "  ;

        $query="SELECT email from users WHERE MATCH (followedClubs) AGAINST ('{$recName}' IN BOOLEAN MODE)";
        validateQuery($connection,$query);
        $res=mysqli_query($connection,$query);
        require_once ("sendMail.php");
        while($row=mysqli_fetch_assoc($res)){
            sendMail($row['email'],$body,$subject);
        }

    }

    return $errors;
}

function eventRegister(){
    global $connection;

    $eventName=mysqli_real_escape_string($connection,$_POST['eventName']);
    $eventTagline=mysqli_real_escape_string($connection,$_POST['eventTagline']);
    $briefDesc=mysqli_real_escape_string($connection,$_POST['briefDesc']);
    $eventDate=mysqli_real_escape_string($connection,$_POST['eventDate']);
    $eventTime=mysqli_real_escape_string($connection,$_POST['eventTime']);
    $contactNumber=mysqli_real_escape_string($connection,$_POST['contactNo']);
    $regFee=mysqli_real_escape_string($connection,$_POST['regisFee']);
    $clubHosting=mysqli_real_escape_string($connection,$_POST['clubName']);
    $venue=mysqli_real_escape_string($connection,$_POST['eventVenue']);

    $errors=validateImage("eventLogo");
    if(count($errors)!=0)
        return $errors;
    $imageName= $_FILES['eventLogo']['name'];
    $fileExtension=end(explode(".",$imageName));
    $newName=md5(rand().time().$imageName). '.' .$fileExtension;
    $target="../images/eventLogos/".$newName;
    if(!move_uploaded_file($_FILES["eventLogo"]["tmp_name"],$target))
        array_push($errors,"Error Copying eventLogo.");
    $query="INSERT INTO events (name, tagline, completeDetail, imageLogo, date, time, contactNumber, regFee, clubHosting, venue) ";
    $query.=" VALUES ('{$eventName}', '{$eventTagline}', '{$briefDesc}', '{$newName}', '{$eventDate}', '{$eventTime}', '{$contactNumber}', '{$regFee}', '{$clubHosting}', '{$venue}')";
    mysqli_query($connection,$query);
    validateQuery($connection,$query);
    if(isset($_POST['emailNotifyTrigger'])&&$_POST['emailNotifyTrigger']=='on'){
      $subject="New Event From {$clubHosting}";
        $body="Hello, We are here to inform you about an upcoming event from {$clubHosting}\n
             Event Name :: {$eventName}\n
             Brief :: {$eventTagline}\n
             Schedule:: {$eventDate} , {$eventTime} at {$venue}\n
             Fee:: {$regFee}\n
      "  ;

      $query="SELECT email from users WHERE MATCH (followedClubs) AGAINST ('{$clubHosting}' IN BOOLEAN MODE)";
      echo $query;
      validateQuery($connection,$query);
      $res=mysqli_query($connection,$query);
      require_once ("sendMail.php");
      while($row=mysqli_fetch_assoc($res)){
          sendMail($row['email'],$body,$subject);
      }

    }
    return $errors;
}


function validateLogin(){
    //will return array of errors;

    global $connection;
    $userName= mysqli_real_escape_string($connection,$_POST['userName']);
    $pwd=md5($_POST['password']);
    $i=0;
    $errors=[];


    //Check if the userId is in userTemp database i.e. it's an unverified id

    $query="SELECT pwd FROM usersTemp WHERE userName= '{$userName}'";
    //$preparedStatement=mysqli_prepare($connection,$query);
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    $dbpwd=$res['pwd'];
    if(!trim($dbpwd)=='')
        $errors[$i++]="Your Id has not been verified yet. Check your mail and SMS.";
    //if pwd for userid is found it's unverified status...



    $query="SELECT pwd FROM users WHERE userName= '{$userName}'";
    //$preparedStatement=mysqli_prepare($connection,$query);
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    $dbpwd=$res['pwd'];
    if(trim($dbpwd)=='') {
        $errors[$i++] = "It seems like you have not signedUp yet";
        return $errors;
    }
    if(($dbpwd==$pwd)){
        return 1;
    }

    $errors[$i++]="Password Entered Didn't match";
    return $errors;
}

function validateSignUp(){
    //return 1 on succesful signup;
    //returns the array of errors;

    global $connection;
    $i=0;
    $errors=[];

    $name= mysqli_real_escape_string($connection,$_POST['name']);
    $email= mysqli_real_escape_string($connection,$_POST['email']);
    $contactNumber= mysqli_real_escape_string($connection,$_POST['contactNumber']);
    $gender= mysqli_real_escape_string($connection,$_POST['formGender']);
    $pwd=md5($_POST['pwd1']);

    //check if username has been used;
    $userName= mysqli_real_escape_string($connection,$_POST['userName']);
    $query="SELECT * FROM users WHERE userName= '{$userName}'";
    //$preparedStatement=mysqli_prepare($connection,$query);
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    if(!(trim($res['userName']==''))){
        $errors[$i++]="UserName is already in use.";
    }
    $query="SELECT * FROM usersTemp WHERE userName= '{$userName}'";
    //$preparedStatement=mysqli_prepare($connection,$query);
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    if(!(trim($res['userName']==''))){
        $errors[$i++]="UserName is already in use.";
    }



    //check if email has already been used;

    $query="SELECT * FROM users WHERE email= '{$email}'";
    //$preparedStatement=mysqli_prepare($connection,$query);
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    if(!trim(($res['userName']==''))){
        $errors[$i++]="Email is already in use.";
    }

    $query="SELECT * FROM usersTemp WHERE email= '{$email}'";
    //$preparedStatement=mysqli_prepare($connection,$query);
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    if(!trim(($res['userName']==''))){
        $errors[$i++]="Email is already in use.";
    }

    //Checks if number has already been used;

    $query="SELECT * FROM users WHERE contactNumber= '{$contactNumber}'";
    //$preparedStatement=mysqli_prepare($connection,$query);
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    if(!($res['userName']=='')){
        $errors[$i++]="Phone Number is already in use.";
    }
    $query="SELECT * FROM usersTemp WHERE contactNumber= '{$contactNumber}'";
    //$preparedStatement=mysqli_prepare($connection,$query);
    $res=mysqli_query($connection,$query);
    $res=mysqli_fetch_assoc($res);
    if(!($res['userName']=='')){
        $errors[$i++]="Phone Number is already in use.";
    }


    //Lastly if both the passwords don't match;
    //We will also use js to assure it in browser only
    if($_POST['pwd1']!=$_POST['pwd2']){
        $errors[$i++]="Two Passwords entered don't match.";
    }
    if($i>0)
        return $errors;
    $OTP=rand(1000,10000);
    $verifyURL=md5(rand());

    $body = " Hello {$name}.  Welcome To ClubStack. You are just single step away from joining Us.\n
    Visit the URL below and enter the OTP sent through SMS to activate your account.\n
    https://clubstack.000webhostapp.com/pages/verifyOTP.php?key={$verifyURL}\n
    Ignore if didn't signUp.
    ";
    require_once ('sendMail.php');
    $mailSub = "Verification Of ClubStack ID";
    sendMail($email,$body,$mailSub);
    require_once ("sendSMS.php");
    $message = "OTP for your clubStack Account is {$OTP}. Enter it when asked on visiting link mailed to you.\n\n\n";
    sendSMS($message,$contactNumber);
    $query="INSERT INTO userstemp (name,userName,pwd,email,contactNumber,OTP,verifyURL,gender) ";
    $query.=" VALUES('{$name}','{$userName}','{$pwd}','{$email}','{$contactNumber}','{$OTP}','{$verifyURL}','{$gender}')";
    mysqli_query($connection,$query);

    return 1;

}

function clubRegister(){
    global $connection;

    $clubName=mysqli_real_escape_string($connection,$_POST['clubName']);
    $clubMotto=mysqli_real_escape_string($connection,$_POST['clubMotto']);
    $presidentName=mysqli_real_escape_string($connection,$_POST['presidentName']);
    $clubFields=mysqli_real_escape_string($connection,$_POST['clubFields']);
    $clubLinks=mysqli_real_escape_string($connection,$_POST['clubLinks']);
    $contactNumber=mysqli_real_escape_string($connection,$_POST['contactNumber']);
    $clubEmail=mysqli_real_escape_string($connection,$_POST['clubEmail']);
    $password=mysqli_real_escape_string($connection,$_POST['password']);
    $password=md5($password);
    $errors=validateImage("clubLogo");
    if(count($errors)!=0)
        return $errors;
    $imageName= $_FILES['clubLogo']['name'];
    $fileExtension=end(explode(".",$imageName));
    $newName=md5(rand().time().$imageName). '.' .$fileExtension;
    $target="../images/clubLogos/".$newName;
    if(!move_uploaded_file($_FILES["clubLogo"]["tmp_name"],$target)){
        array_push($errors,"Error Copying ClubLogo.");
        return $errors;
    }
    $query="INSERT INTO clubs (name, tagline, president, fields, websiteLink, imageLogo, contactNumber, email, password) ";
    $query.=" VALUES ('{$clubName}', '{$clubMotto}', '{$presidentName}', '{$clubFields}', '{$clubLinks}', '{$newName}', '{$contactNumber}', '{$clubEmail}', '{$password}')";
    mysqli_query($connection,$query);
    validateQuery($connection,$query);
    return $errors;
}


function clubUpdate(){
    global $connection;
    $errors=[];
    $clubName=mysqli_real_escape_string($connection,$_POST['clubName']);
    $clubMotto=mysqli_real_escape_string($connection,$_POST['clubMotto']);
    $presidentName=mysqli_real_escape_string($connection,$_POST['presidentName']);
    $clubFields=mysqli_real_escape_string($connection,$_POST['clubFields']);
    $clubLinks=mysqli_real_escape_string($connection,$_POST['clubLinks']);
    $contactNumber=mysqli_real_escape_string($connection,$_POST['contactNumber']);

   if(isset($_POST['imageChange']) && $_POST['imageChange'] == 'on'){
        $errors=validateImage("clubLogo");
        if(count($errors)!=0)
            return $errors;
        $imageName= $_FILES['clubLogo']['name'];
        $fileExtension=end(explode(".",$imageName));
        $newName=md5(rand().time().$imageName). '.' .$fileExtension;
        $target="../images/clubLogos/".$newName;
        if(!move_uploaded_file($_FILES["clubLogo"]["tmp_name"],$target)){
            array_push($errors,"Error Copying ClubLogo.");
            return $errors;
        }
   }
    $oldEmail=whoIsLoggedIn('club');
    $query="UPDATE clubs SET name='{$clubName}', tagline='{$clubMotto}', president='{$presidentName}', fields='{$clubFields}', websiteLink='{$clubLinks}',";

    if(isset($_POST['imageChange']) && $_POST['imageChange'] == 'on')
        $query.=" imageLogo='{$newName}',";
    $query.="contactNumber='{$contactNumber}' WHERE email='{$oldEmail}'  LIMIT 1 ";
    mysqli_query($connection,$query);
    validateQuery($connection,$query);
    return $errors;
}


function displayErrors($errors){
    $len=count($errors);
    for($i=0;$i<$len;$i++)
        echo"<div class='alert alert-danger'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        <p class=\"errorMsg\">{$errors[$i]}</p>
        </div>";
}


function followUnfollowClub(){
    global $connection;
    $userName=whoIsLoggedIn('user');


    if(isset($_POST['follow'])){
        $query="SELECT followedClubs FROM users where userName='{$userName}'";
        $res=mysqli_query($connection,$query);

        validateQuery($connection,$query);
        $row=mysqli_fetch_assoc($res);
        $clubs=explode(' ',$row['followedClubs']);
        array_push($clubs,$_POST['name']);
        $clubs=implode(' ',$clubs);
        $query="UPDATE users SET followedClubs='{$clubs}' WHERE userName='{$userName}'";
        mysqli_query($connection,$query);
        validateQuery($connection,$query);

        $query="UPDATE clubs SET followersCount=followersCount+1 WHERE name='{$_POST['name']}'";
        mysqli_query($connection,$query);
        validateQuery($connection,$query);

    }else if(isset($_POST['unfollow'])){
        $query="SELECT followedClubs FROM users where userName='{$userName}'";
        $res=mysqli_query($connection,$query);
        validateQuery($connection,$query);
        $row=mysqli_fetch_assoc($res);
        $clubs=explode(' ',$row['followedClubs']);
        $name=[];
        array_push($name,$_POST['name']);
        print_r($name);
        $clubs=array_diff($clubs,$name);
        $clubs=implode(' ',$clubs);
        $query="UPDATE users SET followedClubs='{$clubs}' WHERE userName='{$userName}'";
        mysqli_query($connection,$query);
        validateQuery($connection,$query);
        $query="UPDATE clubs SET followersCount=followersCount-1 WHERE name='{$_POST['name']}'";
        mysqli_query($connection,$query);
        validateQuery($connection,$query);
    }
}


function goingEvents(){
    global $connection;
    $userName=whoIsLoggedIn('user');


    if(isset($_POST['going'])){
        $query="SELECT goingEvents FROM users where userName='{$userName}'";
        $res=mysqli_query($connection,$query);

        validateQuery($connection,$query);
        $row=mysqli_fetch_assoc($res);
        $events=explode(',',$row['goingEvents']);
        array_push($events,$_POST['id']);
        $events=implode(',',$events);
        $query="UPDATE users SET goingEvents='{$events}' WHERE userName='{$userName}'";
        mysqli_query($connection,$query);
        validateQuery($connection,$query);

        $query="UPDATE events SET visitorsCount=visitorsCount+1 WHERE id='{$_POST['id']}'";
        mysqli_query($connection,$query);
        validateQuery($connection,$query);

    }else if(isset($_POST['notGoing'])){
        $query="SELECT goingEvents FROM users where userName='{$userName}'";
        $res=mysqli_query($connection,$query);
        validateQuery($connection,$query);
        $row=mysqli_fetch_assoc($res);
        $events=explode(',',$row['goingEvents']);
        $id=[];
        array_push($id,$_POST['id']);
        $events=array_diff($events,$id);
        $events=implode(',',$events);
        $query="UPDATE users SET goingEvents='{$events}' WHERE userName='{$userName}'";
        mysqli_query($connection,$query);
        validateQuery($connection,$query);
        $query="UPDATE events SET visitorsCount=visitorsCount-1 WHERE id='{$_POST['id']}'";
        mysqli_query($connection,$query);
        validateQuery($connection,$query);
    }
}

function echoClubSnippit($res){
    if(isSomeoneLoggedIn('user')) {
        followUnfollowClub();
        //to get the list of clubs one is following and output follow unfollow code accordingly
        global $connection;
        $userName=whoIsLoggedIn('user');

        $query = "SELECT followedClubs FROM users where userName='{$userName}'";
        $resTemp = mysqli_query($connection, $query);
        validateQuery($connection, $query);
        $rowTemp = mysqli_fetch_assoc($resTemp);
        $followedClubs = explode(' ', $rowTemp['followedClubs']);
    }
    $i=0;

    echo "<table>";
    while($row=mysqli_fetch_assoc($res)) {
        $clubName = $row['name'];
        $clubsMotto = $row['tagline'];
        $presidentName = $row['president'];
        $fields = $row['fields'];
        $websiteLink = $row['websiteLink'];
        $imageLogo = "/images/clubLogos/" . $row['imageLogo'];
        $contactNumber = $row['contactNumber'];
        $email = $row['email'];


        if (($i % 3 == 0) && ($i > 0)) {
            echo "</tr>";
        }
        if ($i % 3 == 0) {
            echo "<tr class='row'>";
        }
        $snippit = "<td class='Snippit'>
                <div id='snippitTop'>
                     <div id='logo'><img class='img_logo img-thumbnail' src='{$imageLogo}'></div>
                </div>
                <div id='snippitBottom'>
                     <h2 class='title'>
                         <a href='/pages/clubProfile.php/?name={$clubName}'> {$clubName}</a>
                     </h2>
                     <p> {$clubsMotto} </p>
                     <p class='clubFielf'>Fields : {$fields}</p>
                     <p class='presidentName'>Leader : {$presidentName}</p>
                     <p class='clubEmail'>Mail : {$email}</p>";
        if (isSomeoneLoggedIn('user')) {
            $snippit .= "<p>";
            $snippit .= "<form action='' method='post'>";
            $snippit .= "<input type='text' value='${clubName}' name='name' hidden>";

            if (in_array($clubName, $followedClubs)) {
                $snippit .= "<input type='submit' value='Unfollow' name='unfollow'>";
            } else {
                $snippit .= "<input type='submit' value='Follow' name='follow'>";
            }

            $snippit .= "</form>";
            $snippit .= "</p>";


        }


        $snippit .= "            
                     </td>
                </div>";
        echo $snippit;
        $i++;
    }
    echo "</tr>";
    echo "</table>";
}

function echoEventSnippit($res){

    if(isSomeoneLoggedIn('user')) {
        goingEvents();
        //to get the list of events one is going to and output follow unfollow code accordingly
        global $connection;
        $userName=whoIsLoggedIn('user');

        $query = "SELECT goingEvents FROM users where userName='{$userName}'";
        $resTemp = mysqli_query($connection, $query);
        validateQuery($connection, $query);
        $rowTemp = mysqli_fetch_assoc($resTemp);
        $goingEvents = explode(',', $rowTemp['goingEvents']);
    }

    $i=0;

    echo "<table>";
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

        if(($i%3==0)&&($i>0)){
            echo "</tr>";
        }
        if($i%3==0){
            echo "<tr class='row'>";
        }
        $snippit="<td class='Snippit'>
                <div id='snippitTop'>
                     <div id='logo'><img class='img_logo img-thumbnail' src='{$imageLogo}'></div>
                </div>
                <div id='snippitBottom'>
                     <h2 class='title'><a href='/pages/eventDetail.php/?id={$eventID}'>{$eventName}</a></h2>
                     <p> {$eventTagline} </p>
                     <p>Hosted By : {$clubHosting}</p>
                     <p>Regestration Fee : {$regFee}</p>
                     <p>At {$eventVenue} at {$eventTime} {$eventDate}</p>
                     <p>Contact : {$contactNumber}</p>
                   ";

        if (isSomeoneLoggedIn('user')) {
            $snippit .= "<p>";
            $snippit .= "<form action='' method='post'>";
            $snippit .= "<input type='text' value='{$eventID}' name='id' hidden>";

            if (in_array($eventID, $goingEvents)) {
                $snippit .= "<input type='submit' value='Not Interested?' name='notGoing'>";
            } else {
                $snippit .= "<input type='submit' value='Interested?' name='going'>";
            }

            $snippit .= "</form>";
            $snippit .= "</p>";


        }


        $snippit.="
                 </td>
                </div>";
        echo $snippit;
        $i++;
    }
    echo "</tr>";
    echo "</table>";
}

function echoRecSnippit($res){

    $i=0;

    echo "<table>";
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
        $recForm=$row['formLink'];

        if(($i%3==0)&&($i>0)){
            echo "</tr>";
        }
        if($i%3==0){
            echo "<tr class='row'>";
        }
        $snippit="<td class='Snippit'>
                <div id='snippitTop'>
                     <div id='logo'><img class='img_logo img-thumbnail' src='{$imageLogo}'></div>
                </div>
                <div id='snippitBottom'>
                     <h2 class='title'><a href='/pages/recruitDetail.php/?id={$id}'>{$recName}</a></h2>
                     <p> {$briefDesc} </p>
                     <p> Required Documents : {$recDocs}</p>
                     <p> On {$recDate} At {$recVenue} @ {$recTime}</p>
                     <p> Online Form Link : <a href='{$recForm}'></a></p>
                     <p>Contact : {$contactNumber}</p>
                     </td>
                </div>";
        echo $snippit;
        $i++;
    }
    echo "</tr>";
    echo "</table>";
}

function login($userName,$flag)
{
    if ($flag == 'user') {
        if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
         setcookie('userName', $userName, time() + 60 * 60 * 24 * 3, '/', "www.000webhostapp.com", null, true);
        }
        $_SESSION['userName'] = $userName;
        redirect('/pages/notifications.php');
    }elseif ($flag=='club'){
        global  $connection;
        $query="SELECT name FROM clubs WHERE email='{$userName}'";
        $res=mysqli_query($connection,$query);
        validateQuery($connection,$query);
        $row=mysqli_fetch_assoc($res);
        $name=$row['name'];
        if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
            setcookie('email', $userName, time() + 60 * 60 * 24 * 3, '/', "www.000webhostapp.com", null, true);
        }
        $_SESSION['email'] = $userName;
        redirect('/pages/clubProfile.php/?name='.$name);
    }

}

function logOut($flag){
    if ($flag == 'user') {
        unset($_COOKIE['userName']);
        setcookie('userName', '', time() - 60 * 60 * 24 * 3, '/', "www.000webhostapp.com", null, true);
        session_unset();
        redirect("https://clubstack.000webhostapp.com/");
    }
    elseif ($flag=='club'){
        unset($_COOKIE['email']);
        setcookie('email', '', time() - 60 * 60 * 24 * 3, '/', "www.000webhostapp.com", null, true);
        session_unset();
        redirect("https://clubstack.000webhostapp.com/");
    }
}

function isSomeoneLoggedIn($flag){
   if($flag=='user'){
       if(isset($_SESSION['userName'])||isset($_COOKIE['userName'])){
            return 1;
        }else
            return 0;
   } elseif ($flag=='club'){
       if(isset($_SESSION['email'])||isset($_COOKIE['email'])){
           return 1;
       }else
           return 0;
   }
}

function whoIsLoggedIn($flag){
    if($flag=='user'){
        if(isset($_COOKIE['userName'])){
            return $_COOKIE['userName'];
        }else return $_SESSION['userName'];
    }elseif ($flag=='club'){
        if(isset($_COOKIE['email'])){
            return $_COOKIE['email'];
        }else return $_SESSION['email'];
    }
    return 0;
}

?>