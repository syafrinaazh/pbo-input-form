<!DOCTYPE html>
<html>
<head>
    <title>To-Do List PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Daftar Tugas</h2>

<form method="POST">
    <input type="text" name="task" placeholder="Masukkan tugas..." required>
    <button type="submit">Tambah</button>
</form>

<ul>
<?php
$tasks = [];

if (isset($_POST['task'])) {
    $task = $_POST['task'];
    echo "<li>$task</li>";
}
?>
</ul>

</body>
</html>