<?php
function increaseEnthusiasm($str) {
    return $str . "!";
}


echo increaseEnthusiasm("Hello, world");

function repeatThreeTimes($str) {
    return $str . $str . $str; /
}


echo repeatThreeTimes("Hello");

echo increaseEnthusiasm(repeatThreeTimes("Wow"));

function cut($str, $length = 10) {
    return substr($str, 0, $length);
}

echo cut("Hello, world!");
echo cut("Hello, world!", 5);

function printArrayRecursively($array, $index = 0) {
    if ($index < count($array)) {
        echo $array[$index] . "\n";
        printArrayRecursively($array, $index + 1);
    }
}

$numbers = [1, 2, 3, 4, 5];
printArrayRecursively($numbers);


function sumDigits($number) {
    while ($number > 9) {
        $number = array_sum(str_split((string)$number));
    }
    return $number;
}

echo sumDigits(98726);   
  