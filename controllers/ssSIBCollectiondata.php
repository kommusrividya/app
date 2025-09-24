<?php

session_start();
$APPDIR = dirname(dirname(__FILE__));
require_once "$APPDIR/ssdbconfig.php";
include "$APPDIR/vendor/autoload.php"; // load PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    UploadBulkTrn($link, $APPDIR);
}

function UploadBulkTrn($link, $APPDIR)
{
    // Upload setup

    $targetDir = "$APPDIR/NBVInfo/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    $targetDir = "$APPDIR/NBVInfo/";

    // Accept only xls or xlsx

    if (!in_array($fileType, ["xls", "xlsx"])) {
        echo "<p style='color:#C5221E'><strong> Wrong file type. Only XLS or XLSX allowed. </strong></p>";
        return;
    }

    // Remove any old files with same name
    @unlink($targetFilePath);
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        echo "<p style='color:DarkGreen'><strong>File Uploaded Successfully.</strong></p>";
    } else {
        echo "<p style='color:#C5221E'><strong>Sorry, there was an error uploading your file.</strong></p>";
        return;
    }

    // ✅ Use PhpSpreadsheet to read both XLS and XLSX
    try {
        $spreadsheet = IOFactory::load($targetFilePath);
        $sheet = $spreadsheet->getActiveSheet();

        $x = 3; // start from row 3 (your original logic)
        foreach ($sheet->getRowIterator($x) as $row) {
            $cells = [];
            foreach ($row->getCellIterator() as $cell) {
                $cells[] = trim($cell->getValue());
            }

            // Map values (match your original column mapping)
            $OrgID   = $cells[0] ?? '';
            $SlNo    = $cells[1] ?? '';
            $ID      = $cells[2] ?? '';
            $Name    = $cells[3] ?? '';
            $TrnID   = $cells[4] ?? '';
            $TrnDate = $cells[5] ?? '';
            $TrnAmt  = $cells[6] ?? '';
            $Source  = $cells[7] ?? '';

            if (empty($SlNo)) {
                continue; // skip empty rows
            }

            // Check if row exists
            $sqlquery = "SELECT * FROM BSPD_SIB_Collection_Report WHERE SLNO = '" . mysqli_real_escape_string($link, $SlNo) . "'";
            $result = mysqli_query($link, $sqlquery);
            $row = mysqli_fetch_array($result);

            if (!$row) {
                $sqlins = "INSERT INTO BSPD_SIB_Collection_Report 
                           (ORGNAME, SLNO, ID, NAME, TRANID, TRANDATE, TRANAMT, SOURCE) 
                           VALUES (
                               '" . mysqli_real_escape_string($link, $OrgID) . "',
                               '" . mysqli_real_escape_string($link, $SlNo) . "',
                               '" . mysqli_real_escape_string($link, $ID) . "',
                               '" . mysqli_real_escape_string($link, $Name) . "',
                               '" . mysqli_real_escape_string($link, $TrnID) . "',
                               '" . mysqli_real_escape_string($link, $TrnDate) . "',
                               '" . mysqli_real_escape_string($link, $TrnAmt) . "',
                               '" . mysqli_real_escape_string($link, $Source) . "'
                           )";

                if (mysqli_query($link, $sqlins)) {
                    echo "Records were inserted successfully (SLNO: $SlNo)<br>";
                } else {
                    echo "ERROR inserting SLNO $SlNo: " . mysqli_error($link) . "<br>";
                }
            } else {
                echo "Row already exists (SLNO: $SlNo)<br>";
            }
        }
    } catch (Exception $e) {
        echo 'Error reading file: ', $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Upload Statement</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css">

    
    <!-- Javascript files -->
    <!-- <script src="assets/js/validation.js"></script> -->
</head>
<body>
    
<div class="container">
    <div class="row">
        <!-- <h3>{{ $heading }}</h3> -->
        <div id = "result"></div>
    </div>
    
    <form action="uploadstatement" method="POST" enctype ="multipart/form-data">
        <div class="col-md-10 mx-auto">
            <div class="form-group row">
                <div class="col-sm-6">
                    <?php
                    
                    $sql = "SELECT max(Contribution_Date) as date FROM BSPD_Member_Contribution where Contribution_Type = 'NEFT';";
                    $query = mysqli_query($link, $sql);
                    $row = mysqli_fetch_array($query);
                    ?>
                    <label class="control-label">Last collection report uploaded was dated : <?= $row['date'] ?></label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="control-label">SIB Collections file</label>
                    <input type="file" name="file" id="sibfileinput">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <input type="submit" name="submit" id="submit" value="Upload" class = "btn btn-success">
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <a href="home" name="back" class = "btn btn-success">Back</a>
        <a href="bankstatementreview" name="review" class = "btn btn-success">Statement Review</a>
    </div>
</div>

</body>
</html>
