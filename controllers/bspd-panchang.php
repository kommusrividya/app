<?php

declare(strict_types=1);

require_once("constant.php");
require_once("vendor/autoload.php");


use Prokerala\Api\Astrology\Location;
use Prokerala\Api\Astrology\Result\Panchang\AuspiciousPeriod;
use Prokerala\Api\Astrology\Service\Panchang;
use Prokerala\Common\Api\Exception\AuthenticationException;
use Prokerala\Common\Api\Exception\Exception;
use Prokerala\Common\Api\Exception\QuotaExceededException;
use Prokerala\Common\Api\Exception\RateLimitExceededException;
use Prokerala\Common\Api\Exception\ValidationException;

use GuzzleHttp\Client as PsrHttpClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Prokerala\Common\Api\Authentication\Oauth2;
use Prokerala\Common\Api\Client;

$psr17Factory = new Psr17Factory();
$httpClient = new PsrHttpClient();



$clientId = CLIENT_ID;
$clientSecret = CLIENT_SECRET;

$authClient = new Oauth2($clientId, $clientSecret, $httpClient, $psr17Factory, $psr17Factory);

$client = new Client($authClient, $httpClient, $psr17Factory);


date_default_timezone_set('Asia/Kolkata');
$time_now = new DateTime();
$time_now->setTime(0,0);
$input = [
    'datetime' => $time_now->format('c'),
    'latitude' => '19.0821978',
    'longitude' => '72.7411014', // Mumbai
];
echo $time_now->format('c');
$coordinates = $input['latitude'] . ',' . $input['longitude'];
$submit = $_POST['submit'] ?? 1;
$ayanamsa = 1;
$result_type = 'advanced';
$sample_name = 'panchang';

$timezone = 'Asia/Kolkata';
if (isset($_POST['submit'])) {
    $input['datetime'] = $_POST['datetime'];
    $coordinates = $_POST['coordinates'];
    $result_type = $_POST['result_type'];
    $arCoordinates = explode(',', $coordinates);
    $input['latitude'] = $arCoordinates[0] ?? '';
    $input['longitude'] = $arCoordinates[1] ?? '';
    $ayanamsa = $_POST['ayanamsa'];
    $timezone = $_POST['timezone'] ?? '';
}

$tz = new DateTimeZone($timezone);
$datetime = new DateTimeImmutable($input['datetime'], $tz);
$location = new Location($input['latitude'], $input['longitude'], 0, $tz);


$result = [];
$errors = [];

if ($submit) {
    try {
        $advanced = 'advanced' === $result_type;

        $method = new Panchang($client);
        $method->setAyanamsa($ayanamsa);
        $result = $method->process($location, $datetime, $advanced);
        
        $panchangResult = [
            'sunrise' => $result->getSunrise(),
            'sunset' => $result->getSunset(),
            'moonrise' => $result->getMoonrise(),
            'moonset' => $result->getMoonset(),
            'vaara' => $result->getVaara(),
        ];

        $panchang = [];
        $panchang['Nakshatra'] = $result->getNakshatra();
        $panchang['Tithi'] = $result->getTithi();
        $panchang['Karana'] = $result->getKarana();
        $panchang['Yoga'] = $result->getYoga();
        $yoga = $panchang['Yoga'];

        $data_list = ['Nakshatra', 'Tithi', 'Karana', 'Yoga'];

        foreach ($data_list as $key) {
            foreach ($panchang[$key] as $idx => $data) {
                $panchangResult[$key][$idx] = [
                    'id' => $data->getId(),
                    'name' => $data->getName(),
                    'start' => $data->getStart(),
                    'end' => $data->getEnd(),
                ];
                if ('Nakshatra' === $key) {
                    $panchangResult[$key][$idx]['nakshatra_lord'] = $data->getLord();
                } elseif ($key === 'Tithi'){
                    $panchangResult[$key][$idx]['paksha'] = $data->getPaksha();
                }
            }
        }

        $auspicious_fields = ['abhijitMuhurat', 'amritKaal', 'brahmaMuhurat'];
        $inauspicious_fields = ['rahuKaal', 'yamagandaKaal', 'gulikaKaal', 'durMuhurat', 'varjyam'];

        $auspiciousPeriod = [];
        $inAuspiciousPeriod = [];

        if ($advanced) {
            $auspicious_periods = $result->getAuspiciousPeriod();
            $inauspicious_period = $result->getInauspiciousPeriod();

            foreach ($auspicious_periods as $data) {
                $field = $data->getName();
                $periods = $data->getPeriod();
                foreach ($periods as $period) {
                    $auspiciousPeriod[$field][] = [
                        'start' => $period->getStart(),
                        'end' => $period->getEnd(),
                    ];
                }
            }

            foreach ($inauspicious_period as $data) {
                $field = $data->getName();
                $periods = $data->getPeriod();
                foreach ($periods as $period) {
                    $inAuspiciousPeriod[$field][] = [
                        'start' => $period->getStart(),
                        'end' => $period->getEnd(),
                    ];
                }
            }
        }
    } catch (ValidationException $e) {
        $errors = $e->getValidationErrors();
    } catch (QuotaExceededException $e) {
        $errors['message'] = 'ERROR: You have exceeded your quota allocation for the day';
    } catch (RateLimitExceededException $e) {
        $errors['message'] = 'ERROR: Rate limit exceeded. Throttle your requests.';
    } catch (AuthenticationException $e) {
        $errors = ['message' => $e->getMessage()];
    } catch (Exception $e) {
        $errors = ['message' => "API Request Failed with error {$e->getMessage()}"];
    }
}

