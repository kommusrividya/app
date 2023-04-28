<?php 
$APPDIR = dirname( dirname(__FILE__) );

define('SERVER', '43.255.154.9');
define('USERNAME', 'madhup');
define('PASSWORD', 'madhup');
define('NAME', 'bspdhyd_wp1');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(SERVER, USERNAME, PASSWORD, NAME);
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
@include('header')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{ $heading }}</title>
    
    <!-- Javascript files-->
    <!-- <script src="../assets/js/validation.js"></script> -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
          
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    
<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
    </div>
    
    <?php
        $memberid=$_SESSION['id'];
        $count=0;
        $root = $_SESSION['id'];
        $root = rootid($memberid, $link);

        function rootid($memberid, $link) {
            $sql = "SELECT Father_ID FROM BSPD_Member where MEMBER_ID = $memberid";
            $result=mysqli_query($link,$sql);
            $row = mysqli_fetch_array($result);
            $father = $row['Father_ID'];
            
            if($father != 0) return rootid($father, $link);
            else return $memberid;
        }


    ?>
    
    <h1>Family tree of <?php echo $_SESSION['name'];?></h1>

    <?php
        FamilyTree($root,$link,$count);

        function FamilyTree($memberid,$link,$count)
        {

        // ------------------------------------------------------------------------------------------//

            $query = " SELECT Alias,Spouse_ID FROM bspdhyd_wp1.BSPD_Member where MEMBER_ID =$memberid;";
            $Family=mysqli_query($link,$query);
            $row=mysqli_fetch_array($Family);

        // ------------------------------------------------------------------------------------------//

        //Printing the memberid
        echo $row["Alias"];   
        $id=$row["Spouse_ID"];

        // ------------------------------------------------------------------------------------------//
        //printing the spouse
            if($id!=0)
            {
                    echo "--";
                    $query = " SELECT Alias FROM bspdhyd_wp1.BSPD_Member where MEMBER_ID = $id;";
                    
                    $Family=mysqli_query($link,$query);
                    $row=mysqli_fetch_array($Family); 
                    echo $row["Alias"]; 
            }
        
        // ------------------------------------------------------------------------------------------//
    ?>


            <br>

    <?php
            // ------------------------------------------------------------------------------------------//

            $query = " SELECT MEMBER_ID FROM bspdhyd_wp1.BSPD_Member where (Father_ID=$memberid or Mother_ID =$memberid) order by Year_Of_Birth ;";
            $Family=mysqli_query($link,$query);
            $ROW=mysqli_num_rows($Family);

            // ------------------------------------------------------------------------------------------//

            //Calling the function with Children memID
            

            // ------------------------------------------------------------------------------------------//
            if($ROW>0)
            {
                $count=$count+1;
                while($row=mysqli_fetch_array($Family))
                {
                    for($i=0;$i<$count-1;$i++)
                        echo "|---";
                    echo "|-->";
                    $id=$row["MEMBER_ID"];
                    FamilyTree($id,$link,$count);
                }
                $count-=1;
            }

            // ------------------------------------------------------------------------------------------//

        }
    ?>
</div>

</body>
</html>