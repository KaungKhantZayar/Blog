<?php
    require '../Config/config.php';
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['id']);
    $stmt->execute();
    header('Location: index.php');
    // echo "<script>alert('Are you sure you want to delete this item')</script>";
 ?>
