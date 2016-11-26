<?php

// THIS IS ONLY A SAMPLE SCRIPT. PLEASE TWEAK IT TO YOUR NEEDS.
// IT COMES WITH NO WARRANTY WHATSOEVER. 

$file = "/tmp/gps-position.txt"; // you might save in a database instead...

if (isset($_GET["lat"]) && preg_match("/^-?\d+\.\d+$/", $_GET["lat"])
    && isset($_GET["lon"]) && preg_match("/^-?\d+\.\d+$/", $_GET["lon"]) ) {
    $fh = fopen($file, "w");
    if (!$fh) {
        header("HTTP/1.0 500 Internal Server Error");
        exit(print_r(error_get_last(), true));
    }
    fwrite($fh, date("Y-m-d H:i:s")."_".$_GET["lat"]."_".$_GET["lon"]."_");
    if (isset($_GET["t"]) && preg_match("/^\d+$/", $_GET["t"])) {
        fwrite($fh, $_GET["t"]);
    }
    $params = array ('api_key' => '592ZO4QDR410N2LZ', 'field1' => $_GET["lat"], $

    $query = http_build_query ($params);

    $contextData = array (
                   'method' => 'POST',
                   'header' => "Connection: close \r\n".
                               "Content-Length: ".strlen($query)."\r\n",
                   'content' => $query );
    $context = stream_context_create (array ( 'http' => $contextData ));
    $result = file_get_contents (
                    'http://api.thingspeak.com/update',
                    false,
                    $context);
    
    fclose($fh);
    // you should obviously do your own checks before this...
    echo "OK";
} elseif (isset($_GET["tracker"])) {
    // do whatever you want here...
    echo "OK";
} else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Please type this URL in the <a href="https://play.google.com/store/apps/details?id=fr.herverenault.selfhostedgpstracker">Self-Hosted GPS Tracker</a> Android app on your phone.';
}