$apiCreditUsed = $client->getCreditUsed();

echo "<br><br>Panchang Details<br><br>";
$panchang_details = array();
foreach ($panchangResult as $key => $data) {

if (in_array($key, ['Nakshatra', 'Tithi', 'Karana', 'Yoga'], true)){
        echo ucwords($key).":<br/>";
        foreach ($data as $idx => $value) {
            echo $value['name']." "; 
            if ('Nakshatra' === $key) {
                echo $value['nakshatra_lord'];
                //$nakshatra_lord = (array) $value['nakshatra_lord'];
                $panchang_details[ucwords($key)][$value['name']]['nakshatra_lord'] = get_property($value['nakshatra_lord'], 'vedicName');
            }
            $panchang_details[ucwords($key)][$value['name']]['start'] = $value['start']->format('h:i A');
            $panchang_details[ucwords($key)][$value['name']]['end'] = $value['end']->format('h:i A');
            echo $value['start']->format('h:i A') . ' - ' . $value['end']->format('h:i A')."<br/>";
        }
    }

}


function get_property(object $object, string $property) {
    $array = (array) $object;
    $propertyLength = strlen($property);
    foreach ($array as $key => $value) {
        if (substr($key, -$propertyLength) === $property) {
            return $value;
        }
    }
}

echo "<br><br>Auspicious Period!<br><br>";
foreach ($auspiciousPeriod as $muhuratName => $muhuratDetails):
    echo ucwords($muhuratName);
            foreach ($muhuratDetails as $idx => $value):
                $panchang_details['auspicious_period'][ucwords($muhuratName)]['start'] = $value['start']->format('h:i A'); 
                $panchang_details['auspicious_period'][ucwords($muhuratName)]['end'] = $value['end']->format('h:i A');
             endforeach;
endforeach;

echo "<br><br>Inauspicious Period<br><br>";
foreach ($inAuspiciousPeriod as $muhuratName => $muhuratDetails):
    echo ucwords($muhuratName);
            foreach ($muhuratDetails as $idx => $value):
                $panchang_details['inauspicious_period'][ucwords($muhuratName)]['start'] = $value['start']->format('h:i A');
                $panchang_details['inauspicious_period'][ucwords($muhuratName)]['end'] = $value['end']->format('h:i A');
            endforeach;
 endforeach;

 print_r($panchang_details);

 $currentDateTime = date('Y-m-d');

 $tithi=array();
 $tithi = array_keys($panchang_details["Tithi"]);

 $nakshatra=array();
 $nakshatra = array_keys($panchang_details["Nakshatra"]);


$sql = "INSERT INTO `urf_sandbox`.`SBOX_panchang_details` (`date`, `tithi`, `nakshatra`, `panchang`) VALUES ('$currentDateTime', '$tithi[0]', '$nakshatra[0]', '".json_encode($panchang_details)."');";

if(mysqli_query($link_test, $sql)) echo "Successful";
else echo "Fail ".mysqli_error($link_test);