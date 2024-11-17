<?php
require 'config.php';

$task = $_POST['task'];

$stmt = $conn->prepare("INSERT INTO tasks (name) VALUES (?)");
$stmt->bind_param("s", $task);
$stmt->execute();

echo "New task created successfully!";
?>