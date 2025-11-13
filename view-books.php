<?php
include "db.php";
$ISBN = $_GET['isbn'] ?? '';
$stmt = $conn->prepare("SELECT * FROM books WHERE ISBN = ?");
$stmt->bind_param("s", $ISBN);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
$stmt->close();

if (!$book) {
    header("Location: search-books.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>View Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h1><?= htmlspecialchars($book['Title']) ?></h1>

<table class="table table-bordered">
<tr><th>ISBN</th><td><?= $book['ISBN'] ?></td></tr>
<tr><th>Author</th><td><?= $book['Author'] ?></td></tr>
<tr><th>Genre</th><td><?= $book['Genre'] ?></td></tr>
<tr><th>Price</th><td>£<?= $book['Price'] ?></td></tr>
<tr><th>Published Date</th><td><?= $book['Published_date'] ?></td></tr>
<tr><th>Actions</th><td><?= nl2br(htmlspecialchars($book['Actions'])) ?></td></tr>
</table>

<a href="search-books.php" class="btn btn-secondary">Back</a>
<a href="edit-books.php?isbn=<?= $book['ISBN'] ?>" class="btn btn-warning">Edit</a>
<a href="delete-books.php?isbn=<?= $book['ISBN'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
</body>
</html>
