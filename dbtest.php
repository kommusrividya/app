<?php
require_once "./vendor/autoload.php";
require_once "./config/database.php";
require_once "./Models/test1.php";

$data = new test1();


print_r($data);