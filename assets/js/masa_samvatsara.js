rad = 180 / Math.PI;
back_clong_ahar = -1;
back_nclong_ahar = -1;
back_clong = -1;
back_nclong = -1;
epsiron = 1e-8;
eps = 1e-6;

purnimanta = false;

var YCD = 1582237828 - 4320000;
var places = new Array();
var GREGORIAN_EPOCH = 1721425.5;
var minutes = 1000 * 60; //Milliseconds
var hours = minutes * 60; //Milliseconds
var day = hours * 24; //Milliseconds
TimeZoneOffset = 5.5;
var planets = new Array();
planets[3] = new planet(
  "Mercury",
  0,
  new Array(48.3313, 3.24587e-5),
  new Array(7.0047, 5.0e-8),
  new Array(29.1241, 1.01444e-5),
  new Array(0.387098, 0),
  new Array(0.205635, 5.59e-10),
  new Array(168.6562, 4.0923344368)
);

planets[5] = new planet(
  "Venus  ",
  1,
  new Array(76.6799, 2.4659e-5),
  new Array(3.3946, 2.75e-8),
  new Array(54.891, 1.38374e-5),
  new Array(0.72333, 0),
  new Array(0.006773, -1.302e-9),
  new Array(48.0052, 1.6021302244)
);

planets[2] = new planet(
  "Mars   ",
  3,
  new Array(49.5574, 2.11081e-5),
  new Array(1.8497, -1.78e-8),
  new Array(286.5016, 2.92961e-5),
  new Array(1.523688, 0),
  new Array(0.093405, 2.516e-9),
  new Array(18.6021, 0.5240207766)
);

planets[4] = new planet(
  "Jupiter",
  4,
  new Array(100.4542, 2.76854e-5),
  new Array(1.303, -1.557e-7),
  new Array(273.8777, 1.64505e-5),
  new Array(5.20256, 0),
  new Array(0.048498, 4.469e-9),
  new Array(19.895, 0.0830853001)
);

