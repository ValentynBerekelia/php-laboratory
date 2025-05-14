<?php
require 'rw_file.php';

$data = read_from_file("file.txt");
usort($data, function($a, $b) {
    return intval($a[4]) <=> intval($b[4]);
});

$authors = array_column($data, 2);
$unique_authors = array_unique($authors);
$author_count = count($unique_authors);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Lab2</title>
    <link rel="stylesheet" href="form_style.css">
</head>
<body>
<div class="background">
    <ul>
        <li><a href="Home.php">Home</a></li>
        <li><a href="form.php">Add data</a></li>
    </ul>

    <h3>Кількість унікальних авторів: <?= $author_count ?></h3>

    <div class="context-table">
        <table>
            <thead>
            <tr>
                <td>Прізвище</td>
                <td>Ім'я</td>
                <td>Автор книги</td>
                <td>Назва книги</td>
                <td>К-сть сторінок</td>
                <td>Рік видання</td>
                <td>Назва видавництва</td>
                <td>Видавництво</td>
                <td>Дата поступлення</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $element): ?>
                <tr>
                    <?php foreach ($element as $item): ?>
                        <td><?= htmlspecialchars($item) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
