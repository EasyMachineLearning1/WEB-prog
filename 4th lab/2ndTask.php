<?php
$str = 'a1b2c3';

// Используем preg_replace_callback для замены с вычислением
$result = preg_replace_callback(
    '/\d+/', // Ищем одно или более цифр подряд
    function ($matches) {
        $number = $matches[0];
        echo $matches[0]; // Получаем найденное число
        $cube = $number * $number * $number; // Вычисляем куб
        return $cube; // Возвращаем куб для замены
    },
    $str
);

echo $result; // Выведет: a1b8c27
?>