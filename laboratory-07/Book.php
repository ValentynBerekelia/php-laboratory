<?php

class Book {
    private $id;
    private $author;
    private $bookName;
    private $numberPages;
    private $datePublished;
    private $publisher;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function save() {
        try {
            $sql = "INSERT INTO books (author, book_name, number_pages, date_published, publisher) 
                    VALUES (:author, :bookName, :numberPages, :datePublished, :publisher)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':author' => $this->author,
                ':bookName' => $this->bookName,
                ':numberPages' => $this->numberPages,
                ':datePublished' => $this->datePublished,
                ':publisher' => $this->publisher
            ]);

            $this->id = $this->pdo->lastInsertId();
            return true;
        } catch (PDOException $e) {
            error_log("Error saving book: " . $e->getMessage());
            return false;
        }
    }

    public static function findByAttribute($pdo, $attribute, $value) {
        try {
            $sql = "SELECT * FROM books WHERE $attribute = :value";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':value' => $value]);
            
            $book = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($book) {
                $bookObj = new self($pdo);
                $bookObj->id = $book['id'];
                $bookObj->author = $book['author'];
                $bookObj->bookName = $book['book_name'];
                $bookObj->numberPages = $book['number_pages'];
                $bookObj->datePublished = $book['date_published'];
                $bookObj->publisher = $book['publisher'];
                return $bookObj;
            }
            return null;
        } catch (PDOException $e) {
            error_log("Error finding book: " . $e->getMessage());
            return null;
        }
    }

    public static function findByPublisher($pdo, $publisher) {
        try {
            $sql = "SELECT * FROM books WHERE publisher = :publisher ORDER BY number_pages ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':publisher' => $publisher]);
            
            $books = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $book = new self($pdo);
                $book->id = $row['id'];
                $book->author = $row['author'];
                $book->bookName = $row['book_name'];
                $book->numberPages = $row['number_pages'];
                $book->datePublished = $row['date_published'];
                $book->publisher = $row['publisher'];
                $books[] = $book;
            }
            return $books;
        } catch (PDOException $e) {
            error_log("Error finding books by publisher: " . $e->getMessage());
            return [];
        }
    }

    public function getId() { return $this->id; }
    public function getAuthor() { return $this->author; }
    public function getBookName() { return $this->bookName; }
    public function getNumberPages() { return $this->numberPages; }
    public function getDatePublished() { return $this->datePublished; }
    public function getPublisher() { return $this->publisher; }

    public function setAuthor($author) { $this->author = $author; }
    public function setBookName($bookName) { $this->bookName = $bookName; }
    public function setNumberPages($numberPages) { $this->numberPages = $numberPages; }
    public function setDatePublished($datePublished) { $this->datePublished = $datePublished; }
    public function setPublisher($publisher) { $this->publisher = $publisher; }
} 