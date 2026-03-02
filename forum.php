<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

$select_posts = $conn->prepare("SELECT * FROM `forum_posts`");
$select_posts->execute();
$total_posts = $select_posts->rowCount();

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
               $post_id = $fetch_forum['id'];

               $select_student = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_student->execute([$fetch_forum['user_id']]);
               $fetch_student = $select_student->fetch(PDO::FETCH_ASSOC);
      ?>

      <div class="box">
         <div class="tutor">
            <div class="info">
                 <h3 class ="title"><?= $fetch_student['name']; ?></h3>
               <span><?= $fetch_forum['date']; ?></span>
               <p class= "message"><?= $fetch_forum['title']; ?></p>
            </div>  
         </div>
         <div class="thumb">
            <img src="images/thumb-1.png" alt="">
            <!-- span should be replaced with -->
            <!-- <span> global variable for fetch all 
               comments linked to a single post </span>  -->
            <span>10 comments</span> 
         </div>
         <a href="replies.php" class="inline-btn">View Thread</a>
      </div>
            <?php
         }
      }else{
         echo '<p class="empty">no forums added yet!</p>';
      }
      ?>

      <!-- add new forum boxes -->

   </div>
<!-- Condition where if no Forums are found from DB, show no forums found -->
   <div class="more-btn">
      <a href="add_forum.php" class="inline-option-btn">Create a Forum Post</a>
   </div>
<!-- NEED TO MODIFY CSS -->
<!-- TO ONLY SHOW THREE THREADS AT A TIME -->

   <div class="more-btn">
      <a href="forum.php" class="inline-option-btn">View More Forums</a>
   </div>

</section>

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>