planets[6] = new planet(
  "Saturn ",
  5,
  new Array(113.6634, 2.3898e-5),
  new Array(2.4886, -1.081e-7),
  new Array(339.3939, 2.97661e-5),
  new Array(9.55475, 0),
  new Array(0.055546, -9.499e-9),
  new Array(316.967, 0.0334442282)
);
var ptithi = [
  "शुक्ल प्रथमा 1",
  "शुक्ल व्दितिया 2",
  "शुक्ल तृतिया 3",
  "शुक्ल चतु्र्थी 4",
  "शुक्ल पंचमी 5",
  "शुक्ल षष्ठी 6",
  "शुक्ल सप्तमी 7",
  "शुक्ल अष्टमी 8",
  "शुक्ल नवमीं 9",
  "शुक्ल दशमी 10",
  "शुक्ल एकादशी 11",
  "शुक्ल व्दादशी 12",
  "शुक्ल त्रयोदशी 13",
  "शुक्ल चर्तुदशी 14",
  "पूर्णिमा पूर्ण",
  "कृष्ण प्रथमा 1",
  "कृष्ण व्दितिया 2",
  "कृष्ण तृतिया 3",
  "कृष्ण चतुर्थी 4",
  "कृष्ण पंचमी 5",
  "कृष्ण षष्ठी 6",
  "कृष्ण सप्तमी 7",
  "कृष्ण अष्टमी 8",
  "कृष्ण नवमीं 9",
  "कृष्ण दशमी 10",
  "कृष्ण एकादशी 11",
  "कृष्ण व्दादशी 12",
  "कृष्ण त्रयोदशी 13",
  "कृष्ण चर्तुदशी 14",
  "अमावस्या नया",
];
var suklakrishna = [
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  "శుక్ల",
  " శుక్ల",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
  "కృష్ణ",
];
/*var suklakrishna = [
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "शुक्ल",
  "पूर्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "कृष्ण",
  "अमावस्या",
];*/
var hmonth = [ "చైత్ర","వైశాఖ","జేష్ట","ఆషాఢ","శ్రావణ","భాద్రపద","ఆశ్వీజ","కార్తీక","మార్గశిర","పుష్య","మాఘ","ఫాల్గుణ"];
/*
var hmonth = [
  "चैत्र",
  "बैशाख",
  "ज्येष्ठ",
  "आषाढ़",
  "श्रावण",
  "भाद्रपद",
  "अश्विन",
  "कार्तिक",
  "मार्गशीर्ष",
  "पौष",
  "माघ",
  "फाल्गुन",
];*/
var samvatsara = ["ప్రభవ","విభవ","శుక్ల","ప్రమోద్యూత","ప్రజోత్పత్తి","ఆంగీరస","శ్రీముఖ","భావ","యువ","ధాత","ఈశ్వర","బహుధాన్య","ప్రమాధి","విక్రమ","వృష","చిత్రభాను","స్వభాను","తారణ","పార్థివ","వ్యయ","సర్వజిత్తు","సర్వధారి","విరోధి","వికృతి","ఖర","నందన","విజయ","జయ","మన్మధ","దుర్ముఖి","హేవళంబి"," విళంబి","వికారి","శార్వరి","ప్లవ","శుభకృతు"," శోభకృతు"," క్రోధి","విశ్వావసు","పరాభవ"," ప్లవంగ"," కీలక"," సౌమ్య"," సాధారణ","విరోధికృతు"," పరిధావి","ప్రమాదీచ","ఆనంద","రాక్షస","నల","పింగళ","కాళయుక్తి","సిద్ధార్ది","రౌద్రి","దుర్మతి","దుందుభి"," రుధిరోద్గారి","రక్తాక్షి"," క్రోధన","అక్షయ"];
/*
var samvatsara = [
  "प्रभव/Prabhava",
  "विभव/Vibhava",
  "शुक्ल/Shukla",
  "प्रमोद/Pramodadoota",
  "प्रजापति/Prajothpatti",
  "अंगिरस/Āngirasa",
  "श्रीमुख/Shrīmukha",
  "भव/Baāva",
  "युवन/Yuva",
  "धातृ/Dhātru",
  "ईश्वर/Īshvara",
  "बहुधान्य/Bahudhānya",
  "प्रमथिन/Pramāthi",
  "विक्रम/Vikrama",
  "बृष/Vrusha",
  "चित्रभानु/Chitrabhānu",
  "स्वभानु/Svabhānu",
  "तारण/Tārana",
  "पार्थिव/Pārthiva",
  "व्यय/Vyaya",
  "सर्वजित्/Sarvajith",
  "सर्वधारिन्/Sarvadhāri",
  "विरोधिन्/Virodhi",
  "विकृति/Vikruta",
  "खर/Khara",
  "नन्दन/Nandana",
  "विजय/Vijaya",
  "जय/Jaya",
  "मन्मथ/Manmatha",
  "दुर्मुख/Durmukhi",
  "हेमालम्बिन्/Hevilambi",
  "बिलंविन्/Vilambi",
  "विकारिन्/Vikāri",
  "शार्वरी/Shārvari",
  "प्लव/Plava",
  "शुभकृति/Shubhakrutha",
  "शौभन/Shobhakrutha",
  "क्रोधी/Krodhi",
  "विश्वावसु/Vishvāvasu",
  "पराभव/Parābhava",
  "प्लवंग/Plavanga",
  "कीलक/Kīlaka",
  "सोम्य/Saumya",
  "साधारिन्/Sādhārana",
  "विरोधीकृत/Virodhikrutha",
  "परिधाविन्/Paridhāvi",
  "प्रमादिन्/Pramādeecha",
  "आनंद/Ānanda",
  "राक्षस/Rākshasa",
  "अनल/Nala/Anala",
  "पिंगल/Pingala",
  "कालयुक्ति/Kālayukthi",
  "सिद्धार्थिन्/Siddhārthi",
  "रोद्र/Raudra",
  "दु्र्मति/Durmathi",
  "दुंदुभि/Dundubhi",
  "रुधिरोद्गारिन्/Rudhirodgāri",
  "रक्ताक्ष/Raktākshi",
  "क्रोधन/Manyu/Krodhana",
  "अक्षय/Kshaya/Akshaya",
];*/ //var samvatsara = ["Prabhava","Vibhava","Shukla","Pramodoota","Prajothpatti","Āngirasa","Shrīmukha","Baāva","Yuva","Dhātru","Īshvara","Bahudhānya","Pramāthi","Vikrama","Vrusha","Chitrabhānu","Svabhānu","Tārana","Pārthiva","Vyaya","Sarvajith","Sarvadhāri","Virodhi","Vikruta","Khara","Nandana","Vijaya","Jaya","Manmatha","Durmukhi","Hevilambi","Vilambi","Vikāri","Shārvari","Plava","Shubhakrutha","Shobhakrutha","Krodhi","Vishvāvasu","Parābhava","Plavanga","Kīlaka","Saumya","Sādhārana","Virodhikrutha","Paridhāvi","Pramādeecha","Ānanda","Rākshasa","Anala","Pingala","Kālayukthi","Siddhārthi","Raudra","Durmathi","Dundubhi","Rudhirodgāri","Raktākshi","Krodhana","Akshaya"];

function padZero(t) {
  return t < 10 ? "0" + t : t;
}
function frac(x) {
  return x - pI(x);
}
function di(t) {
  return document.getElementById(t);
}
function leap_gregorian(year) {
  return year % 4 == 0 && !(year % 100 == 0 && year % 400 != 0);
}
function pI(t) {
  return parseInt(t);
}

