<?php
session_start();
require '../Config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

if ($_POST) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $passwordhash = password_hash($password, PASSWORD_DEFAULT);
  if (isset($_POST['role'])) {
    $role = 1;
  }else {
    $role = 0;
  }
$stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
$user = $stmt->bindValue('email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
  echo "<script>alert('Email duplicate')</script>";
}else {
  $stmt = $pdo->prepare("INSERT INTO users(name,email,role,password) VALUES (:name,:email,:role,:password)");
  $result = $stmt->execute(
    array(':name'=>$name,':email'=>$email,':role'=>$role,':password'=>$passwordhash)
  );
    if ($result) {
      echo "<script>alert('Sussessfully added');window.location.href='user_list.php';</script>";
    }
  }
}

  ?>
 <?php include 'header.html';?>

<div class="container">
    <div class="card">
        <div class="card-body">
          <form class="" action="" method="post">
          <label for="">Username</label>
          <input type="text" name="name" value="" class="form-control">
          <label for="" class="mt-3">Email</label>
          <input type="email" name="email" value="" class="form-control">
          <label for="" class="mt-3">Password</label>
          <input type="password" name="password" value="" class="form-control">
          <label for="vechicle3" class="mt-3">Admin or User</label><br>
          <input type="checkbox" name="role" value="">
          <br>
          <input type="submit" class="btn btn-success mt-3" name="button" value="SUBMIT">
          <a href="user_list.php"><button type="button" name="button" class="btn btn-danger mt-3">Back</button></a>
        </form>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>
