<?php
// 1. GET-запрос для получения списка постов
function getPosts() {
    $url = 'https://jsonplaceholder.typicode.com/posts';
    $response = file_get_contents($url);
    
    if ($response === false) {
        return "Ошибка при выполнении GET-запроса";
    }
    
    $posts = json_decode($response, true);
    return "GET-запрос успешен. Первый пост: " . $posts[0]['title'];
}

// 2. POST-запрос для создания нового поста
function createPost() {
    $url = 'https://jsonplaceholder.typicode.com/posts';
    $data = [
        'title' => 'Новый пост',
        'body' => 'Содержание нового поста',
        'userId' => 1
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    if ($response === false) {
        return "Ошибка при выполнении POST-запроса";
    }
    
    $newPost = json_decode($response, true);
    return "POST-запрос успешен. Создан пост с ID: " . $newPost['id'];
}

// 3. PUT-запрос для обновления поста
function updatePost($postId) {
    $url = 'https://jsonplaceholder.typicode.com/posts/' . $postId;
    $data = [
        'id' => $postId,
        'title' => 'Обновленный пост',
        'body' => 'Обновленное содержание поста',
        'userId' => 1
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'PUT',
            'content' => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    if ($response === false) {
        return "Ошибка при выполнении PUT-запроса";
    }
    
    $updatedPost = json_decode($response, true);
    return "PUT-запрос успешен. Обновлен пост с ID: " . $updatedPost['id'];
}

// 4. DELETE-запрос для удаления поста
function deletePost($postId) {
    $url = 'https://jsonplaceholder.typicode.com/posts/' . $postId;
    
    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'DELETE'
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    if ($response === false) {
        return "Ошибка при выполнении DELETE-запроса";
    }
    
    return "DELETE-запрос успешен. Пост с ID $postId удален";
}
// Выполнение всех запросов
echo "<h2>Работа с JSONPlaceholder API</h2>";

echo "<h3>1. GET-запрос</h3>";
echo getPosts();

echo "<h3>2. POST-запрос</h3>";
echo createPost();

echo "<h3>3. PUT-запрос (обновление поста с ID 1)</h3>";
echo updatePost(1);

echo "<h3>4. DELETE-запрос (удаление поста с ID 1)</h3>";
echo deletePost(1);
/* GET-запрос: Использует file_get_contents() для получения списка постов. Возвращает первый пост из списка.

POST-запрос: Создает новый пост, отправляя JSON-данные с помощью потока (stream context).

PUT-запрос: Обновляет существующий пост (в примере с ID 1), заменяя его новыми данными.

DELETE-запрос: Удаляет пост с указанным ID (в примере с ID 1). */

?>