function radecr(obj, sun, jday, obs) {
  // radecr returns ra, dec and earth distance
  // obj and sun comprise Heliocentric Ecliptic Rectangular Coordinates
  // (note Sun coords are really Earth heliocentric coordinates with reverse signs)
  // Equatorial geocentric co-ordinates
  var xg = obj[0] + sun[0];
  var yg = obj[1] + sun[1];
  var zg = obj[2];
  // Obliquity of Ecliptic (exponent corrected, was E-9!)
  var obl = 23.4393 - 3.563e-7 * (jday - 2451543.5);
  // Convert to eq. co-ordinates
  var x1 = xg;
  var y1 = yg * cosd(obl) - zg * sind(obl);
  var z1 = yg * sind(obl) + zg * cosd(obl);
  // RA and dec (33.2)
  var ra = rev(atan2d(y1, x1));
  var dec = atan2d(z1, Math.sqrt(x1 * x1 + y1 * y1));
  var dist = Math.sqrt(x1 * x1 + y1 * y1 + z1 * z1);
  return new Array(ra, dec, dist);
}

function m2j(date_time) {
  m = date_time.getMonth() + 1;
  d = date_time.getDate();
  y = date_time.getFullYear();
  sec = date_time.getSeconds();
  min = date_time.getMinutes();
  hour = date_time.getHours();
  return (
    GREGORIAN_EPOCH -
    1 +
    365 * (y - 1) +
    Math.floor((y - 1) / 4) +
    -Math.floor((y - 1) / 100) +
    Math.floor((y - 1) / 400) +
    Math.floor(
      (367 * m - 362) / 12 + (m <= 2 ? 0 : leap_gregorian(y) ? -1 : -2) + d
    ) +
    Math.floor(sec + 60 * (min + 60 * hour) + 0.5) / 86400.0
  );
}

function helios(p, jday) {
  var d = jday - 2451543.5;
  var w = p.w[0] + p.w[1] * d; // argument of perihelion
  var e = p.e[0] + p.e[1] * d;
  var a = p.a[0] + p.a[1] * d;
  var i = p.i[0] + p.i[1] * d;
  var N = p.N[0] + p.N[1] * d;
  var M = rev(p.M[0] + p.M[1] * d); // mean anomaly
  var E0 = M + RAD2DEG * e * sind(M) * (1.0 + e * cosd(M));
  var E1 = E0 - (E0 - RAD2DEG * e * sind(E0) - M) / (1.0 - e * cosd(E0));
  while (Math.abs(E0 - E1) > 0.0005) {
    E0 = E1;
    E1 = E0 - (E0 - RAD2DEG * e * sind(E0) - M) / (1.0 - e * cosd(E0));
  }
  var xv = a * (cosd(E1) - e);
  var yv = a * Math.sqrt(1.0 - e * e) * sind(E1);
  var v = rev(atan2d(yv, xv)); // true anomaly
  var r = Math.sqrt(xv * xv + yv * yv); // distance
  var xh = r * (cosd(N) * cosd(v + w) - sind(N) * sind(v + w) * cosd(i));
  var yh = r * (sind(N) * cosd(v + w) + cosd(N) * sind(v + w) * cosd(i));
  var zh = r * (sind(v + w) * sind(i));
  var lonecl = atan2d(yh, xh);
  var latecl = atan2d(zh, Math.sqrt(xh * xh + yh * yh + zh * zh));
  if (p.num == JUPITER) {
    // Jupiter pertuberations by Saturn
    var Ms = rev(planets[SATURN].M[0] + planets[SATURN].M[1] * d);
    lonecl +=
      -0.332 * sind(2 * M - 5 * Ms - 67.6) -
      0.056 * sind(2 * M - 2 * Ms + 21) +
      0.042 * sind(3 * M - 5 * Ms + 21) -
      0.036 * sind(M - 2 * Ms) +
      0.022 * cosd(M - Ms) +
      0.023 * sind(2 * M - 3 * Ms + 52) -
      0.016 * sind(M - 5 * Ms - 69);
    xh = r * cosd(lonecl) * cosd(latecl); // recalc xh, yh
    yh = r * sind(lonecl) * cosd(latecl);
  }
  if (p.num == SATURN) {
    // Saturn pertuberations
    var Mj = rev(planets[JUPITER].M[0] + planets[JUPITER].M[1] * d);
    lonecl +=
      0.812 * sind(2 * Mj - 5 * M - 67.6) -
      0.229 * cosd(2 * Mj - 4 * M - 2) +
      0.119 * sind(Mj - 2 * M - 3) +
      0.046 * sind(2 * Mj - 6 * M - 69) +
      0.014 * sind(Mj - 3 * M + 32);
    latecl +=
      -0.02 * cosd(2 * Mj - 4 * M - 2) + 0.018 * sind(2 * Mj - 6 * M - 49);
    xh = r * cosd(lonecl) * cosd(latecl); // recalc xh, yh, zh
    yh = r * sind(lonecl) * cosd(latecl);
    zh = r * sind(latecl);
  }
  return new Array(xh, yh, zh, r, lonecl, latecl);
}

