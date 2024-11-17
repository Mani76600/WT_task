<?php
require 'config.php';

$id = $_POST['id'];
$isChecked = $_POST['isChecked'];

$stmt = $conn->prepare("UPDATE tasks SET is_completed = ? WHERE id = ?");
$stmt->bind_param("ii", $isChecked, $id);
$stmt->execute();

echo "Task status updated successfully!";
?>