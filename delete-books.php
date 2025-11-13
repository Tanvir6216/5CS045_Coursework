<?php
  
  // Read values from the URL
  $isbn = $_GET['isbn'];
  
  // Connect to database
  include("db.php");
  
  // Define SQL query
  $sql = "DELETE FROM books WHERE ISBN = '" . $isbn . "'";
  
  // Run SQL statement and report errors
  if(!$conn -> query($sql)) {
      echo("<h4>SQL error description: " . $conn -> error . "</h4>");
  }
  
  // Redirect to list
  header("location: search-books.php");   
  
?>
