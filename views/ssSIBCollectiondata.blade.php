@include('header')
<?php 
$APPDIR = dirname( dirname(__FILE__) );
require_once "$APPDIR/constant.php"; 
require_once "$APPDIR/ssdbconfig.php";

if(isset($_POST['upload_statement'])) {

UploadBulkTrn($link_test);

function UploadBulkTrn($link_test)
    {       // Begin Function UploadBulkTrn
        $targetDir = "../uploads/NBVInfo/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $AcceptedType = "xls";
    //Code to ensure the file can be uploaded
        if ($fileType == $AcceptedType) {}
        Else { echo "<p style='color:#C5221E'> <strong> Wrong file Type... It should be only XLS. </strong> </p>" ;  return;}
    //Code to ensure the file can be uploaded    
        
        //echo $targetFilePath;
        $statusMsg = " ";
       //array_map('unlink', array_filter((array) glob("../uploads/NBVInfo/NBVtest.xls")));
        array_map('unlink', array_filter((array) glob(".$targetFilePath.")));

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))  
        {
            $statusMsg = "<p style='color:DarkGreen'> <strong>File Uploaded Successfully. </strong> </p>";
        } else  
        {
         
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
        echo $statusMsg;
        //upload of file completed
        //Excel data read   
        $excel = new PhpExcelReader; // creates object instance of the class
        //echo 'testing1';
        //echo $fileName;

        $excel->read($targetFilePath); // reads and stores the excel file data
        //echo 'testing2';

        // Test to see the excel data stored in $sheets property
        //echo '<pre>';
        //var_export($excel->sheets);
        //echo '</pre>';
        //echo 'testing3';
        //function sheetData($sheet) {
        function sheetData($link_test, $sheet) 
        {   // Begin sheetData function 
            $re = '<table>'; // starts html table
            $x = 3;
            while($x <= $sheet['numRows']) 
            {
            $re .= "<tr>\n";
            $y = 1;
                while($y <= $sheet['numCols']) 
                {
                $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
                $re .= " <td>$cell</td>\n"; 
                //Code added by Prasad
                if ($y == "1")  {  $OrgID = $cell ;    }
                if ($y == "2")  {  $SlNo = $cell;      }
                if ($y == "3")  {  $ID = $cell;        }
                if ($y == "4")  {  $Name = $cell;      }
                if ($y == "5")  {  $TrnID = $cell;     }
                if ($y == "6")  {  $TrnDate = $cell;   }
                if ($y == "7")  {  $TrnAmt = $cell;    }
                if ($y == "8")  {  $Source = $cell;    }

 //               echo "C" .$x. "D" .$cell;
                //Code add complete by Prasad
                $y++;
                } 
        
            $re .= "</tr>\n";
            //Code add  by Prasad
            // echo "A" .$ContributerID;   // echo "B" .$Amount;
            $sqlquery = "SELECT * FROM SBOX_SIB_Collection_Report WHERE SLNO = '" .trim($SlNo)."'";
//             echo $sqlquery;
            $result = mysqli_query($link_test, $sqlquery); 
//            echo $result;
            $row = mysqli_fetch_array($result);
//            echo $row;
            $Name1 =$row['SLNO'];
//            echo 'testing' .$Name1;
//            echo 'first' .trim($SlNo);
//            if (is_null($Name1)) 
            if ($Name1 != trim($SlNo))
            {
            $sqlins = "INSERT INTO SBOX_SIB_Collection_Report (ORGNAME, SLNO, ID, NAME, TRANID, TRANDATE, TRANAMT, SOURCE) " ."SELECT 
            '".trim($OrgID). "','" .trim($SlNo). "','" .trim($ID). "','" .trim($Name). "','" .trim($TrnID). "','" .trim($TrnDate). "'," .trim($TrnAmt). ",'" .trim($Source). "'";                     
              if(mysqli_query($link_test, $sqlins)){  echo "Records were inserted successfully" .$SlNo ; echo "<br>" ; } 
           //   if(mysqli_query($link_test, $sqlins)){ } 
              else { echo "ERROR: Could not able to execute $sqlins. " . mysqli_error($link_test); echo "<br>" ;}
            }
            else
            { echo "Row already exists" .$SlNo ;  echo "<br>" ; }
             
            
 
            //Code add complete by Prasad
            $x++;
            }

        return $re .'</table>'; // ends and returns the html table
        }  // End of sheetData function 


        $nr_sheets = count($excel->sheets); // gets the number of worksheets
        //code by Prasad
        $nr_sheets = 1 ; //Modified by Prasad to ensure only one sheet is read
        //code end by Prasad
        $excel_data = ''; // to store the the html tables with data of each sheet

        // traverses the number of sheets and sets html table with each sheet data in $excel_data
        for($i=0; $i<$nr_sheets; $i++) 
        {    // Begin  for loop for the sheets - May be we should stop with just 1 sheet?  - Madhu & Prasad
        //$excel_data .= '<h4>Sheet '. ($i + 1) .' (<em>'. $excel->boundsheets[$i]['name'] .'</em>)</h4>'. sheetData($excel->sheets[$i]) .'<br/>'; 
        $excel_data .= '<h4>Sheet '. ($i + 1) .' (<em>'. $excel->boundsheets[$i]['name'] .'</em>)</h4>'. sheetData($link_test, $excel->sheets[$i]) .'<br/>'; 
        }  // End for loop for the sheets 

        //echo $excel_data; // outputs HTML tables with excel file data

        //Excel Data read end

    }   // End Function UploadBulkTrn
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{ $heading }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">

    
    <!-- Javascript files -->
    <script src="assets/js/validation.js"></script>
</head>
<body>
    
<div class="container">
    <div class="row">
        <h3>{{ $heading }}</h3>
        <div id = "result"></div>
    </div>
    
    <form class = "form-horizontal" method="POST" id="sib_upload_form" action="" enctype ="multipart/form-data">
        <div class="col-md-10 mx-auto">
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label">Last collection report uploaded was dated : {{ $date }}</label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label">SIB Collections file</label>
                    <input type="file" name="file" id="sibfileinput">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input type="submit" name="submit" id="submit" value="Upload" class = "btn btn-success">
                </div>
            </div>
        </div>
    </form>

</div>

</body>
</html>