<?php
// Универсальная функция для отправки HTTP-запросов с обработкой ошибок
function sendHttpRequest($url, $method = 'GET', $data = null, $headers = []) {
    // Инициализация cURL
    $ch = curl_init();
    
    // Настройка основных параметров
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    
    // Установка метода запроса
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    // Добавление данных для POST/PUT запросов
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
    }
    
    // Добавление заголовков
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    // Для корректной обработки HTTPS
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // Выполнение запроса с обработкой исключений
    try {
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        
        // Обработка ошибок cURL
        if (curl_errno($ch)) {
            throw new Exception('cURL error: ' . curl_error($ch));
        }
        
        // Обработка HTTP ошибок (4xx, 5xx)
        if ($httpCode >= 400) {
            throw new Exception("HTTP error {$httpCode}: " . $response, $httpCode);
        }
        
        // Парсинг JSON ответа
        if (strpos($contentType, 'application/json') !== false) {
            $decodedResponse = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('JSON parsing error: ' . json_last_error_msg());
            }
            return [
                'status' => 'success',
                'code' => $httpCode,
                'data' => $decodedResponse,
                'raw' => $response
            ];
        }
        
        return [
            'status' => 'success',
            'code' => $httpCode,
            'data' => $response,
            'raw' => $response
        ];
        
    } catch (Exception $e) {
        return [
            'status' => 'error',
            'code' => $e->getCode() ?: 500,
            'message' => $e->getMessage(),
            'raw' => $response ?? null
        ];
    } finally {
        curl_close($ch);
    }
}

// Примеры использования

echo "<h2>Обработка ответов и ошибок</h2>";

// 1. Успешный запрос с парсингом JSON
echo "<h3>1. Успешный GET-запрос с JSON</h3>";
$result = sendHttpRequest('https://jsonplaceholder.typicode.com/posts/1');
if ($result['status'] === 'success') {
    echo "<p>Статус: {$result['code']}</p>";
    echo "<pre>" . print_r($result['data'], true) . "</pre>";
} else {
    echo "<p style='color:red'>Ошибка: {$result['message']}</p>";
}

// 2. Обработка HTTP ошибок (4xx)
echo "<h3>2. Обработка 404 ошибки</h3>";
$result = sendHttpRequest('https://jsonplaceholder.typicode.com/nonexistent');
if ($result['status'] === 'success') {
    echo "<pre>" . print_r($result['data'], true) . "</pre>";
} else {
    echo "<p style='color:red'>Ошибка {$result['code']}: {$result['message']}</p>";
}

// 3. Обработка исключений cURL (неправильный URL)
echo "<h3>3. Обработка ошибок cURL</h3>";
$result = sendHttpRequest('https://nonexistentdomain12345.com');
if ($result['status'] === 'success') {
    echo "<pre>" . print_r($result['data'], true) . "</pre>";
} else {
    echo "<p style='color:red'>Ошибка {$result['code']}: {$result['message']}</p>";
}

// 4. Успешный POST-запрос
echo "<h3>4. Успешный POST-запрос</h3>";
$postData = [
    'title' => 'Новый пост',
    'body' => 'Содержание поста',
    'userId' => 1
];
$result = sendHttpRequest(
    'https://jsonplaceholder.typicode.com/posts', 
    'POST', 
    $postData,
    ['Content-Type: application/json']
);
if ($result['status'] === 'success') {
    echo "<p>Статус: {$result['code']}</p>";
    echo "<pre>" . print_r($result['data'], true) . "</pre>";
} else {
    echo "<p style='color:red'>Ошибка: {$result['message']}</p>";
}

/* Пояснения к реализации:
1. Обработка успешного ответа и парсинг JSON
Функция sendHttpRequest проверяет Content-Type ответа

Если ответ содержит JSON, автоматически парсит его в массив

Возвращает структурированный результат с кодом ответа, данными и сырым ответом

2. Обработка HTTP ошибок (4xx, 5xx)
Проверяется HTTP-код ответа

При кодах 4xx и 5xx генерируется исключение с соответствующим сообщением

В результат включается код ошибки и сообщение

3. Обработка исключений cURL
Все операции cURL обернуты в try-catch блок

Обрабатываются как ошибки cURL (curl_errno), так и другие исключения

Возвращается понятное сообщение об ошибке

Дополнительные особенности:
Поддержка различных HTTP-методов (GET, POST, PUT, DELETE и др.)

Возможность отправки данных в разных форматах

Добавление кастомных заголовков

Обработка HTTPS соединений

Возвращение унифицированного формата ответа*/

?>