<?php
$array = [];
for ($i = 1; $i <= 5; $i++) {
    $array[] = str_repeat('x', $i);
}
print_r($array);

function arrayFill($value, $count) {
    return array_fill(0, $count, $value);
}
print_r(arrayFill('x', 5));

$array = [[1, 2, 3], [4, 5], [6]];
$sum = 0;
foreach ($array as $subArray) {
    $sum += array_sum($subArray);
}

$array = [];
$value = 1;
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        $array[$i][$j] = $value++;
    }
}
print_r($array);

$array = [2, 5, 3, 9];
$result = ($array[0] * $array[1]) + ($array[2] * $array[3]);
echo $result; 

$user = [
    'name' => 'Иван',
    'surname' => 'Петров',
    'patronymic' => 'Сергеевич'
];
echo "{$user['surname']} {$user['name']} {$user['patronymic']}";


$date = [
    'year' => date('Y'),
    'month' => date('m'),
    'day' => date('d')
];
echo "{$date['year']}-{$date['month']}-{$date['day']}";

$arr = ['a', 'b', 'c', 'd', 'e'];
echo count($arr); // Выведет 5

echo end($arr);

echo $arr[count($arr) - 2];

echo $sum;