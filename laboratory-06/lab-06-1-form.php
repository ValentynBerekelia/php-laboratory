<?php require '../laboratory-06/lab-06-db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab2</title>
    <link rel="stylesheet" href="../laboratory-06/style-06.css">
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
                <input type="number"  name="numberPages" id="numberPages" required /><br>
                <label>Дата публікації</label><br>
                <input type="date" name="datePublication" id="dateOfPublisher" required /><br>
                <label>Назва видавництва</label><br>
                <input type="text" name="namePublisher" id="namePublisher" required maxlength="10"/><br>
                <label>Видавник</label><br>
                <input type="text" name="publisher" id="publisher" required maxlength="10"/><br>
                <label>Дата поступлення у фонд</label><br>
                <input type="date" name="dateReceipt" id="dateReceipt" required /><br>
                <input type="submit" value="Submit">
                <input type="reset" value="Reset"/>
                <button onclick="window.location.href='../laboratory-06/lab-06-1-table.php'">View</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>