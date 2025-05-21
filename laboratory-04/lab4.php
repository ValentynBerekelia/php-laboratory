<?php
require '../laboratory-02/rw_file.php';

$data = read_from_file("../laboratory-02/file.txt");
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $data = array_filter($data, function($row) use ($search) {
        return stripos($row[3], $search) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Пошук книг</title>
    <link rel="stylesheet" href="../form_style.css">
</head>
<body>
<div class="background">
    <ul>
        <li><a href="../laboratory-01/Home.php">Home</a></li>
        <li><a href="../laboratory-02/form.php">Add data</a></li>
    </ul>

    <form method="GET" style="margin-bottom: 20px;">
        <label for="search">Пошук за назвою книги:</label>
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Пошук</button>
    </form>

    <div class="context-table">
        <table>
            <thead>
            <tr>
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
            <?php if (empty($data)): ?>
                <tr><td colspan="9">Нічого не знайдено.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $element): ?>
                    <tr>
                        <?php foreach ($element as $item): ?>
                            <td><?= htmlspecialchars($item) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