function j2j(JulianDay) {
  //20040205

  j = pI(JulianDay) + 1402;
  k = pI((j - 1) / 1461);
  l = j - 1461 * k;
  n = pI((l - 1) / 365) - pI(l / 1461);
  i = l - 365 * n + 30;
  J = pI((80 * i) / 2447);
  I2 = pI(J / 11);
  this.day0 = i - pI((2447 * J) / 80);
  this.month = J + 2 - 12 * I2;
  this.year = 4 * k + n + I2 - 4716;
  return this;
}
function j2g(JulianDay) {
  //20030331
  a = JulianDay + 68569;
  b = pI(a / 36524.25);
  c = a - pI(36524.25 * b + 0.75);
  e = pI((c + 1) / 365.2425);

  f = c - pI(365.25 * e) + 31;
  g = pI(f / 30.59);
  h = pI(g / 11);
  this.day0 = Math.floor(f - pI(30.59 * g) + (JulianDay - pI(JulianDay)));
  this.month = Math.floor(g - 12 * h + 2);
  this.year = Math.floor(100 * (b - 49) + e + h);
  return this;
}
function jd2md(JulianDay) {
  //20030331

  if (JulianDay < 2299239) {
    return j2j(JulianDay);
  } else {
    return j2g(JulianDay);
  }
}
function jd2md2(j) {
  if (j < 2299239) t = j2j(j);
  else t = j2g(j);
  return emonth2[t.month - 1] + " " + t.day0 + " " + t.year;
}
function sqr(x) {
  return x * x;
}
function arcsin(x) {
  //###20010316
  if (eps < Math.abs(1 - sqr(x))) {
    return Math.atan2(x / Math.sqrt(1 - sqr(x)), 1);
  } else if (0 < x) {
    //# {x is neary to 1}
    return Math.PI / 2; //   # {sin(pi/2)=1}
  } else {
    //  # {x is neary to -1}
    return (3 * Math.PI) / 2; // # {sin(3 pi/2)=-1}
  }
}
function get_mean_long(ahar, rotation) {
  return 360 * frac((rotation * ahar) / YCD);
}
function declination(long) {
  return arcsin(Math.sin(long / rad) * Math.sin(24 / rad)) * rad;
}
function get_daylight_equation(ahar, year, loc_lat) {
  mslong = get_mean_long(ahar, 4320000);
  samslong = mslong + (54 / 3600) * (year - 499);
  sdecl = declination(samslong);
  x = Math.tan(loc_lat / rad) * Math.tan(sdecl / rad);
  return (0.5 * arcsin(x)) / Math.PI;
}
function get_manda_equation(argument, planet) {
  return arcsin((planet / 360) * Math.sin(argument / rad)) * rad;
}
function get_tithi(tllong, tslong) {
  elong = tllong - tslong;
  elong = ms_fix360(elong);

  return elong / 12;
}
function get_tslong(ahar) {
  mslong = get_mean_long(ahar, 4320000);
  return ms_fix360(
    mslong - get_manda_equation(mslong - (77 + 17 / 60), 13 + 50 / 60)
  );
}
function get_tllong(ahar) {
  mllong = get_mean_long(ahar, 57753336);
  apogee = get_mean_long(ahar, 488203) + 90;
  return ms_fix360(mllong - get_manda_equation(mllong - apogee, 31 + 50 / 60));
}
function get_elong(ahar) {
  elong = Math.abs(get_tllong(ahar) - get_tslong(ahar));
  if (180 < elong) {
    elong = 360 - elong;
  }
  return elong;
}
function three_relation(a, b, c) {
  if (a < b && b < c) {
    d = 1;
  } else if (c < b && b < a) {
    d = -1;
  } else {
    d = 0;
  }
  return d;
}
function find_conj(leftx, lefty, rightx, righty) {
  width = (rightx - leftx) / 2;
  centrex = (rightx + leftx) / 2;
  if (width < epsiron) {
    return get_tslong(centrex);
  } else {
    centrey = get_elong(centrex);
    relation = three_relation(lefty, centrey, righty);
    if (relation < 0) {
      rightx = rightx + width;
      righty = get_elong(rightx);
      return find_conj(centrex, centrey, rightx, righty);
    } else if (0 < relation) {
      leftx = leftx - width;
      lefty = get_elong(leftx);
      return find_conj(leftx, lefty, centrex, centrey);
    } else {
      leftx = leftx + width / 2;
      lefty = get_elong(leftx);
      rightx = rightx - width / 2;
      righty = get_elong(rightx);
      return find_conj(leftx, lefty, rightx, righty);
    }
  }
}
function get_conj(ahar) {
  return find_conj(
    ahar - 2,
    get_elong(ahar - 2),
    ahar + 2,
    get_elong(ahar + 2)
  );
}
function get_clong(ahar, tithi) {
  new_new = YCD / (57753336 - 4320000);
  ahar = ahar - tithi * (new_new / 30);

  if (Math.abs(ahar - back_clong_ahar) < 1) {
    return back_clong;
  } else if (Math.abs(ahar - back_nclong_ahar) < 1) {
    back_clong_ahar = back_nclong_ahar;
    back_clong = back_nclong;
    return back_nclong;
  } else {
    back_clong_ahar = ahar;
    back_clong = get_conj(ahar);
    return back_clong;
  }
}
function get_nclong(ahar, tithi) {
  new_new = YCD / (57753336 - 4320000);
  ahar = ahar + (30 - tithi) * (new_new / 30);

  if (Math.abs(ahar - back_nclong_ahar) < 1) {
    return back_nclong;
  } else {
    back_nclong_ahar = ahar;
    back_nclong = get_conj(ahar);
    return back_nclong;
  }
}
function get_masa_num(tslong, clong) {
  masa_num = Math.floor(tslong / 30) % 12;
  if (Math.floor(clong / 30) % 12 == masa_num) {
    masa_num = masa_num + 1;
  }
  masa_num = (masa_num + 12) % 12;
  return masa_num;
}
function adhimasa_p(clong, nclong) {
  if (Math.floor(clong / 30) == Math.floor(nclong / 30)) {
    return true;
  } else {
    return false;
  }
}
function get_adhimasa(clong, nclong) {
  if (adhimasa_p(clong, nclong)) {
    return "अधिक-";
  } else {
    return "&nbsp;*&nbsp;";
  }
}

