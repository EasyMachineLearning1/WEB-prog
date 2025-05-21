<?php
// 1. GET-запрос с кастомными HTTP-заголовками
function getWithCustomHeaders($url, $headers = []) {
    $defaultHeaders = [
        'Accept: application/json',
        'Cache-Control: no-cache'
    ];
    
    $allHeaders = array_merge($defaultHeaders, $headers);
    
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => implode("\r\n", $allHeaders)
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    if ($response === false) {
        return "Ошибка при выполнении GET-запроса с кастомными заголовками";
    }
    
    return json_decode($response, true);
}

/*1. GET-запрос с кастомными HTTP-заголовками
Функция getWithCustomHeaders() принимает URL и массив заголовков,
объединяет их с заголовками по умолчанию и выполняет запрос.
Пример показывает добавление заголовков X-Custom-Header и Authorization.*/




// 2. Отправка JSON-данных в теле запроса
function sendJsonRequest($url, $method, $data) {
    $jsonData = json_encode($data);
    
    $options = [
        'http' => [
            'header' => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Content-Length: ' . strlen($jsonData)
            ],
            'method' => $method,
            'content' => $jsonData
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    if ($response === false) {
        return "Ошибка при выполнении $method-запроса с JSON-данными";
    }
    
    return json_decode($response, true);
}
/*2. 
Отправка JSON-данных в теле запроса
Функция sendJsonRequest() принимает URL, метод (GET, POST, PUT и т.д.) и данные для отправки.
Данные преобразуются в JSON и отправляются с соответствующими заголовками.
Пример показывает создание нового поста через POST-запрос. 
*/



// 3. Отправка запроса с параметрами URL
function sendRequestWithQueryParams($url, $params, $method = 'GET') {
    $queryString = http_build_query($params);
    $fullUrl = $url . (strpos($url, '?') === false ? '?' : '&') . $queryString;
    
    $options = [
        'http' => [
            'method' => $method,
            'header' => 'Accept: application/json'
        ]
    ];
    
    // Для POST-запросов с параметрами URL
    if ($method === 'POST') {
        $options['http']['header'] .= "\r\nContent-Type: application/x-www-form-urlencoded";
    }
    
    $context = stream_context_create($options);
    $response = file_get_contents($fullUrl, false, $context);
    
    if ($response === false) {
        return "Ошибка при выполнении $method-запроса с параметрами URL";
    }
    
    return json_decode($response, true);
}
/*3. Запрос с параметрами URL
Функция sendRequestWithQueryParams() формирует URL с query-параметрами и выполняет запрос. 
Поддерживает как GET, так и POST-запросы.
Примеры показывают:
    Фильтрацию постов по userId с лимитом (GET)
    Создание поста через параметры URL (POST)
Все функции возвращают ассоциативный массив с ответом от сервера или сообщение об ошибке. 
*/



// Примеры использования функций

echo "<h2>Работа с заголовками и параметрами запросов</h2>";

// 1. Пример GET-запроса с кастомными заголовками
echo "<h3>1. GET с кастомными заголовками</h3>";
$customHeaders = [
    'X-Custom-Header: MyValue',
    'Authorization: Bearer test123'
];
$posts = getWithCustomHeaders('https://jsonplaceholder.typicode.com/posts/1', $customHeaders);
echo "<pre>" . print_r($posts, true) . "</pre>";

// 2. Пример отправки JSON-данных (POST)
echo "<h3>2. Отправка JSON-данных (POST)</h3>";
$newPost = [
    'title' => 'Мой новый пост',
    'body' => 'Содержание нового поста',
    'userId' => 1
];
$createdPost = sendJsonRequest('https://jsonplaceholder.typicode.com/posts', 'POST', $newPost);
echo "<pre>" . print_r($createdPost, true) . "</pre>";

// 3. Пример запроса с параметрами URL (GET)
echo "<h3>3. Запрос с параметрами URL (GET)</h3>";
$params = [
    'userId' => 1,
    '_limit' => 3
];
$filteredPosts = sendRequestWithQueryParams('https://jsonplaceholder.typicode.com/posts', $params);
echo "<pre>" . print_r($filteredPosts, true) . "</pre>";

// 3a. Пример POST-запроса с параметрами URL
echo "<h3>3a. POST с параметрами URL</h3>";
$postParams = [
    'title' => 'Пост через параметры',
    'body' => 'Содержание через параметры',
    'userId' => 1
];
$postResult = sendRequestWithQueryParams('https://jsonplaceholder.typicode.com/posts', $postParams, 'POST');
echo "<pre>" . print_r($postResult, true) . "</pre>";
?>