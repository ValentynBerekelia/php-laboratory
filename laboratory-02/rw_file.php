<?php
function write_to_file($filename, $data) {
    $fp = fopen($filename, "a");
    $quoted_data = array_map(function($item) {
        return '"' . str_replace('"', '""', $item) . '"';
    }, $data);

    fwrite($fp, implode(";", $quoted_data) . "\n");
    fclose($fp);
}

function read_from_file($filename) {
    $result = [];
    if (file_exists($filename)) {
        $fp = fopen($filename, "r");
        while (($line = fgetcsv($fp, 1000, ";")) !== false) {
            $result[] = $line;
        }
        fclose($fp);
    }
    return $result;
}
