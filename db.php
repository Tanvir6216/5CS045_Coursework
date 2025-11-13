<?php
$mysqli = new mysqli("localhost","2442655","T@nvir662216","db2442655");
if ($mysqli -> connect_errno) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}
$conn = $mysqli; 
?>
