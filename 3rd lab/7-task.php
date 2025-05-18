<?php
function printStringReturnNumber() {
    echo "Hello, world!\n"; // Печатаем строку
    return 123456789; // Возвращаем числовое значение (например, 42)
}

$my_num = printStringReturnNumber(); // Сохраняем возвращаемое значение
echo $my_num;
