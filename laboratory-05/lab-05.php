<?php
$dbDir = __DIR__;
$dbFile = 'library.db';
$dbPath = $dbDir . DIRECTORY_SEPARATOR . $dbFile;
$message = '';

try {
    $isNewDatabase = !file_exists($dbPath);
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');
    if ($isNewDatabase) {
        $sql = "CREATE TABLE IF NOT EXISTS books (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            surname TEXT NOT NULL,
            name TEXT NOT NULL,
            author TEXT NOT NULL,
            book_name TEXT NOT NULL,
            number_pages INTEGER NOT NULL,
            date_published TEXT NOT NULL,
            publisher TEXT NOT NULL,
            date_received TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";

        $pdo->exec($sql);
        $sampleData = [""];

        $stmt = $pdo->prepare("INSERT INTO books (surname, name, author, book_name, number_pages, date_published, publisher, date_received) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        foreach ($sampleData as $data) {
            $stmt->execute($data);
        }

        $message .= "<div style='color: green; margin: 10px 0;'>База даних успішно створена та заповнена тестовими даними!</div>";
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $surname = $_POST['surname'] ?? '';
        $name = $_POST['name'] ?? '';
        $author = $_POST['author'] ?? '';
        $bookName = $_POST['bookName'] ?? '';
        $numberPages = $_POST['numberPages'] ?? '';
        $datePublished = $_POST['datePublished'] ?? '';
        $publisher = $_POST['publisher'] ?? '';
        $dateReceived = $_POST['dateReceived'] ?? '';

        if (!empty($surname) && !empty($name) && !empty($author) && !empty($bookName)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO books (surname, name, author, book_name, number_pages, date_published, publisher, date_received) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$surname, $name, $author, $bookName, $numberPages, $datePublished, $publisher, $dateReceived]);
                $message .= "<div style='color: green; margin: 10px 0;'>Запис успішно додано!</div>";
            } catch(PDOException $e) {
                $message .= "<div style='color: red; margin: 10px 0;'>Помилка: " . $e->getMessage() . "</div>";
            }
        }
    }
    $stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $message .= "<div style='color: red; margin: 10px 0;'>Помилка бази даних: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Облік книг у бібліотеці</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .form-container {
            max-width: 600px;
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<h1>Облік книг у бібліотеці</h1>

<?php if ($message): ?>
    <div><?= $message ?></div>
<?php endif; ?>

<div class="form-container">
    <h2>Додати нову книгу</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="surname">Прізвище:</label>
            <input type="text" id="surname" name="surname" required>
        </div>

        <div class="form-group">
            <label for="name">Ім'я:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="author">Автор:</label>
            <input type="text" id="author" name="author" required>
        </div>

        <div class="form-group">
            <label for="bookName">Назва книги:</label>
            <input type="text" id="bookName" name="bookName" required>
        </div>

        <div class="form-group">
            <label for="numberPages">Кількість сторінок:</label>
            <input type="number" id="numberPages" name="numberPages" required>
        </div>

        <div class="form-group">
            <label for="datePublished">Дата публікації:</label>
            <input type="date" id="datePublished" name="datePublished" required>
        </div>

        <div class="form-group">
            <label for="publisher">Видавництво:</label>
            <input type="text" id="publisher" name="publisher" required>
        </div>

        <div class="form-group">
            <label for="dateReceived">Дата отримання:</label>
            <input type="date" id="dateReceived" name="dateReceived" required>
        </div>

        <input type="submit" value="Додати книгу">
    </form>
</div>

<h2>Список книг</h2>
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
</body>
</html>