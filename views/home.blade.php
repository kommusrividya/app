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
    <script src="assets/js/panchang.js?cachebuster=12345"></script>
    <script src="assets/js/masa_samvatsara.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
    <!--<style>
        h4 {
        color : #FF8300; 
        }  
    </style>      -->
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
    <h4>Member ID : MA{{ str_pad($_SESSION['id'],8,"0",STR_PAD_LEFT) }}</h4>
    </div>
        <div class="row">
          <div class="col-md-4">
          <h4>Web Statistics</h4>
          <h5>Users from inception:{{ $logins_count }}
          <br>Users in last month: {{ $logins_count_30days }}
          <br>Users today: {{ $logins_count_today }}
          <br>Number of members : {{ $member_count }}
          <br>Web user percentage : {{ round((($logins_count/$member_count)*100),2) }}%</h5>
          <h4>Sankalpam Details</h4>
          <span class="lh-base">
          మమ ఉపాత్త సమస్త దురితక్షయ ద్వారా శ్రీ పరమేశ్వర ముద్దిశ్య శ్రీ పరమేశ్వర
          ప్రీత్యర్ధమ్ శుభే శోభనే ముహూర్తే శ్రీ మహా విష్ణో రాజ్ఞయా ప్రవర్తమానస్య అద్య 
          బ్రహ్మణః ద్వితీయ పరార్ధే శ్వేత వరాహ కల్పే వైవస్వత మన్వంతరే కలి యుగే
          ప్రధమ పాదే జంబూ ద్వీపే భరత వర్షే భరత ఖండే మేరోర్దక్షిణ దిగ్భాగే శ్రీ శైలస్య
          వాయువ్య ప్రదేశే కృష్ణా గోదావర్యోర్మధ్య ప్రదేశే , స్వగృహే సమస్త దేవతా 
          బ్రాహ్మణ హరి హర గురు చరణ సన్నిధౌ అస్మిన్ వర్తమాన వ్యావహారిక చాంద్ర 
          మానేన స్వస్తి శ్రీ <div id=samvatsara style="display: inline-block;"></div> నామ సంవత్సరే, {{ $ayanam }}, <span id="rutu"></span> ఋతౌ, <span id=masa></span> మాసే, <div id=palkshatithi style="display: inline-block;"></div> పక్షే,
            <div id=tithi style="display: inline-block;"></div> తిధౌ, <div id='day' style="display: inline-block;"></div> వాసరే, <div id=nakshtra style="display: inline-block;"></div> నక్షత్ర, <div id=yoga style="display: inline-block;"></div> యోగ, <div id=karna style="display: inline-block;"></div> కరణ ఏవం గుణ 
           విశేషణ విశిష్ఠాయాం  శ్రీమాన్ {{ $Gotram }} సగోత్రః {{ $Name }} {{ $sarma }} నామధేయః
           {{ $Gotram }} సగోత్రస్య {{ $Name }} {{ $sarma }}  నామధేయోహమ్ ..... ఉపాసిష్యే/పూజాం కరిష్యే</span>
           <div><br>Gotram: {{ $Gotram }}<br>Nakshatram: {{ $Sankalpam }}<br>{{ $Raasi }}<br><input type="hidden" id="janmanakshatra" value="{{ $janmanakshatra }}"><input type="hidden" id="daynakshatra" value=""></div>
          </div>
      <div class="col-md-4">
        @if($Name_In_Account)
        <div class="row">
          <h4 >Payee details</h4>
          <div id = "result"></div>
        </div>

        <div>
          Name as in account: {{ $Name_In_Account }}
          <br>Account Number: {{ $Payee_Acnt_Num }}
          <br>IFSC Code: {{ $ifsc_code }}
          <br>Bank name: {{ $Bank_Name }} 
        </div>
        @endif
        <br>
        <h4>Registration Attendance History</h4>
        <table class = "table table-condensed">
          <tr><th>Date</th><th>Event</th><th>Reg</th><th>Att</th></tr>
        @foreach ($registration_details as $reg)
            <tr><td>{{ $reg->date }}</td><td>{{ $reg->event }}</td><td>{{ $reg->registered }}</td><td>{{ $reg->attended }}</td></tr>
        @endforeach
        </table>
      </div>
    
<div style="display:none">
        <div class="trow">
        <div class="alignL" >Day: </div><div id='day'></div>
        </div>
        <div class="trow">
        <div class="alignL">Tithi: </div><div id=tithi style="display: inline-block;"></div>
        </div>
        <div class="trow">
        <div class="alignL">Nakshtra: </div><div id=nakshtra style="display: inline-block;"></div>
        </div>
        <div class="trow">
        <div class="alignL">Karna: </div><div id=karna style="display: inline-block;"></div>
        </div>
        <div class="trow">
        <div class="alignL">Yoga: </div><div id=yoga style="display: inline-block;"></div>
        </div>
        <div class="trow">
        <div class="alignL">Raasi: </div><div id=raasi style="display: inline-block;"></div>
        </div>
        <div class="trow">
        <div class="alignL">Ayanam </div><div id=ayanamsa style="display: inline-block;"></div>
        </div>
        <div class="trow">
          <div class="alignL">Masa: </div><div id=masa style="display: inline-block;"></div>
        </div>
        <div class="trow">
          <div class="alignL">Samvatsara: </div><div id=samvatsara style="display: inline-block;"></div>
        </div>
        <div class="trow">
          <div class="alignL">Paksha-Tithi: </div><div id=palkshatithi style="display: inline-block;"></div>
        </div>
      </div>
    
    
    <br>
