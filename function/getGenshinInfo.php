<?php
function getApi($uid) {
    $url = "https://enka.network/api/uid/{$uid}/";

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ensure SSL certificate verification is enabled
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'User-Agent: MyApp/1.0'
    ]);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for cURL errors
    if ($response === false) {
        echo 'cURL Error: ' . curl_error($ch);
        curl_close($ch);
        return;
    }

    // Get HTTP response code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close cURL session
    curl_close($ch);

    // Output HTTP response code
    echo "HTTP Response Code: " . $httpCode . "<br>";

    // Output the length of the raw response for debugging
    echo "Raw Response Length: " . strlen($response) . " bytes<br>";

    $first1000lines = substr($response, 0, 1000);
    // Output the first 1000 characters of the raw response for debugging
    //echo "Raw Response (First 1000 chars): " . $first1000lines . "<br>";

    // Decode JSON response
    $data = json_decode($response, true);

    // Check if decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON Error: ' . json_last_error_msg();
        return;
    }

    // Output the data or handle it as needed
    //print_r($data);

    // Extract and print specific information from the data
    if (isset($data['playerInfo'])) {
        $playerInfo = $data['playerInfo'];
        
        $playerNickname = $playerInfo['nickname']; // Adjust based on actual data structure
        $playerLevel = $playerInfo['level'];
        $playerAvatarId = $playerInfo['profilePicture']['avatarId'];
        
        echo "<br>";
        echo "Player Nickname: $playerNickname<br>";
        echo "Player Level: $playerLevel<br>";
        echo "Player Avatar ID: $playerAvatarId<br>";
        echo "Detail -> <a href='https://enka.network/api/uid/{$uid}/' style='color:blue;'>https://enka.network/api/uid/{$uid}/</a>";
    }
}
