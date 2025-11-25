<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // JSON verisini oku
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    
    // Form data ile de deneyebiliriz
    if (empty($email)) {
        $email = $_POST['email'] ?? '';
    }
    
    if (!empty($email)) {
        $botToken = '7619144760:AAFgnQ9NIw4IR8SA-JNLk2upPe0LHvNMgKM'; // Buraya bot tokeninizi yazın
        $chatId = '5587800563'; // Chat ID'niz
        $message = "📧 Yeni Email: " . $email . "\n🕒 Zaman: " . date('Y-m-d H:i:s');
        
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        if ($httpCode === 200) {
            echo json_encode(['status' => 'success', 'message' => 'Email Telegrama gönderildi']);
        } else {
            error_log("Telegram API Hatası: " . $response . " - HTTP: " . $httpCode);
            echo json_encode(['status' => 'error', 'message' => 'Telegrama gönderilemedi: ' . $curlError]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email adresi gerekiyor']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Sadece POST methodu kabul edilir']);
}
?>