
<?php
$text = "Text from textarea";

// Символы (включая пробелы)
$charCount = preg_match_all('/./su', $text);

// Символы (без пробелов)
$charCountNoSpaces = preg_match_all('/[^\s]/u', $text);

// Слова (буквы + числа)
$wordCount = preg_match_all('/[\p{L}\d]+/u', $text);

echo "Символов (всего): $charCount\n";
echo "Символов (без пробелов): $charCountNoSpaces\n";
echo "Слов: $wordCount";
?>