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
    <div class="context-form">

    <form action="" method="POST">
    <div class="form">
        <label>Прізвище</label><br>
        <input type="text" name="surname" id="surname" required  maxlength="15"/><br>
        <label>Ім'я</label><br>
        <input type="text" name="name" id="name" required maxlength="15"/><br>
        <label>Автор</label><br>
        <input type="text" name="author" id="author" required maxlength="20"/><br>
        <label>Назва книги</label><br>
        <input type="text" name="bookName" id="bookName" required maxlength="20"/><br>
        <label>К-сть сторінок</label><br>
        <input type="number" name="numberPages" id="numberPages" required maxlength="10"/><br>
        <label>Дата публікації</label><br>
        <input type="date" name="datePublication" id="dateOfPublisher" required maxlength="10"/><br>
        <label>Назва видавництва</label><br>
        <input type="text" name="namePublisher" id="namePublisher" required maxlength="10"/><br>
        <label>Видавник</label><br>
        <input type="text" name="publisher" id="publisher" required maxlength="10"/><br>
        <label>Дата поступлення у фонд</label><br>
        <input type="date" name="dateReceipt" id="dateReceipt" required maxlength="10"/><br>
        <input type="submit" value="Подати">
    </div>
</form>
<a href="main.php">Home</a>
    </div>
</div>
</body>
</html>
