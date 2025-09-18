<?php
$str = 'abba adca aeb abea aeeb adcb axeb';
$pattern = '/a..a/'; // Регулярка: 'a', затем 2 любых символа, затем 'a'

preg_match_all($pattern, $str, $matches);

print_r($matches[0]); // Выводим найденные совпадения
?>