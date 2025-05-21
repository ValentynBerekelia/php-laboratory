<?php
global $pdo;
require '../laboratory-06/lab-06-db_connect.php';
$sql = "
    SELECT 
        a.id,
        a.surname,
        a.name,
        (a.surname || ' ' || a.name) AS author,
        b.book_name,
        b.number_pages,
        b.date_published,
        p.name AS publisher,
        b.date_received,
        b.created_at
    FROM books b
    JOIN authors a ON b.author_id = a.id
    JOIN publishers p ON b.publisher_id = p.id
    ORDER BY b.number_pages ASC
";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style-06.css" />
    <title>lab05</title>
</head>
<body>
<div class="background">
    <ul>
        <li><a href="../laboratory-01/Home.php">Home</a></li>
        <li><a href="../laboratory-06/lab-06-1-form.php">Add data</a></li>
    </ul>
    <div class="context-table">
        <table>
            <thead>
            <tr>
                <th>ID</th>
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
