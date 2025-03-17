<?php
session_start();
require '../Config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}

if (isset($_POST['search']) && !empty($_POST['search'])) {
    setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
} else {
    if (empty($_GET['pageno'])) {
        unset($_COOKIE['search']);
        setcookie('search', null, -1, '/');
    }
}



?>
<?php
     if (!empty($_GET['pageno'])) {
       $pageno = $_GET['pageno'];
     }else {
       $pageno = 1;
     }
     $numOfrecs = 2;
     $offset = ($pageno - 1) * $numOfrecs;

     if (empty($_POST['search'])) {
       $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id  DESC");
       $stmt->execute();
       $rawResult = $stmt->fetchAll();

       $total_pages = ceil(count($rawResult) / $numOfrecs);

       $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numOfrecs");
       $stmt->execute();
       $result = $stmt->fetchAll();
     }else {
       $searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];
       $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id  DESC");
       $stmt->execute();
       $rawResult = $stmt->fetchAll();

       $total_pages = ceil(count($rawResult) / $numOfrecs);

       $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
       $stmt->execute();
       $result = $stmt->fetchAll();
     }
     ?>


<?php include 'header.php';?>

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
            <nav aria-lable="Page navigation example" style="float:right;">
            <ul class="pagination">
            <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
            <li class="page-item <?php if($pageno <= 1){echo 'disabled';}?>">
            <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo "?pageno=".($pageno-1);}?>">Previonus</a>
            </li>
            <li class="page-item"><a class="page-link" href="#"><?php echo $pageno;?></a></li>
            <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>">
            <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#';}else{echo "?pageno=".($pageno+1);}?>">Next</a>
            </li>
            <li class="page-item"><a class="page-link" href="?pagenp=<?php echo $total_pages;?>">Last</a></li>
            </ul>
            </nav>
      </div>

      </div>
    </div>



<?php include 'footer.html'; ?>
