<?php
date_default_timezone_set('Europe/Kyiv');

$today = new DateTime();

$semesterEnd = null;
$daysLeft = null;
$message = '';
$calendarRows = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['end_date'])) {
    $endDateInput = $_POST['end_date'];

    try {
        $semesterEnd = new DateTime($endDateInput);
        $interval = $today->diff($semesterEnd);
        $daysLeft = (int)$interval->format('%r%a');

        if ($daysLeft > 1) {
            $message = "До закінчення семестру залишилося $daysLeft дні.";
        } elseif ($daysLeft === 1) {
            $message = "До закінчення семестру залишився 1 день.";
        } elseif ($daysLeft === 0) {
            $message = "Сьогодні останній день семестру!";
        } else {
            $message = "Семестр вже завершився.";
        }

        $current = clone $today;
        while ($current <= $semesterEnd) {
            $dayOfWeek = $current->format('l');
            $ukrDay = [
                'Monday' => 'Понеділок',
                'Tuesday' => 'Вівторок',
                'Wednesday' => 'Середа',
                'Thursday' => 'Четвер',
                'Friday' => 'Пʼятниця',
                'Saturday' => 'Субота',
                'Sunday' => 'Неділя'
            ][$dayOfWeek];

            $highlight = $current->format('Y-m-d') === $today->format('Y-m-d') ? 'class="today"' : '';
            $calendarRows .= "<tr $highlight><td>{$current->format('Y-m-d')}</td><td>$ukrDay</td></tr>";
            $current->modify('+1 day');
        }

    } catch (Exception $e) {
        $message = 'Неправильний формат дати.';
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лаба 8</title>
    <link rel="stylesheet" href="style08.css">
</head>
<body>
<div class="background">
    <ul>
        <li><a href="../laboratory-01/Home.php">Home</a></li>
    </ul>
</div>
<h1>Календар</h1>

<form method="POST">
    <label for="end_date">Кінець навчання:</label>
    <input type="date" name="end_date" id="end_date" required value="<?= htmlspecialchars($_POST['end_date'] ?? '') ?>">
    <button type="submit">Показати календар</button>
</form>

<?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
<?php endif; ?>

<?php if ($calendarRows): ?>
    <table>
        <tr>
            <th>Дата</th>
            <th>День тижня</th>
        </tr>
        <?= $calendarRows ?>
    </table>
<?php endif; ?>

</body>
</html>
