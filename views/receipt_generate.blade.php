<?php 
$APPDIR = dirname( dirname(__FILE__) );
require_once "$APPDIR/constant.php"; 
require_once "$APPDIR/ssdbconfig.php"
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
          
   <!-- Javascript files -->
   <script src="assets/js/validation.js"></script>
   <style>
    table {
        border: 1px solid blue;
        border-width: 2px;
        color: blue;
        font-size:20px;
        LINE-HEIGHT:25px;
        width: 20%;

    }
    td {
        padding:10px;
    }
    	.blink{
		width:200px;
		height: 50px;
	    background-color: yellow;
		padding: 15px;	
		text-align: center;
		line-height: 50px;
	}
	span{
		font-size: 25px;
		color: red;
		animation: blink 1s linear infinite;
	}
    @keyframes blink{
    0%{opacity: 0;}
    50%{opacity: .5;}
    100%{opacity: 1;}
    }
</style>
</head>
<body>
<span class="blink">MOBILE RENDERING IS INACCURATE. PLEASE WATCH/DOWNLOAD FROM COMPUTER</span>
<div id="rcontainer" class="container">

    <div class="row">
        <table cellpadding="15">
            <tr>
                <td colspan="2"><img src="./receiptimage.jpg" width="675" height="162" class="css-class" alt="alt text"></td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="padding:5px; font-family: monospace, monospace;">RECEIPT</td>
            </tr>
            <tr>
                <td style="padding-top:0px; font-family: monospace, monospace;">Receipt No: {{ $receipt->no }}</td>
                <td style="padding-top:0px; font-family: monospace, monospace;" align="right">Date: {{ $receipt->recpt_date }}</td>
            </tr>
            <tr>
            <!-- style="text-align: justify; text-justify: inter-word;" -->
                <td  colspan="2" style="font-family: monospace, monospace; font-size:16px;">
                    <?php
                    $i = 0; 
                    for($i = 0; $i < $lines ;$i++)
                    {
                        if($i == ($lines-1)) echo $str[$i];
                        else echo $str[$i]."<br>";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="font-size:10px; padding:0px font-family: monospace, monospace;">This is a computer generated receipt. Hence, no signature is required.</td>
            </tr>
        </table>
    </div>
</div>
<div class="container">
<br>
<a type="button" class="btn btn-primary" href="#" onclick="getpdf();">Download PDF</a>
</div>
<script>
    function getpdf(){
        var element = document.getElementById('rcontainer');
        //html2pdf(element);
        var opt = {
            margin:       0.45,
            filename:     '{{ $receipt->event_id }} Receipt {{ $receipt->no }}  Member  {{ $receipt->member_id }} {{ $receipt->name }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a5', orientation: 'landscape' }
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();

        // Old monolithic-style usage:
        //html2pdf(element, opt);
    }
</script>
</body>
</html>