function getGrahas(j, l, lat) {
  obs = { longitude: l, latitude: lat };
  this.grahas = new Array(9);
  this.grahas_next = new Array(9);
  this.speed = new Array(9);
  this.retro = new Array(9);
  this.gr = new Array(9);
  this.grn = new Array(9);
  for (a = 0; a < 7; a++) {
    this.gr[a] = PlanetAlt(a, j, obs);
    this.grahas[a] = this.gr[a][5];
    this.grn[a] = PlanetAlt(a, j + 1, obs);
    this.grahas_next[a] = this.grn[a][5];
    this.speed[a] =
      this.grahas_next[a] - this.grahas[a] < -300
        ? ((this.grahas_next[a] - this.grahas[a] + 360) % 360) / day
        : ((this.grahas_next[a] - this.grahas[a]) % 360) / day;
    this.retro[a] = this.speed[a] < 0 ? 1 : 0;
  }
}

var DEG2RAD = Math.PI / 180.0;
var RAD2DEG = 180.0 / Math.PI;
H0SUN = -0.833;
H0STAR = -0.583;
function rev2(angle) {
  var a = rev(angle);
  return a >= 180 ? a - 360.0 : a;
} // -180<=a<180
function sind(angle) {
  return Math.sin(angle * DEG2RAD);
}
function cosd(angle) {
  return Math.cos(angle * DEG2RAD);
}
function tand(angle) {
  return Math.tan(angle * DEG2RAD);
}
function asind(c) {
  return RAD2DEG * Math.asin(c);
}
function acosd(c) {
  return RAD2DEG * Math.acos(c);
}
function atand(c) {
  return RAD2DEG * Math.atan(c);
}
function atan2d(y, x) {
  return RAD2DEG * Math.atan2(y, x);
}

function log10(x) {
  return Math.LOG10E * Math.log(x);
}

function sqr(x) {
  return x * x;
}
function cbrt(x) {
  return Math.pow(x, 1 / 3.0);
}

function SGN(x) {
  return x < 0 ? -1 : +1;
}
function rev(angle) {
  return angle - Math.floor(angle / 360.0) * 360.0;
} // 0<=a<360
function radec2aa(ra, dec, jday, obs) {
  // Convert ra/dec to alt/az, also return hour angle, azimut = 0 when north
  // DOES NOT correct for parallax!
  // TH0=Greenwich sid. time (eq. 12.4), H=hour angle (chapter 13)
  var TH0 = 280.46061837 + 360.98564736629 * (jday - 2451545.0);
  var H = rev(TH0 - obs.longitude - ra);
  var alt = asind(
    sind(obs.latitude) * sind(dec) + cosd(obs.latitude) * cosd(dec) * cosd(H)
  );
  var az = atan2d(
    sind(H),
    cosd(H) * sind(obs.latitude) - tand(dec) * cosd(obs.latitude)
  );
  return new Array(alt, rev(az + 180.0), H);
}
function sunxyz(jday) {
  // return x,y,z ecliptic coordinates, distance, true longitude
  // days counted from 1999 Dec 31.0 UT
  var d = jday - 2451543.5;
  var w = 282.9404 + 4.70935e-5 * d; // argument of perihelion
  var e = 0.016709 - 1.151e-9 * d;
  var M = rev(356.047 + 0.9856002585 * d); // mean anomaly
  var E = M + e * RAD2DEG * sind(M) * (1.0 + e * cosd(M));
  var xv = cosd(E) - e;
  var yv = Math.sqrt(1.0 - e * e) * sind(E);
  var v = atan2d(yv, xv); // true anomaly
  var r = Math.sqrt(xv * xv + yv * yv); // distance
  var lonsun = rev(v + w); // true longitude
  var xs = r * cosd(lonsun); // rectangular coordinates, zs = 0 for sun
  var ys = r * sind(lonsun);
  return new Array(xs, ys, 0, r, lonsun, 0);
}

