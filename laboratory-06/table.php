<?php
global $pdo;
require '../laboratory-06/lab-06-db_connect.php';

$sql = "
    SELECT 
        b.id AS book_id,
        b.author,
        b.book_name,
        b.number_pages,
        b.date_published,
        b.publisher,
        r.date_received,
        r.created_at,
        p.surname AS person_surname,
        p.name AS person_name
    FROM books b
    LEFT JOIN receipts r ON b.id = r.book_id
    LEFT JOIN persons p ON r.person_id = p.id
    ORDER BY b.number_pages ASC
";

$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../laboratory-06/style-06.css">
    <title>Lab2</title>
</head>
<body>
<div class="background">
    <ul>
        <li><a href="../laboratory-01/Home.php">Home</a></li>
        <li><a href="form-home-page.php">Add data</a></li>
    </ul>
    <div class="context-table">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Прізвище</th>
                <th>Ім'я</th>
                <th>Автор</th>
                <th>Назва книги</th>
                <th>Сторінок</th>
                <th>Дата публікації</th>
                <th>Видавництво</th>
                <th>Дата отримання</th>
                <th>Створено</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($books) && !empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['book_id']) ?></td>
                        <td><?= htmlspecialchars($book['person_surname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($book['person_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['book_name']) ?></td>
                        <td><?= htmlspecialchars($book['number_pages']) ?></td>
                        <td><?= htmlspecialchars($book['date_published']) ?></td>
                        <td><?= htmlspecialchars($book['publisher']) ?></td>
                        <td><?= htmlspecialchars($book['date_received'] ?? 'Не видана') ?></td>
                        <td><?= htmlspecialchars($book['created_at'] ?? '') ?></td>
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