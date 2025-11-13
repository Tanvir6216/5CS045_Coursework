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
    header("Location: list.php");
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Title = trim($_POST['Title']);
    $Author = trim($_POST['Author']);
    $Genre = trim($_POST['Genre']);
    $Price = floatval($_POST['Price']);
    $Published_date = $_POST['Published_date'];
    $Description = trim($_POST['Description']);
	$Actions = trim($_POST['Actions']);


    if ($Title === '' || $Author === '' || $Genre === '') {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE books SET Title=?, Author=?, Genre=?, Price=?, Published_date=?, Actions=? WHERE ISBN=?");
        $stmt->bind_param("sssssss", $Title, $Author, $Genre, $Price, $Published_date, $Description, $ISBN);
        $stmt->execute();
        $stmt->close();
        header("Location: search-books.php");
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h1>Edit Book</h1>

<?php if ($errors): ?>
<div class="alert alert-danger"><?php foreach($errors as $e) echo "<div>$e</div>"; ?></div>
<?php endif; ?>

<form method="post">
  <div class="mb-3"><label>ISBN</label><input name="ISBN" class="form-control" value="<?= $book['ISBN'] ?>" readonly></div>
  <div class="mb-3"><label>Title</label><input name="Title" class="form-control" value="<?= $book['Title'] ?>"></div>
  <div class="mb-3"><label>Author</label><input name="Author" class="form-control" value="<?= $book['Author'] ?>"></div>
  <div class="mb-3"><label>Genre</label><input name="Genre" class="form-control" value="<?= $book['Genre'] ?>"></div>
  <div class="mb-3"><label>Price (£)</label><input name="Price" type="number" step="0.01" class="form-control" value="<?= $book['Price'] ?>"></div>
  <div class="mb-3"><label>Published Date</label><input name="Published_date" type="date" class="form-control" value="<?= $book['Published_date'] ?>"></div>
  <div class="mb-3"><label>Actions</label><textarea name="Actions" class="form-control" rows="4"><?= $book['Actions'] ?></textarea></div>
  <button class="btn btn-success" type="submit">Update</button>
  <a href="search-books.php" class="btn btn-secondary">Cancel</a>
</form>
</body>
</html>
