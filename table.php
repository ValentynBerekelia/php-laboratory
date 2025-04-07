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
    <link rel="stylesheet" href="style.css">
</head>
<body>

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

<form action="" method="POST">
    <div class="form">
        <label>Прізвище</label><br>
        <input type="text" name="surname" id="surname" required/><br>
        <label>Ім'я</label><br>
        <input type="text" name="name" id="name" required/><br>
        <label>Автор</label><br>
        <input type="text" name="author" id="author" required/><br>
        <label>Назва книги</label><br>
        <input type="text" name="bookName" id="bookName" required/><br>
        <label>К-сть сторінок</label><br>
        <input type="number" name="numberPages" id="numberPages" required/><br>
        <label>Дата публікації</label><br>
        <input type="date" name="datePublication" id="dateOfPublisher" required/><br>
        <label>Назва видавництва</label><br>
        <input type="text" name="namePublisher" id="namePublisher" required/><br>
        <label>Видавник</label><br>
        <input type="text" name="publisher" id="publisher" required/><br>
        <label>Дата поступлення у фонд</label><br>
        <input type="date" name="dateReceipt" id="dateReceipt" required/><br>
        <input type="submit" value="Подати">
    </div>
</form>
<a href="main.php">Home</a>
</body>
</html>