function SunAlt(jday, obs) {
  // return alt, az, time angle, ra, dec, ecl. long. and lat=0, illum=1, 0, dist, brightness
  var sdat = sunxyz(jday);
  var ecl = 23.4393 - 3.563e-7 * (jday - 2451543.5);
  var xe = sdat[0];
  var ye = sdat[1] * cosd(ecl);
  var ze = sdat[1] * sind(ecl);
  var ra = rev(atan2d(ye, xe));
  var dec = atan2d(ze, Math.sqrt(xe * xe + ye * ye));
  var topo = radec2aa(ra, dec, jday, obs);
  return new Array(
    topo[0],
    topo[1],
    topo[2],
    ra,
    dec,
    sdat[4],
    0,
    1,
    0,
    sdat[3],
    -26.74
  );
}
function MoonPos(jday, obs) {
  // MoonPos calculates the Moon position and distance, based on Meeus chapter 47
  // and the illuminated percentage from Meeus equations 48.4 and 48.1
  // OPN: This version of MoonPos calculates the position to a precision of about 2' or so
  // All T^2, T^3 and T^4 terms skipped. NB: Time is not taken from obs but from jday (julian day)
  // Returns alt, az, hour angle, ra, dec (geocentr!), eclip. long and lat (geocentr!),
  // illumination, distance, brightness and phase angle
  var T = (jday - 2451545.0) / 36525;
  // Moons mean longitude L'
  var LP = rev(218.3164477 + 481267.88123421 * T);
  // Moons mean elongation
  var D = rev(297.8501921 + 445267.1114034 * T);
  // Suns mean anomaly
  var M = rev(357.5291092 + 35999.0502909 * T);
  // Moons mean anomaly M'
  var MP = rev(134.9633964 + 477198.8675055 * T);
  // Moons argument of latitude
  var F = rev(93.272095 + 483202.0175233 * T);
  // The "further arguments" A1, A2 and A3  and the term E have been ignored
  // Sum of most significant terms from table 45.A and 45.B (terms less than 0.004 deg / 40 km dropped)
  var Sl =
    6288774 * sind(MP) +
    1274027 * sind(2 * D - MP) +
    658314 * sind(2 * D) +
    213618 * sind(2 * MP) -
    185116 * sind(M) -
    114332 * sind(2 * F) +
    58793 * sind(2 * D - 2 * MP) +
    57066 * sind(2 * D - M - MP) +
    53322 * sind(2 * D + MP) +
    45758 * sind(2 * D - M) -
    40923 * sind(M - MP) -
    34720 * sind(D) -
    30383 * sind(M + MP) +
    15327 * sind(2 * D - 2 * F) -
    12528 * sind(MP + 2 * F) +
    10980 * sind(MP - 2 * F) +
    10675 * sind(4 * D - MP) +
    10034 * sind(3 * MP) +
    8548 * sind(4 * D - 2 * MP) -
    7888 * sind(2 * D + M - MP) -
    6766 * sind(2 * D + M) -
    5163 * sind(D - MP) +
    4987 * sind(D + M) +
    4036 * sind(2 * D - M + MP);
  var Sb =
    5128122 * sind(F) +
    280602 * sind(MP + F) +
    277602 * sind(MP - F) +
    173237 * sind(2 * D - F) +
    55413 * sind(2 * D - MP + F) +
    46271 * sind(2 * D - MP - F) +
    32573 * sind(2 * D + F) +
    17198 * sind(2 * MP + F) +
    9266 * sind(2 * D + MP - F) +
    8822 * sind(2 * MP - F) +
    8216 * sind(2 * D - M - F) +
    4324 * sind(2 * D - 2 * MP - F) +
    4200 * sind(2 * D + MP + F);
  var Sr =
    -20905355 * cosd(MP) -
    3699111 * cosd(2 * D - MP) -
    2955968 * cosd(2 * D) -
    569925 * cosd(2 * MP) +
    246158 * cosd(2 * D - 2 * MP) -
    152138 * cosd(2 * D - M - MP) -
    170733 * cosd(2 * D + MP) -
    204586 * cosd(2 * D - M) -
    129620 * cosd(M - MP) +
    108743 * cosd(D) +
    104755 * cosd(M + MP) +
    79661 * cosd(MP - 2 * F) +
    48888 * cosd(M);
  // geocentric longitude, latitude
  var mglong = rev(LP + Sl / 1000000.0);
  var mglat = Sb / 1000000.0;
  // Obliquity of Ecliptic
  var obl = 23.4393 - 3.563e-7 * (jday - 2451543.5);
  var ra = rev(
    atan2d(sind(mglong) * cosd(obl) - tand(mglat) * sind(obl), cosd(mglong))
  );
  var dec = asind(
    sind(mglat) * cosd(obl) + cosd(mglat) * sind(obl) * sind(mglong)
  );
  var moondat = radec2aa(ra, dec, jday, obs);
  // phase angle (48.4)
  var pa = Math.abs(
    180.0 -
      D -
      6.289 * sind(MP) +
      2.1 * sind(M) -
      1.274 * sind(2 * D - MP) -
      0.658 * sind(2 * D) -
      0.214 * sind(2 * MP) -
      0.11 * sind(D)
  );
  var k = (1 + cosd(pa)) / 2;
  var mr = Math.round(385000.56 + Sr / 1000.0);
  var h = moondat[0];
  // correct for parallax, equatorial horizontal parallax, see Meeus p. 337
  h -= asind(6378.14 / mr) * cosd(h);
  // brightness, use Paul Schlyter's formula (based on common phase law for Moon)
  var sdat = sunxyz(jday);
  var r = sdat[3]; // Earth (= Moon) distance to Sun in AU
  var R = mr / 149598000; // Moon distance to Earth in AU
  var mag = 0.23 + 5 * log10(r * R) + 0.026 * pa + 4.0e-9 * pa * pa * pa * pa;
  return new Array(
    h,
    moondat[1],
    moondat[2],
    ra,
    dec,
    mglong,
    mglat,
    k,
    r,
    mr,
    mag
  );
} // Moonpos()

