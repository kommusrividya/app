<?php
    session_start();
   session_unset();
   
   echo 'You have cleaned session';
   header('Refresh: 1; URL = http://www.bspd.in/app');
//     header('Refresh: 2; URL = SelfService/ssLogin.php');
?>