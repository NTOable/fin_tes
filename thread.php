<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:home.php');
}

if(isset($_POST['add_comment'])){
   if($user_id != ''){

      $id = unique_id();
      $comment_box = $_POST['comment_box'];
      $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);
      $post_id = $_POST['post_id'];
      $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);

      $select_content = $conn->prepare("SELECT * FROM `forum_posts` WHERE id = ? LIMIT 1");
      $select_content->execute([$post_id]);
      $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);

      if($select_content->rowCount() > 0){

         $select_comment = $conn->prepare("SELECT * FROM `forum_replies` WHERE post_id = ? AND comment = ?");
         $select_comment->execute([$post_id, $comment_box]);

         if($select_comment->rowCount() > 0){
            $message[] = 'reply already sent!';
         }else{
            $insert_comment = $conn->prepare("INSERT INTO `forum_replies`(id, post_id, user_id, comment) VALUES(?,?,?,?)");
            $insert_comment->execute([$id, $post_id, $user_id, $comment_box]);
            $message[] = 'new reply sent!';
         }

      }else{
         $message[] = 'something went wrong!';
      }

   }else{
      $message[] = 'please login first!';
   }

if(isset($_POST['delete_comment'])){

   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `forum_replies` WHERE id = ?");
   $verify_comment->execute([$delete_id]);

   if($verify_comment->rowCount() > 0){
      $delete_comment = $conn->prepare("DELETE FROM `forum_replies` WHERE id = ?");
      $delete_comment->execute([$delete_id]);
      $message[] = 'reply deleted successfully!';
   }else{
      $message[] = 'reply already deleted!';
   }
}

if(isset($_POST['update_now'])){

   $update_id = $_POST['update_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $update_box = $_POST['update_box'];
   $update_box = filter_var($update_box, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `forum_replies` WHERE id = ? AND comment = ?");
   $verify_comment->execute([$update_id, $update_box]);

   if($verify_comment->rowCount() > 0){
      $message[] = 'reply already added!';
   }else{
      $update_comment = $conn->prepare("UPDATE `forum_replies` SET comment = ? WHERE id = ?");
      $update_comment->execute([$update_box, $update_id]);
      $message[] = 'reply edited successfully!';
   }

  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>playlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<?php
   if(isset($_POST['edit_comment'])){
      $edit_id = $_POST['comment_id'];
      $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);
      $verify_comment = $conn->prepare("SELECT * FROM `forum_replies` WHERE id = ? LIMIT 1");
      $verify_comment->execute([$edit_id]);
      if($verify_comment->rowCount() > 0){
         $fetch_edit_comment = $verify_comment->fetch(PDO::FETCH_ASSOC);
?>
<section class="edit-comment">
   <h1 class="heading">edit reply</h1>
   <form action="" method="post">
      <input type="hidden" name="update_id" value="<?= $fetch_edit_comment['id']; ?>">
      <textarea name="update_box" class="box" maxlength="1000" required placeholder="please enter your reply" cols="30" rows="10"><?= $fetch_edit_comment['comment']; ?></textarea>
      <div class="flex">
         <a href="thread.php?get_id=<?= $get_id; ?>" class="inline-option-btn">cancel edit</a>
         <input type="submit" value="update now" name="update_now" class="inline-btn">
      </div>
   </form>
</section>
<?php
   }else{
      $message[] = 'reply was not found!';
   }
}
?>

<!-- playlist section starts  -->

<section class="playlist">

   <h1 class="heading">Post Details</h1>

   <div class="row">
      <?php
         $select_playlist = $conn->prepare("SELECT * FROM `forum_posts` WHERE id = ? LIMIT 1");
         $select_playlist->execute([$get_id]);
         if($select_playlist->rowCount() > 0){  
            $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);
            $playlist_id = $fetch_playlist['id'];
      
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
            $select_user->execute([$fetch_playlist['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

      ?>

      <!-- <div class="col">
         <div class="thumb">
            <span>... Comments</span>
         </div>
      </div> -->

      <div class="col">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_user['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_user['name']; ?></h3>
            </div>
         </div>
         <div class="details">
            <h3><?= $fetch_playlist['title']; ?></h3>
            <p><?= $fetch_playlist['content']; ?></p>
            <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
         </div>
      </div>

      <?php
         }else{
            echo '<p class="empty">Error: Post is not loading</p>';
         }  
      ?>

   </div>

</section>

<!-- playlist section ends -->

<!-- replies section starts  -->

<section class="comments">
   <h1 class="heading">Join the Forum</h1>
   <div class="show-comments">
        <!-- shows post title and content -->

        <!-- shows reply section -->
      <?php
         $select_comments = $conn->prepare("SELECT * FROM `forum_replies` WHERE post_id = ?");
         $select_comments->execute([$get_id]);
         if($select_comments->rowCount() > 0){
            while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){   
               $select_commentor = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_commentor->execute([$fetch_comment['user_id']]);
               $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box" style="<?php if($fetch_comment['user_id'] == $user_id){echo 'order:-1;';} ?>">
         <div class="user">
            <img src="uploaded_files/<?= $fetch_commentor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_commentor['name']; ?></h3>
               <span><?= $fetch_comment['date']; ?></span>
            </div>
         </div>
         <p class="text"><?= $fetch_comment['comment']; ?></p>
         <?php
            if($fetch_comment['user_id'] == $user_id){ 
         ?>
         <!-- shows edit and delete reply option -->
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
            <button type="submit" name="edit_comment" class="inline-option-btn">edit</button>
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('delete this reply?');">delete</button>
         </form>
         <?php
         }
         ?>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">No replies yet!</p>';
      }
      ?>
      </div>
   
 <!-- code to add a comment -->

   <form action="" method="post" class="add-comment">
      <input type="hidden" name="post_id" value="<?= $get_id; ?>">
      <textarea name="comment_box" required placeholder="write your reply..." maxlength="1000" cols="30" rows="10"></textarea>
      <input type="submit" value="add reply" name="add_comment" class="inline-btn">
   </form>

</section>

<!-- videos container section ends -->

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>