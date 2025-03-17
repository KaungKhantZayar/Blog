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
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if ($_FILES['image']['name'] != null) {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);

      if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image must be png,jpg,jpeg')</script>";
      }else {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $stmt = $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
        $result = $stmt->execute();
        if ($result) {
          echo "<script>alert('Successfuly Updated');window.location.href='index.php'</script>";
        }
      }
    }else {
      $stmt = $pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
      $result = $stmt->execute();
      if ($result) {
        echo "<script>alert('Successfuly Updated');window.location.href='index.php'</script>";
      }
    }
  }


  $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
  $stmt->execute();
  $result = $stmt->fetchAll();
   ?>

 <?php include 'header.html'; ?>

 <div class="content">
   <div class="container p-4">
     <div class="row">
       <div class="col-md-12">
         <div class="card p-4">
           <h3>Blog Edit Page</h3>
           <form class="" action="" method="post" enctype="multipart/form-data">
             <div class="form-group mt-4">
               <input type="hidden" name="id" value="<?php echo $result[0]['id'];?>">
               <label for="">Title</label>
               <input type="text" class="form-control" name="title" value="<?php echo $result[0]['title'];?>" required>
             </div>
             <div class="form-group mt-4">
               <label for="">Content</label>
               <textarea name="content" class="form-control" rows="8" cols="80"><?php echo $result[0]['content'];?></textarea>
             </div>
             <div class="form-group mt-4">
               <label for="">Image</label><br>
               <img src="images/<?php echo $result[0]['image'];?>" width="150" height="150" alt=""><br>
               <input type="file" name="image" value="" class="mt-3">
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
