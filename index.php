<?php
require 'Config/config.php';

session_start();
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}



 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">

<div class="">
  <div class="content-wrapper" style="margin-left:0px !important;">
    <section class="content-header">
      <div class="container-fluid">
            <h1 style="text-align:center;">Blog Site</h1>
      </div>
    </section>

    <?php
    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id  DESC");
    $stmt->execute();
    $result = $stmt->fetchAll();
     ?>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php
          if ($result) {
            $i = 1;
            foreach ($result as $value) {?>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header">
                    <div style="text-align:center !important;float:none;" class="card-title">
                      <h4><?php echo $value['title'];?></h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <a href="blogdetail.php?id=<?php echo $value['id'];?>"><img class="img-fluid pad" src="admin/images/<?php echo $value['image'];?>" alt="" style="width:100%;height:300px !important;"></a>
                  </div>
                </div>
              </div>
        <?php
        $i++;
            }
          }
         ?>
       </div>
    </section>





    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>


  <!-- /.content-wrapper -->

  <footer class="main-footer">
  <!-- To the right -->
  <div class="float-right d-none d-sm-inline">
    <a href="logout.php" type="button" class="btn btn-danger logout">Logout</a>
  </div>
  <!-- Default to the left -->
  <strong>Copyright &copy; 2025 <a href="#">KKZY</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
