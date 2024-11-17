<?php
require 'config.php';

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo "Task deleted successfully!";
?>