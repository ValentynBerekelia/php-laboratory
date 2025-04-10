<?php
require 'rw_file.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_entry = [
        $_POST["surname"],
        $_POST["name"],
        $_POST["author"],
        $_POST["bookName"],
        $_POST["numberPages"],
        $_POST["datePublication"],
        $_POST["namePublisher"],
        $_POST["publisher"],
        $_POST["dateReceipt"]
    ];

    write_to_file("file.txt", $new_entry);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
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
    <?php foreach (read_from_file("file.txt") as $element): ?>
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
</div>
</body>
</html>