<div class="col-md-4">
        <h4>Personal details</h4>
        <div id = "result"></div>
    
    <div>{{ $email }}
        <br>Referrer name: {{ $Referrer_name }}
    </div>
    <br>
    <div  style="border:none; display: inline-block; height:150px; color:#000000; width:300px; "><!-- background-color:#FFFACD -->
        <div>Address label</div>
        {{ $Alias }} <br>
        {{ $Address1 }} <br>
        {{ $Address2 }} <br>
        {{ $city_name }},
        {{ $State }},
        {{ $Country }}, <br>
        {{ $PIN_or_ZIP }} <br>
        Phone : {{ $Phone_Num }}
    </div>
  </div>
  <table id="tarabalam" class="table table-bordered table-condensed table-responsive"><tr><th>Start Time</th><th>End time</th><th>Tarabalam</th></tr></table>
</div>
<script>
    let t = new Date();
    
    panchang.calculate(t, function () {
        document.getElementById("day").innerHTML = panchang.Day.name;
          document.getElementById("tithi").innerHTML = panchang.Tithi.name;
          document.getElementById("nakshtra").innerHTML = panchang.Nakshatra.name;
          document.getElementById("karna").innerHTML = panchang.Karna.name;
          document.getElementById("yoga").innerHTML = panchang.Yoga.name;
          document.getElementById("raasi").innerHTML = panchang.Raasi.name;
          document.getElementById("ayanamsa").innerHTML = panchang.Ayanamsa.name;
          document.getElementById("daynakshatra").value = panchang.Nakshatra.id + 1;
        
    })
    
    t= new Date();
    
    
    var table = document.getElementById("tarabalam");
    let janmacheck = document.getElementById("janmanakshatra").value;
    if(janmacheck == "") document.getElementById('tarabalam').style.visibility = "hidden";
    
    for(let i = 0; i < 7 ;i++) {
        t = new Date(t);
        // console.log(t);
        panchang.calculate(t, function () {
         let row = table.insertRow(i+1);
          
          let daynak = panchang.Nakshatra.id + 1;
          const R = "#ff6666";
          const DR = "#ff0000";
          const G = "#99e699";
          const DG = "#2eb82e";
          let tara = ['జన్మ', 'సంపత్', 'విపత్', 'క్షేమ', 'ప్రత్యక్', 'సాధన', 'నైధన', 'మిత్ర', 'పరమిత్ర'];
          // r,g,r,g,r,dg,dr,g, g
          
          let resultcolor = [R, G, R, G, R, DG, DR, G, G];
          let janma = document.getElementById("janmanakshatra").value;
          
          let daycount = 0;
          if(janma <= daynak) { daycount = (daynak - janma)+ 1; }
          else daycount = (27 - janma) + 1 + daynak;
          let paryayam = Math.ceil(daycount / 9);
          let rem = daycount % 9;
          let arraymap = (rem>=1 && rem<=8) ? rem-1 : 8;
          
          if((paryayam == 1 && rem == 1) || (paryayam == 2 && rem == 3) || (paryayam == 3 && rem == 5)) {
            console.log(paryayam);
            resultcolor[arraymap] = DR;
          }

          
            let cell = row.insertCell(0);
            cell.innerHTML = panchang.Nakshatra.start.toLocaleString();
            cell = row.insertCell(1);
            cell.innerHTML = panchang.Nakshatra.end.toLocaleString();
            cell = row.insertCell(2);
            cell.innerHTML = panchang.Nakshatra.name+" - "+tara[arraymap];
            cell.style.backgroundColor = resultcolor[arraymap];
            
            
          t = panchang.Nakshatra.end;
          t.setHours(t.getHours() + 1);
        });
    }

// document.getElementById("tarabalam").innerHTML = str;


    async function getDetails() {
        await masasamvatsara.ms_values();
        let rutu = ['వసంత', 'వసంత', 'గ్రీష్మ', 'గ్రీష్మ', 'వర్ష', 'వర్ష', 'శరత్', 'శరత్', 'హేమంత', 'హేమంత', 'శిశిర', 'శిశిర'];
        
        document.getElementById("rutu").innerHTML = rutu[masa_num];
        document.getElementById("masa").innerHTML = masasamvatsara.Masa.name;
        document.getElementById("samvatsara").innerHTML = masasamvatsara.Samvatsara.name;
        document.getElementById("palkshatithi").innerHTML = masasamvatsara.Paksha.name;
    }
    
    getDetails();
  
</script>
</body>
</html>