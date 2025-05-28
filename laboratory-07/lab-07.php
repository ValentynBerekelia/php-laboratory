<?php
global $pdo;
require '../laboratory-06/lab-06-db_connect.php';
require 'Book.php';

$message = '';
$searchResults = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newBook = new Book($pdo);
    $newBook->setAuthor($_POST['author']);
    $newBook->setBookName($_POST['bookName']);
    $newBook->setNumberPages($_POST['numberPages']);
    $newBook->setDatePublished($_POST['datePublished']);
    $newBook->setPublisher($_POST['publisher']);

    if ($newBook->save()) {
        $message = "Книгу успішно додано!";
    } else {
        $message = "Помилка при додаванні книги.";
    }
}

if (isset($_GET['searchPublisher'])) {
    $searchResults = Book::findByPublisher($pdo, $_GET['searchPublisher']);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-07.css">
    <title>Лабораторна робота №7</title>
</head>
<body>
<div class="background">
    <ul>
        <li><a href="../laboratory-01/Home.php">Home</a></li>
    </ul>
    <div class="context-form">
        <h2>Робота з класом Book</h2>
        
        <?php if ($message): ?>
            <div class="message <?= strpos($message, 'успішно') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <h3>Додати нову книгу</h3>
            <form method="POST" action="">
                <label>Автор:</label>
                <input type="text" name="author" required>
                
                <label>Назва книги:</label>
                <input type="text" name="bookName" required>
                
                <label>Кількість сторінок:</label>
                <input type="number" name="numberPages" required>
                
                <label>Дата публікації:</label>
                <input type="date" name="datePublished" required>
                
                <label>Видавництво:</label>
                <input type="text" name="publisher" required>
                
                <input type="submit" value="Додати книгу">
            </form>
        </div>

        <div class="search-section">
            <h3>Пошук за видавництвом</h3>
            <form method="GET" action="">
                <label>Назва видавництва:</label>
                <input type="text" name="searchPublisher" value="<?= htmlspecialchars($_GET['searchPublisher'] ?? '') ?>">
                <button type="submit">Пошук</button>
            </form>

            <?php if (!empty($searchResults)): ?>
                <h3>Результати пошуку:</h3>
                <table>
                    <tr>
                        <th>Автор</th>
                        <th>Назва книги</th>
                        <th>Сторінок</th>
                        <th>Дата публікації</th>
                    </tr>
                    <?php foreach ($searchResults as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                            <td><?= htmlspecialchars($book->getBookName()) ?></td>
                            <td><?= htmlspecialchars($book->getNumberPages()) ?></td>
                            <td><?= htmlspecialchars($book->getDatePublished()) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php elseif (isset($_GET['searchPublisher'])): ?>
                <p class="message error">Книг цього видавництва не знайдено.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html> 