<?php
session_start();
require '../Config/config.php';

  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }

  if ($_POST) {
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

 ?>

 <?php include 'header.html'; ?>

 <div class="content">
   <div class="container p-4">
     <div class="row">
       <div class="col-md-12">
         <div class="card p-4">
           <h3>Blog Add Page</h3>
           <form class="" action="add.php" method="post" enctype="multipart/form-data">
             <div class="form-group mt-4">
               <label for="">Title</label>
               <input type="text" class="form-control" name="title" value="" required>
             </div>
             <div class="form-group mt-4">
               <label for="">Content</label>
               <textarea name="content" class="form-control" rows="8" cols="80"></textarea>
             </div>
             <div class="form-group mt-4">
               <label for="">Image</label><br>
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
