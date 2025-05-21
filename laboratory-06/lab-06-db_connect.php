<?php
$dbPath = __DIR__ . '/library_normalized.db';

try {
    $isNewDatabase = !file_exists($dbPath);
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');

    if ($isNewDatabase) {
        $pdo->exec("CREATE TABLE IF NOT EXISTS authors (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            surname TEXT NOT NULL,
            name TEXT NOT NULL
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS publishers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS books (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            surname TEXT NOT NULL,
            name TEXT NOT NULL,
            author_id INTEGER NOT NULL,
            publisher_id INTEGER NOT NULL,
            book_name TEXT NOT NULL,
            number_pages INTEGER NOT NULL,
            date_published TEXT NOT NULL,
            date_received TEXT NOT NULL,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (author_id) REFERENCES authors(id),
            FOREIGN KEY (publisher_id) REFERENCES publishers(id)
        )");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $surname = trim($_POST['surname'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $authorFull = trim($_POST['author'] ?? '');
        $bookName = trim($_POST['bookName'] ?? '');
        $numberPages = intval($_POST['numberPages'] ?? 0);
        $datePublished = $_POST['datePublished'] ?? '';
        $publisherName = trim($_POST['publisher'] ?? '');
        $dateReceived = $_POST['dateReceived'] ?? '';


        if ($surname && $name && $authorFull && $bookName && $publisherName && $numberPages > 0 && $datePublished && $dateReceived) {
            $authorParts = explode(' ', $authorFull);
            $authorSurname = $authorParts[0] ?? '';
            $authorName = $authorParts[1] ?? '';

            if ($authorSurname && $authorName) {
                $stmt = $pdo->prepare("SELECT id FROM authors WHERE surname = ? AND name = ?");
                $stmt->execute([$authorSurname, $authorName]);
                $authorId = $stmt->fetchColumn();

                if (!$authorId) {
                    $stmt = $pdo->prepare("INSERT INTO authors (surname, name) VALUES (?, ?)");
                    $stmt->execute([$authorSurname, $authorName]);
                    $authorId = $pdo->lastInsertId();
                }
                $stmt = $pdo->prepare("SELECT id FROM publishers WHERE name = ?");
                $stmt->execute([$publisherName]);
                $publisherId = $stmt->fetchColumn();

                if (!$publisherId) {
                    $stmt = $pdo->prepare("INSERT INTO publishers (name) VALUES (?)");
                    $stmt->execute([$publisherName]);
                    $publisherId = $pdo->lastInsertId();
                }
                $stmt = $pdo->prepare("INSERT INTO books 
                    (surname, name, author_id, publisher_id, book_name, number_pages, date_published, date_received)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$surname, $name, $authorId, $publisherId, $bookName, $numberPages, $datePublished, $dateReceived]);
            }
        }
    }
    $stmt = $pdo->query("
        SELECT b.*, a.surname AS author_surname, a.name AS author_name, p.name AS publisher_name
        FROM books b
        JOIN authors a ON b.author_id = a.id
        JOIN publishers p ON b.publisher_id = p.id
        ORDER BY b.created_at DESC
    ");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
}
