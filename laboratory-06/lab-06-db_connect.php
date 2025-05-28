<?php
$dbPath = __DIR__ . '/library.db';
$message = '';

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

try {
    $isNewDatabase = !file_exists($dbPath);
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');

    if ($isNewDatabase) {
        $pdo->exec("
            CREATE TABLE persons (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                surname TEXT NOT NULL,
                name TEXT NOT NULL
            );
            CREATE TABLE books (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                author TEXT NOT NULL,
                book_name TEXT NOT NULL,
                number_pages INTEGER NOT NULL,
                date_published TEXT NOT NULL,
                publisher TEXT NOT NULL
            );
            CREATE TABLE receipts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                person_id INTEGER NOT NULL,
                book_id INTEGER NOT NULL,
                date_received TEXT NOT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE,
                FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
            );
        ");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $surname = validateInput($_POST['surname'] ?? '');
        $name = validateInput($_POST['name'] ?? '');
        $author = validateInput($_POST['author'] ?? '');
        $bookName = validateInput($_POST['bookName'] ?? '');
        $numberPages = filter_var($_POST['numberPages'] ?? '', FILTER_VALIDATE_INT);
        $datePublished = validateInput($_POST['datePublished'] ?? '');
        $publisher = validateInput($_POST['publisher'] ?? '');
        $dateReceived = validateInput($_POST['dateReceived'] ?? '');

        $datePublishedValid = DateTime::createFromFormat('Y-m-d', $datePublished) !== false;
        $dateReceivedValid = DateTime::createFromFormat('Y-m-d', $dateReceived) !== false;

        if ($surname && $name && $author && $bookName && $numberPages && $datePublishedValid && $publisher && $dateReceivedValid) {
            try {
                $pdo->beginTransaction();
                $stmt = $pdo->prepare("SELECT id FROM persons WHERE surname = ? AND name = ?");
                $stmt->execute([$surname, $name]);
                $person = $stmt->fetch();
                if (!$person) {
                    $stmt = $pdo->prepare("INSERT INTO persons (surname, name) VALUES (?, ?)");
                    $stmt->execute([$surname, $name]);
                    $personId = $pdo->lastInsertId();
                } else {
                    $personId = $person['id'];
                }
                $stmt = $pdo->prepare("SELECT id FROM books WHERE author = ? AND book_name = ?");
                $stmt->execute([$author, $bookName]);
                $book = $stmt->fetch();
                if (!$book) {
                    $stmt = $pdo->prepare("INSERT INTO books (author, book_name, number_pages, date_published, publisher) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$author, $bookName, $numberPages, $datePublished, $publisher]);
                    $bookId = $pdo->lastInsertId();
                } else {
                    $bookId = $book['id'];
                }
                $stmt = $pdo->prepare("INSERT INTO receipts (person_id, book_id, date_received) VALUES (?, ?, ?)");
                $stmt->execute([$personId, $bookId, $dateReceived]);

                $pdo->commit();
                $message = "Книга успішно додана.";
            } catch (Exception $e) {
                $pdo->rollBack();
                throw $e;
            }
        } else {
            $message = "Будь ласка, заповніть усі поля коректно.";
        }
    }

    $stmt = $pdo->query("
        SELECT r.*, p.surname, p.name, b.author, b.book_name 
        FROM receipts r
        JOIN persons p ON r.person_id = p.id
        JOIN books b ON r.book_id = b.id
        ORDER BY r.created_at DESC
    ");
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $message = "Помилка бази даних: " . $e->getMessage();
    error_log("Database Error: " . $e->getMessage());
} catch (Exception $e) {
    $message = "Сталася помилка: " . $e->getMessage();
    error_log("General Error: " . $e->getMessage());
}
