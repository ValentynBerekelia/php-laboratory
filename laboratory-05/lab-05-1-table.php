<?php
global $pdo;
require '../laboratory-05/lab-05-db_connect.php';

$sql = "SELECT * FROM books ORDER BY number_pages ASC";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style05.css" />
    <title>lab05</title>
</head>
<body>
<div class="background">
    <ul>
        <li><a href="../laboratory-01/Home.php">Home</a></li>
        <li><a href="lab-05-1-form.php">Add data</a></li>
    </ul>
    <div class="context-table">
        <table>
            <thead>
            <tr>
                <td>ID</td>
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
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['id']) ?></td>
                        <td><?= htmlspecialchars($book['surname']) ?></td>
                        <td><?= htmlspecialchars($book['name']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['book_name']) ?></td>
                        <td><?= htmlspecialchars($book['number_pages']) ?></td>
                        <td><?= htmlspecialchars($book['date_published']) ?></td>
                        <td><?= htmlspecialchars($book['publisher']) ?></td>
                        <td><?= htmlspecialchars($book['date_received']) ?></td>
                        <td><?= htmlspecialchars($book['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">Книг не знайдено</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
