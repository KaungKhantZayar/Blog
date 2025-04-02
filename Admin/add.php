<?php
session_start();
require '../Config/config.php';

  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
  if ($_SESSION['role'] != 1) {
    header('Location: login.php');
  }

  if ($_POST) {
    if (empty($_POST['title']) OR empty($_POST['content']) OR $_FILES['image']['name'] == '') {
      if (empty($_POST['title'])) {
        $titleError = 'Title cannot be empty';
      }
      if (empty($_POST['content'])) {
        $contentError = 'Content cannot be empty';
      }
      if ($_FILES['image']['name'] == '') {
        $imageError = 'Image cannot be empty';
      }
    }else {
      echo "<script>alert('Yesss');</script>";
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);

      if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image must be png,jpg,jpeg')</script>";
      }else {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);
        $stmt = $pdo->prepare("INSERT INTO posts(title,content,author_id,image) VALUES (:title,:content,:author_id,:image)");
        $result = $stmt->execute(
          array(':title'=>$title,':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image)
        );
        if ($result) {
          echo "<script>alert('Successfuly added');window.location.href='index.php'</script>";
        }
      }
    }
  }

 ?>

 <?php include 'header.php'; ?>

 <div class="content">
   <div class="container p-4">
     <div class="row">
       <div class="col-md-12">
         <div class="card p-4">
           <h3>Blog Add Page</h3>
           <form class="" action="add.php" method="post" enctype="multipart/form-data">
             <div class="form-group mt-4">
               <label for="">Title</label><p style="color:red;"><?php echo empty($titleError) ? '' : $titleError; ?></p>
                <input type="text" class="form-control" name="title" value="" >
             </div>
             <div class="form-group mt-4">
               <label for="">Content</label><p style="color:red;"><?php echo empty($contentError) ? '' : $contentError; ?></p>
               <textarea name="content" class="form-control" rows="8" cols="80"></textarea>
             </div>
             <div class="form-group mt-4">
               <label for="">Image</label><br><p style="color:red;"><?php echo empty($imageError) ? '' : $imageError; ?></p>
               <input type="file" name="image" value="">
             </div>
             <div class="form-group mt-4">
               <input type="submit" class="btn btn-success" name="" value="Submit">
               <a href="index.php" class="btn btn-danger">Back</a>
             </div>
           </form>
         </div>
       </div>
     </div>
   </div>
 </div>

<?php include 'footer.html'; ?>