MERCURY = 3;
VENUS = 5;
MARS = 2;
JUPITER = 4;
SATURN = 6;
SUN = 0;
MOON = 1;
// The planet object
function planet(name, num, N, i, w, a, e, M) {
  this.name = name;
  this.num = num;
  this.N = N; // longitude of ascending node
  this.i = i; // inclination
  this.w = w; // argument of perihelion
  this.a = a; // semimajor axis
  this.e = e; // eccentricity
  this.M = M; // mean anomaly
}

function PlanetAlt(p, jday, obs) {
  // Alt/Az, hour angle, ra/dec, ecliptic long. and lat, illuminated fraction, dist(Sun), dist(Earth), brightness of planet p
  if (p == SUN) return SunAlt(jday, obs);
  if (p == MOON) return MoonPos(jday, obs);
  var sun_xyz = sunxyz(jday);
  var planet_xyz = helios(planets[p], jday);

  var dx = planet_xyz[0] + sun_xyz[0];
  var dy = planet_xyz[1] + sun_xyz[1];
  var dz = planet_xyz[2] + sun_xyz[2];
  var lon = rev(atan2d(dy, dx));
  var lat = atan2d(dz, Math.sqrt(dx * dx + dy * dy));

  var radec = radecr(planet_xyz, sun_xyz, jday, obs);
  var ra = radec[0];
  var dec = radec[1];
  var altaz = radec2aa(ra, dec, jday, obs);

  var dist = radec[2];
  var R = sun_xyz[3]; // Sun-Earth distance
  var r = planet_xyz[3]; // heliocentric distance
  var k = ((r + dist) * (r + dist) - R * R) / (4 * r * dist); // illuminated fraction (41.2)
  // brightness calc according to Meeus p. 285-86 using Astronomical Almanac expressions
  var absbr = new Array(-0.42, -4.4, 0, -1.52, -9.4, -8.88, -7.19, -6.87);
  var i = acosd((r * r + dist * dist - R * R) / (2 * r * dist)); // phase angle
  var mag = absbr[p] + 5 * log10(r * dist); // common for all planets
  switch (p) {
    case MERCURY:
      mag += i * (0.038 + i * (-0.000273 + i * 0.000002));
      break;
    case VENUS:
      mag += i * (0.0009 + i * (0.000239 - i * 0.00000065));
      break;
    case MARS:
      mag += i * 0.016;
      break;
    case JUPITER:
      mag += i * 0.005;
      break;
    case SATURN: // (Ring system needs special treatment, see Meeus Ch. 45)
      var T = (jday - 2451545.0) / 36525; // (22.1)
      var incl = 28.075216 - 0.012998 * T + 0.000004 * T * T; // (45.1)
      var omega = 169.50847 + 1.394681 * T + 0.000412 * T * T; // (45.1)
      var B = asind(
        sind(incl) * cosd(lat) * sind(lon - omega) - cosd(incl) * sind(lat)
      );
      var l = planet_xyz[4]; // heliocentric longitude of Saturn
      var b = planet_xyz[5]; // heliocentric latitude (do not confuse with 'b' in step 6, page 319)
      // correction for Sun's aberration skipped
      var U1 = atan2d(
        sind(incl) * sind(b) + cosd(incl) * cosd(b) * sind(l - omega),
        cosd(b) * cosd(l - omega)
      );
      var U2 = atan2d(
        sind(incl) * sind(lat) + cosd(incl) * cosd(lat) * sind(lon - omega),
        cosd(lat) * cosd(lon - omega)
      );
      var dU = Math.abs(U1 - U2);
      mag += 0.044 * dU - 2.6 * sind(Math.abs(B)) + 1.25 * sind(B) * sind(B);
      break;
  }
  return new Array(
    altaz[0],
    altaz[1],
    altaz[2],
    ra,
    dec,
    lon,
    lat,
    k,
    r,
    dist,
    mag
  );
}

