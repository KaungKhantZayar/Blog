<?php
session_start();
require '../Config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

  $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
  $stmt->execute();
  $result = $stmt->fetchAll();

  ?>
 <?php include 'header.html';?>

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Blog User</h3>
        </div>

        <div class="card-body">
          <div class="" style="margin-left:900px;">
            <a href="user_add.php" type="button" class="btn btn-success">Create User</a>
          </div>

          <table class="table table-bordered mt-4">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th style="width:40px;">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            if ($result) {
              $id = 1;
              foreach($result as $value){
             ?>
              <tr>
                <td><?php echo $id;?></td>
                <td><?php echo $value['name'];?></td>
                <td><?php echo $value['email'];?></td>
                <td><?php if ($value['role'] == 0){echo "User";}else{echo "Admin";}?></td>
                <td>
                  <div class="btn-group">
                    <div class="container">
                    <a href="user_update.php?id=<?php echo $value['id'];?>" type="button" class="btn btn-warning">Edit</a>
                    </div>
                    <div class="contaienr">
                    <a href="user_delete.php?id=<?php echo $value['id'];?>" type="button" class="btn btn-danger">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
              <?php
              $id++;
            }
          }
               ?>
            </tbody>
          </table>
            <br>
      </div>

      </div>
    </div>


<?php include 'footer.html'; ?>
