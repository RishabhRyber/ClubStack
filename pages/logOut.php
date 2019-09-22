<?php
session_start();
require_once ("../includesPHP/functions.php");
if(isSomeoneLoggedIn('user')){
    logOut('user');
}
elseif (isSomeoneLoggedIn('club')){
    logOut('club');
}else
    redirect('userLogin.php');
?>