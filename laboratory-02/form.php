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
    <link rel="stylesheet" href="../form_style.css">
</head>
<body>
<div class="background">
    <div class="content">
<div class="context-form">
        <form action="" method="POST">
                <label>Ім'я</label><br>
                <input type="text" name="name" id="name" required minlength="1"/><br>
                <label>Прізвище</label><br>
                <input type="text" name="surname" id="surname" required  minlength="1"/><br>
                <label>Автор</label><br>
                <input type="text" name="author" id="author" required minlength="1"/><br>
                <label>Назва книги</label><br>
                <input type="text" name="bookName" id="bookName" required minlength="5"/><br>
                <label>К-сть сторінок</label><br>
                <input type="number"  name="numberPages" id="numberPages" required min="1" max="20"/><br>
                <label>Дата публікації</label><br>
                <input type="date" name="datePublication" id="dateOfPublisher" required /><br>
                <label>Назва видавництва</label><br>
                <input type="text" name="namePublisher" id="namePublisher" required maxlength="10"/><br>
                <label>Видавник</label><br>
                <input type="text" name="publisher" id="publisher" required maxlength="10"/><br>
                <label>Дата поступлення у фонд</label><br>
                <input type="date" name="dateReceipt" id="dateReceipt" required maxlength="10"/><br>
                <input type="submit" value="Submit">
                <input type="reset" value="Reset"/>
            <button onclick="window.location.href='table.php'">View</button>
        </form>
    </div>
    </div>
</div>
</body>
</html>
