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

// if(isset($_POST['save_list'])){

//    if($user_id != ''){
      
//       $list_id = $_POST['list_id'];
//       $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

//       $select_list = $conn->prepare("SELECT * FROM `forum_posts` WHERE user_id = ?");
//       $select_list->execute([$user_id, $list_id]);

//    }else{
//       $message[] = 'please login first!';
//    }
// }

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

<!-- playlist section starts  -->

<section class="playlist">

   <h1 class="heading">Post Details</h1>

   <div class="row">

      <?php
         $select_playlist = $conn->prepare("SELECT * FROM `forum_posts` WHERE user_id = ? LIMIT 1");
         $select_playlist->execute([$get_id]);
         if($select_playlist->rowCount() > 0){
            $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);

            $playlist_id = $fetch_playlist['id'];
            // show replies
            $count_videos = $conn->prepare("SELECT * FROM `forum_replies` WHERE post_id = ?");
            $count_videos->execute([$post_id]);
            $total_videos = $count_videos->rowCount();

            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
            $select_user->execute([$fetch_playlist['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

      ?>

      <div class="col">
         <div class="thumb">
            <span><?= $total_replies; ?> Comments</span>
         </div>
      </div>

      <div class="col">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_student['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_student['name']; ?></h3>
            </div>
         </div>
         <div class="details">
            <h3><?= $fetch_forum['title']; ?></h3>
            <p><?= $fetch_forum['content']; ?></p>
            <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_forum['date']; ?></span></div>
         </div>
      </div>

      <?php
         }else{
            echo '<p class="empty">this forum was not found!</p>';
         }  
      ?>

   </div>

</section>

<!-- playlist section ends -->

<!-- replies section starts  -->

<section class="comments">
    <!-- code to add a comment -->
     <!-- change name="content_id" to "post_id" -->
   <h1 class="heading">Join the Forum</h1>

   <form action="" method="post" class="add-comment">
      <input type="hidden" name="post_id" value="<?= $get_id; ?>">
      <textarea name="comment_box" required placeholder="write your reply..." maxlength="1000" cols="30" rows="10"></textarea>
      <input type="submit" value="add reply" name="add_comment" class="inline-btn">
   </form>

   <h1 class="heading">user replies</h1>

   <div class="show-comments">
      <?php
         $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE content_id = ?");
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
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
            <button type="submit" name="edit_comment" class="inline-option-btn">edit comment</button>
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('delete this comment?');">delete comment</button>
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
   
</section>

<!-- videos container section ends -->

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>