<?php
class RestService {
    private $apiEndpoint;
    private $accessKey;
    private $authMethod; // 'key' или 'credentials'
    private $login;
    private $secret;
    private $standardHeaders = [
        'Accept: application/json',
        'Content-Type: application/json'
    ];

    public function __construct($baseUrl, $authSettings = []) {
        $this->apiEndpoint = rtrim($baseUrl, '/');
        
        // Конфигурация авторизации
        if (isset($authSettings['apiKey'])) {
            $this->authMethod = 'key';
            $this->accessKey = $authSettings['apiKey'];
        } elseif (isset($authSettings['login']) && isset($authSettings['secret'])) {
            $this->authMethod = 'credentials';
            $this->login = $authSettings['login'];
            $this->secret = $authSettings['secret'];
        }
    }

    public function fetch($path, $query = []) {
        $url = $this->prepareUrl($path, $query);
        return $this->executeRequest('GET', $url);
    }

    public function create($path, $payload, $query = []) {
        $url = $this->prepareUrl($path, $query);
        return $this->executeRequest('POST', $url, $payload);
    }

    public function update($path, $payload, $query = []) {
        $url = $this->prepareUrl($path, $query);
        return $this->executeRequest('PUT', $url, $payload);
    }

    public function remove($path, $query = []) {
        $url = $this->prepareUrl($path, $query);
        return $this->executeRequest('DELETE', $url);
    }

    private function prepareUrl($path, $query) {
        $url = $this->apiEndpoint . '/' . ltrim($path, '/');
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        return $url;
    }

    private function executeRequest($verb, $url, $content = null) {
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $verb);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        // Устанавливаем заголовки
        $headers = $this->standardHeaders;
        
        // Добавляем авторизацию
        if ($this->authMethod === 'key' && $this->accessKey) {
            $headers[] = 'Authorization: Token ' . $this->accessKey;
        } elseif ($this->authMethod === 'credentials' && $this->login && $this->secret) {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $this->login . ':' . $this->secret);
        }
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        // Добавляем содержимое для POST/PUT
        if (in_array($verb, ['POST', 'PUT']) && $content) {
            $jsonContent = json_encode($content);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonContent);
        }
        
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new RuntimeException("Ошибка соединения: $error");
        }
        
        curl_close($curl);
        
        // Анализ ответа
        if (strpos($type, 'application/json') !== false) {
            $parsed = json_decode($result, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Ошибка декодирования JSON: ' . json_last_error_msg());
            }
            return $parsed;
        }
        
        return $result;
    }
}

// Пример использования с News API
class NewsReader {
    private $service;
    private $newsKey = 'ваш_ключ_api'; // Замените на реальный ключ

    public function __construct() {
        $this->service = new RestService('https://newsapi.org/v2', [
            'apiKey' => $this->newsKey
        ]);
    }

    public function getHeadlines($category = 'general') {
        try {
            $response = $this->service->fetch('/top-headlines', [
                'category' => $category,
                'country' => 'ru',
                'apiKey' => $this->newsKey
            ]);
            
            return $this->formatNews($response);
        } catch (RuntimeException $e) {
            return "Не удалось получить новости: " . $e->getMessage();
        }
    }

    private function formatNews($data) {
        if (!isset($data['articles']) {
            return "Новости не найдены";
        }
        
        $output = "<h3>Последние новости</h3>";
        foreach ($data['articles'] as $article) {
            $output .= sprintf(
                "<div style='margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;'>
                    <h4>%s</h4>
                    <p>%s</p>
                    <small>Источник: %s</small>
                </div>",
                htmlspecialchars($article['title']),
                htmlspecialchars($article['description'] ?? ''),
                htmlspecialchars($article['source']['name'])
            );
        }
        return $output;
    }
}

// Демонстрация работы
echo "<h2>Чтение новостей через API</h2>";

$newsApp = new NewsReader();
echo $newsApp->getHeadlines('technology');

// Пример с Basic Auth
echo "<h2>Демонстрация авторизации</h2>";

$authDemo = new RestService('https://jsonplaceholder.typicode.com', [
    'login' => 'demo',
    'secret' => 'password123'
]);

try {
    $users = $authDemo->fetch('/users');
    echo "<p>Получено пользователей: " . count($users) . "</p>";
    echo "<pre>" . print_r($users[0], true) . "</pre>";
} catch (RuntimeException $e) {
    echo "<p style='color:red'>Ошибка: " . $e->getMessage() . "</p>";
}
?>