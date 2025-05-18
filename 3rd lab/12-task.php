<?php

$numbers = [1, 2, 3, 4, 5];
$average = array_sum($numbers) / count($numbers);
echo $average; // 3

$sum = array_sum(range(1, 100));
echo $sum; // 5050

$numbers = [1, 4, 9, 16];
$roots = array_map('sqrt', $numbers);
print_r($roots); // [1, 2, 3, 4]

$letters = range('a', 'z');
$numbers = range(1, 26);
$alphabet = array_combine($letters, $numbers);
print_r($alphabet); 

$str = '1234567890';
$pairs = str_split($str, 2);
$sum = array_sum($pairs);
echo $sum;