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
    <?php
    $surname = "null";
    $name = "null";
    if(isset($_POST["surname"])){
        $surname = strip_tags($_POST["surname"]);
    }
    if(isset($_POST["name"])){
        $name = htmlentities($_POST["name"]);
    }
    ?>
    <tbody>
    <tr>
        <td><?php echo $surname?></td>
        <td><?php echo $name ?></td>
        <td>Автор книги</td>
        <td>Назва книги</td>
        <td>К-сть сторінок</td>
        <td>Рік видання</td>
        <td>Назва видавництва</td>
        <td>Видавництво</td>
        <td>Дата поступлення</td>
    </tr>
    </tbody>
#з форми відправляється в файл, а з файлу уже в таблицю
</table>
<form action="" method="POST">
    <div class="form">
    <label>Прізвище</label><br>
    <input type="text" name="surname"/><br>
    <label>Ім'я</label><br>
    <input type="text" name="name"/><br>
    <label>Автор</label><br>
    <input type="text" name="author"/><br>
    <label>Назва книги</label><br>
    <input type="text" name="bookName"/><br>
    <label>К-сть сторінок</label><br>
    <input type="number" name="numberPages"/><br>
    <label>Дата публікації</label><br>
    <input type="date" name="datePublication"/><br>
    <label>Назва видавництва</label><br>
    <input type="text" name="namePublisher"/><br>
    <label>Видавник</label><br>
    <input type="text" name="publisher"/><br>
    <label>Дата поступлення у фонд</label><br>
    <input type="date" name="dateReceipt"/><br>
        <input type="submit" value="Подати">
    </div>
</form>
</body>
</html>
