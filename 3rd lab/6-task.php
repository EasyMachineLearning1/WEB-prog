<?php

$a = 10;
$b = 3;
echo $a % $b;


echo "\n a:9056 ";
$a = 9056;
echo "b: 124";
$b = 124;
if ($a % $b == 0) {
    echo "Делится ", $a / $b, "\n";
} 
else {
    echo "Делится с остатком", $a % $b, "\n";
}


$st = 2**10;
echo "2 в десятой стпени: ", $st;

$sqrtSt = 245**1/2;
echo "\n Корень из числа 245: ", $sqrtNum;

$array = array(4, 2, 5, 19, 13, 0, 10);
$ans = 0;
foreach ($array as $el) {
    $ans += $el**2;
}

echo "\nКорень из суммы квадратов: ", sqrt($ans), "\n";


$a = sqrt(379);
$sqrt0 = round($a);
echo "\n $sqrt0";

$sqrt1 = round($a, 1);
echo "\n $sqrt1";
$sqrt2 = round($a, 2);
echo "\n $sqrt2 \n";

$b = sqrt(587);
$arrayB = ['floor' => floor($b), 'ceil' => ceil($b)];

$num1 = 513796754;
$num2 = 47;
echo "abs(a - b) = ", abs($num1 - $num2);
echo "\nabs(b - a) = ", abs($num2 - $num1), "\n";

$arr = [1, 2, -1, -2, 3, -3];
$newArr = array_map('abs', $arr);
var_dump($newArr);


$array = [4, -2, 5, 19, -130, 0, 10];
echo "минимум: ", min($array), "\n максимум: ", max($array), "\n";


echo "Случайное от 1 до 100: ", rand(1, 100), "\n";

$arrayRand = [];
for ($i = 0; $i < 10; $i++) {
    $arrayRand[$i] = rand(1, 100);
}




echo "Необходимо найти делители числа: 30 \n";
$number = 30;

$divisors = array();
    
  
for ($i = 1; $i <= sqrt($number); $i++) {
    if ($number % $i == 0) {
        $divisors[] = $i;
        if ($i != $number / $i) {
            $divisors[] = $number / $i;
        }
    }
}


print_r($divisors);


$array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$sum = 0;
$flag = 0;

foreach ($array as $number) {
    $sum += $number;
    $flag++;
    
    if ($sum > 10) {
        break;
    }
}

echo "Нужно сложить первые $flag элементов, чтобы сумма ($sum) стала больше 10";