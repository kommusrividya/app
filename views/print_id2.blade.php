<!DOCTYPE html>
<html>
    <head>
        <title>Bulk ID generator</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            table {
                border: 1px solid red;
                border-collapse: separate;
                border-spacing: 0;
            }
            table td, table th {
                border: 1px solid yellow;
            }

            table tr td {
                border-right: 0;
            }
            table tr:last-child td {
                border-bottom: 0;
            }
            table tr td:first-child,
            table tr th:first-child {
                border-left: 0;
            }
            table tr td{
                border-top: 0;
            }
        </style>
    </head>
    <body>
            <div id="element">
                <?php $i=1; ?>
                @foreach ($members as $member)
                <?php 
                        if($i == 1) echo "<div><table style=\"border:none;\">"; 
                        if($i%2 != 0) echo "<tr>";
                ?>
                    <td>
                        <table width=354 height=206 style="color:red; background-color:yellow;">
                            <tr>
                                <td><img src="http://localhost/app/kamakshiimage.jpg" width="100" height="100" class="css-class" alt="alt text"></td>
                                <td align="center"><span style="color:red; font-size:16px;"><b><img src="http://localhost/app/memberphotos/{{ $member->id }}.jpg" width="40" height="53" class="css-class" alt="alt text"><br>MemId: {{ $member->id }} </b></span></td>
                                <td align = "right"><img src="http://localhost/app/swamiimage.jpg" width="100" height="100" class="css-class" alt="alt text"></td></tr>
                            <tr><td colspan="3" align = "center" style="font-size:16px;"><b>{{ $member->surname }} {{ $member->name }} - {{ $member->gotra }}
                            </b></td></tr>
                            <tr><td colspan="3" align = "center"><b><span style="color:red; font-size:18px;">Brahmana Sabha ( Pancha Dravida )</span><br><span style="color:red; font-size:12px;">bspd.hyd@gmail.com Hyderabad</span></b></td></tr>
                        </table>
                    </td>
                <?php 
                if($i%2 == 0) echo "</tr>";
                if($i%10 == 0) echo "</table></div><div class=\"html2pdf__page-break\"></div><div><table style=\"border:none;\">";
                $i++;
                //if($i%10 == 0) echo '<tr><td>  </td><td>  </td></tr><tr><td>  </td><td>  </td></tr><tr><td>  </td><td>  </td></tr><tr><td>  </td><td>  </td></tr><tr><td>  </td><td>  </td></tr>';
                //}
                ?>
                @endforeach
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js"></script>
    <script>
        var element = document.getElementById("element");
        html2pdf(element, {
            margin:       10,
            filename:     'myfile.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        });
    </script>
</html>
