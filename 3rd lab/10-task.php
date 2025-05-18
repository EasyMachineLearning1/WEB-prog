<?php
function checkSum($num1, $num2) {
    return ($num1 + $num2) > 10;
}

function compareNumbers($first, $second) {
    return $first === $second;
}

if ($test == 0) echo 'верно';

$age = 25; // пример значения

if ($age < 10 || $age > 99) {
    echo 'Число меньше 10 или больше 99';
} else {
    $sum = array_sum(str_split($age));
    echo $sum <= 9 ? 'Сумма цифр однозначна' : 'Сумма цифр двузначна';
}

$arr = [1, 2, 3]; // пример массива

if (count($arr) == 3) {
    echo array_sum($arr);
}