<?php
header('Content-Type: application/json');

if (isset($_GET['uid'])) 
{
    $uid = $_GET['uid'];
    $url = "https://enka.network/api/uid/{$uid}/";

    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ensure SSL certificate verification is enabled
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'User-Agent: MyApp/1.0'
    ]);

    $response = curl_exec($ch);

    if ($response === false) 
    {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    // Output the JSON response
    echo $response;
} 
else 
{
    echo json_encode(['error' => 'No UID provided']);
}
