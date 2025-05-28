<?php
global $pdo;
require '../laboratory-06/lab-06-db_connect.php';

$search = $_GET['search'] ?? '';

$authorCountSql = "SELECT COUNT(DISTINCT author) as author_count FROM books";
$authorCountStmt = $pdo->query($authorCountSql);
$authorCount = $authorCountStmt->fetch(PDO::FETCH_ASSOC)['author_count'];

if ($search !== '') {
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
        WHERE b.book_name LIKE :search
        ORDER BY b.number_pages ASC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':search' => "%$search%"]);
} else {
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
}

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../laboratory-06/style-06.css" />
    <title>Lab2</title>
</head>
<body>
<div class="background">
    <ul>
        <li><a href="../laboratory-01/Home.php">Home</a></li>
    </ul>
    <form method="GET" action="">
        <label for="search">Пошук за назвою книги:</label>
        <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>" />
        <button type="submit">Пошук</button>
        <button type="button" onclick="window.location.href='<?= basename(__FILE__) ?>'">Очистити</button>
    </form>

    <div class="context-table">
        <h3>Кількість різних авторів: <?= $authorCount ?></h3>
        <table>
            <thead>
            <tr>
                <th>ID книги</th>
                <th>Автор</th>
                <th>Назва книги</th>
                <th>К-сть сторінок</th>
                <th>Рік видання</th>
                <th>Видавництво</th>
                <th>Дата поступлення</th>
                <th>Дата створення</th>
                <th>Прізвище читача</th>
                <th>Ім'я читача</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['book_id']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['book_name']) ?></td>
                        <td><?= htmlspecialchars($book['number_pages']) ?></td>
                        <td><?= htmlspecialchars($book['date_published']) ?></td>
                        <td><?= htmlspecialchars($book['publisher']) ?></td>
                        <td><?= htmlspecialchars($book['date_received'] ?? 'Не видана') ?></td>
                        <td><?= htmlspecialchars($book['created_at'] ?? '') ?></td>
                        <td><?= htmlspecialchars($book['person_surname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($book['person_name'] ?? '') ?></td>
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