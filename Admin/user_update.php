<?php
session_start();
require '../Config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

$id = $_GET['id'];
if ($_POST) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  if (isset($_POST['role'])) {
    $role = 1;
  }else {
    $role = 0;
  }
$stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
$stmt->execute(
  array(':email'=>$email, ':id'=>$id)
);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user){
echo "<script>alert('Email duplicate')</script>";
}else {
  $stmt = $pdo->prepare("UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$id'");
  $result = $stmt->execute();
  if ($result) {
      echo "<script>alert('Sussessfully Updated');window.location.href='user_list.php'</script>";
     }
    }
  }

  $stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
  $stmt->execute();
  $result = $stmt->fetchAll();

  ?>
 <?php include 'header.html';?>

<div class="container">
    <div class="card">
        <div class="card-body">
          <form class="" action="" method="post">
          <label for="">Username</label>
          <input type="text" name="name" value="<?php echo $result[0]['name']; ?>" class="form-control">
          <label for="" class="mt-3">Email</label>
          <input type="email" name="email" value="<?php echo $result[0]['email'];?>" class="form-control">
          <label for="vechicle3" class="mt-3">Role</label><br>
          <input type="checkbox" name="role" value="<?php echo $result[0]['role']; ?>">
          <br>
          <input type="submit" class="btn btn-success mt-3" name="button" value="SUBMIT">
          <a href="user_list.php"><button type="button" name="button" class="btn btn-danger mt-3">Back</button></a>
        </form>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>
