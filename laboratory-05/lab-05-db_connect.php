<?php
$dbPath = __DIR__ . '/library.db';
$message = '';

try {
    $isNewDatabase = !file_exists($dbPath);
    $pdo = new PDO("sqlite:$dbPath");
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
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        )";
        $pdo->exec($sql);

        $stmt = $pdo->prepare("INSERT INTO books (surname, name, author, book_name, number_pages, date_published, publisher, date_received) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
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
            } catch(PDOException $e) {
            }
        }
    }

    $stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
}