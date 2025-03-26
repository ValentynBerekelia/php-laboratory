<?php
function read_from_file($filename) {
    if (!file_exists($filename)) {
        $fp = fopen($filename, "w");
        fwrite($fp, "Беркеля;Валентин;Саймон Бекетт;Хімія смерті;159;2011-05-11;UABooks;UABooks;2025-03-26\n");
        fclose($fp);
    }

    $fp = fopen($filename, "r");
    $data = []; // Ініціалізація порожнього масиву

    while (($arr = fgetcsv($fp, 1000, ";")) !== false) { // Використовуємо fgetcsv()
        $data[] = $arr;
    }

    fclose($fp);
    return $data;
}

function write_to_file($filename, $arr) {
    $fp = fopen($filename, "a");
    $string = implode(";", $arr) . "\n"; // Додаємо новий рядок
    fwrite($fp, $string);
    fclose($fp);
}
?>