function ms_fix360(v) {
  if (v < 0.0) v += 360;
  if (v > 360) v -= 360;
  return v;
}

function getYear_Month(date_time, longitude, latitude) {
  this.jd2 = m2j(date_time) + date_time.getTimezoneOffset() / 1440;
  this.grahas = new getGrahas(jd2, longitude, latitude);
  this.ahar = jd2 - 588465.5;
  tslong = get_tslong(ahar);
  tllong = get_tllong(ahar);
  tithi0 = get_tithi(tllong, tslong);
  clong = get_clong(ahar, tithi0); // {last conjunction}
  nclong = get_nclong(ahar, tithi0);
  adhimasa = get_adhimasa(clong, nclong);
  masa_num = get_masa_num(tslong, clong);


  if (this.purnimanta) {
    if (adhimasa_p(clong, nclong)) {
      masa_num += 0;
    } else {
      if (tithi0 >= 15.0) {
        masa_num += 1;
        masa_num %= 12;
      }
    }
  }

  this.moon_cur = this.grahas.grahas[1];
  this.sun_cur = this.grahas.grahas[0];
  this.tithi_cur = ((360+this.moon_cur - this.sun_cur)%360)/12;
  this.tithi_cur1 = this.tithi_cur+1;
  this.pakshatithi = suklakrishna[pI(this.tithi_cur)];

  masa = hmonth[masa_num];
  rutu = masa_num/2;

  YCD = 1582237828 - 4320000;
  this.kaliyear = Math.floor(((ahar + (4 - masa_num) * 30) * 4320000) / YCD);
  this.sakayear = this.kaliyear - 3179;
  this.vikramayear = this.sakayear + 135;
  this.iSamvatasara = Math.floor(
    ((kaliyear * 211 - 108) / 18000 + kaliyear + 27 - 1) % 60
  ); //or use this one this.iSamvatasara = (
  this.iSamvatasaras =
    ((date_time.getFullYear() - 1) % 60) +
    (this.grahas.grahas[0] > 240 && date_time.getMonth() < 5 ? -7 : -6); //for south indians
  this.sSamvatsara = samvatsara[(this.iSamvatasara + 60) % 60];
  this.sSamvatsaras = samvatsara[(this.iSamvatasaras + 60) % 60];

  return this;
}

Date.prototype.toLocaleString = function () {
  return this.toString().replace(" GMT+0530 (India Standard Time)", "");
};
Date.prototype.toLS = function () {
  return this.toLocaleString().substr(4);
};

masasamvatsara = {
  Masa: {},
  Samvatsara: {},
  Paksha:{},
  version: "0.3",
  ms_values: function () {
    d = new Date();
    lon = "78.491684";
    lat = "17.387140";
    pla = "Hyderabad";
    c = pla;

    places[c] = lat + ";" + lon;
    z = "";
    for (x in places) z = z + x + "#" + places[x] + "&";
    //setCookie('placeslist',z,1000);
    masa_samvatsara = getYear_Month(d, lon, lat);
    this.Masa.name = masa_samvatsara.masa;
    this.Samvatsara.name = masa_samvatsara.sSamvatsaras;
    this.Paksha.name = masa_samvatsara.pakshatithi;
  },
};
/*
function getMasaSamvatsara() {
  d = new Date();
  lon = "78.491684";
  lat = "17.387140";
  pla = "Hyderabad";
  c = pla;

  places[c] = lat + ";" + lon;
  z = "";
  for (x in places) z = z + x + "#" + places[x] + "&";
  //setCookie('placeslist',z,1000);
  masa_samvatsara = getYear_Month(d, lon, lat);
  return masa_samvatsara;
  //console.log(masa_samvatsara.sSamvatsaras + masa_samvatsara.masa);
}
*/
