<?php
if(time() - $_SESSION['login_time'] > 1800)
    {
        header("Location:controllers/ssLogout.php");
    }
$check=$_SESSION['login'];
if($check !='true')
{
 header("Location:controllers/ssLogout.php"); 
}
//unset($_SESSION['login']);
?>