<?php
session_start(); // Запускаем сессию



$_SESSION['user_data'] = [
    'first_name' => "FirstName",
    'last_name'  => "LastName",
    'age'        => "Age"
];


// Проверяем, есть ли данные в сессии
if (isset($_SESSION['user_data'])) {
    $user = $_SESSION['user_data'];
} else {
    die("Данные не найдены. Вернитесь на <a href='form.php'>форму</a>.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ваш профиль</title>
</head>
<body>
    <h2>Ваши данные:</h2>
    <p><strong>Имя:</strong> <?= htmlspecialchars($user['first_name']) ?></p>
    <p><strong>Фамилия:</strong> <?= htmlspecialchars($user['last_name']) ?></p>
    <p><strong>Возраст:</strong> <?= htmlspecialchars($user['age']) ?></p>
    
    <a href="form.php">Вернуться к форме</a>
</body>
</html>