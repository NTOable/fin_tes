<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $id = unique_id();
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $content = $_POST['content'];
   $content = filter_var($content, FILTER_SANITIZE_STRING);

   $add_forum = $conn->prepare("INSERT INTO `forum_posts`(id, user_id, title, content) VALUES(?,?,?,?)");
   $add_forum->execute([$id, $user_id, $title, $content]);

   $message[] = 'new post created!';  

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Create a Forum Post</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
   
<section class="playlist-form">

   <h1 class="heading">Create a Forum Post</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <p>Forum Title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="enter forum title" class="box">
      <p>Forum Content <span>*</span></p>
      <textarea name="content" class="box" required placeholder="write post" maxlength="1000" cols="30" rows="10"></textarea>
      <input type="submit" value="create post" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>