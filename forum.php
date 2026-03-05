<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Torchlight Tutoring | Forum</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="courses">
   
   <h1 class="heading">Forum</h1>

   <div class="box-container">

 <?php
         $select_forums = $conn->prepare("SELECT * FROM `forum_posts` ORDER BY date DESC");
         $select_forums->execute();
         if($select_forums->rowCount() > 0){
            while($fetch_forum = $select_forums->fetch(PDO::FETCH_ASSOC)){
               // use the post id directly, do not treat it as an array
               $post_id = $fetch_forum['id'];

               $select_student = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_student->execute([$fetch_forum['user_id']]);
               $fetch_student = $select_student->fetch(PDO::FETCH_ASSOC);
      ?>
      <?php
                  $count_replies = $conn->prepare("SELECT * FROM `forum_replies` WHERE post_id = ?");
                  $count_replies->execute([$post_id]);
                  


                  $total_replies = $count_replies->rowCount();
      ?>

      <div class="box">
         <div class="tutor">
            <div class="info">
                 <h3 class ="title">Post Title: <?= $fetch_forum['title']; ?></h3>
               <span><?= $fetch_student['name']; ?> posted on: <?= $fetch_forum['date']; ?></span>
               <p class= "message"><span><?= $fetch_forum['content']; ?></span></p>
            </div>  
         </div>
         <h3 class="title">Replies: <?= $total_replies; ?></h3>
         <a href="thread.php?get_id=<?= $post_id; ?>" class="inline-btn">View Thread</a>
      </div>
            <?php
         }
      }else{
         echo '<p class="empty">no forums added yet!</p>';
      }
      ?>
</div>

   <div class="more-btn">
      <a href="add_forum.php" class="inline-option-btn">Create Post</a>
   </div>

</section>

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>