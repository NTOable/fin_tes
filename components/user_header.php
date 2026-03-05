<?php
// SHOW MESSAGES
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

// CHECK USER ONCE (IMPORTANT)
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
$logged_in = $select_profile->rowCount() > 0;

if($logged_in){
   $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
}
?>

<header class="header">

<section class="flex">
   <?php if($logged_in){ ?>
   <a href="home.php" class="logo">Torchlight Tutoring</a> <?php } else { ?>
   <a class="logo">Torchlight Tutoring</a> 
   <?php } ?>

   <form action="search_course.php" method="post" class="search-form">
      <input type="text" name="search_course" placeholder="search courses..." required maxlength="100">
      <button type="submit" class="fas fa-search" name="search_course_btn"></button>
   </form>

   <div class="icons">
      <div id="menu-btn" class="fas fa-bars"></div>
      <div id="search-btn" class="fas fa-search"></div>
      <div id="user-btn" class="fas fa-user"></div>
      <div id="toggle-btn" class="fas fa-sun"></div>
   </div>

   <div class="profile">
      <?php if($logged_in){ ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>Student</span>
         <a href="profile.php" class="btn">View Profile</a>
         <a href="components/user_logout.php"
            onclick="return confirm('Logout?');"
            class="delete-btn">Logout</a>
      <?php } else { ?>
         <h3>Please login or register first</h3>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">Login</a>
            <a href="choose_role.php" class="option-btn">Register</a>
         </div>
      <?php } ?>
   </div>

</section>
</header>

<!-- SIDEBAR -->
<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
      <?php if($logged_in){ ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>Student</span>
         <a href="profile.php" class="btn">My Profile</a>
      <?php } else { ?>
         <h3>Please login or register</h3>
         <div class="flex-btn" style="padding-top:.5rem;">
            <a href="login.php" class="option-btn">Login</a>
            <a href="choose_role.php" class="option-btn">Register</a>
         </div>
      <?php } ?>
   </div>

   <nav class="navbar">
      <?php if($logged_in){ ?>
         <a href="home.php"><i class="fas fa-home"></i><span>Home</span></a>
         <a href="forum.php"><i class="fas fa-comments"></i><span>Forum</span></a>
         <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
         <a href="tutor.php"><i class="fas fa-chalkboard-user"></i><span>Tutors</span></a>
         <a href="about.php"><i class="fas fa-question"></i><span>About Us</span></a>
         <a href="contact.php"><i class="fas fa-headset"></i><span>Contact Us</span></a>
         <a href="components/user_logout.php" onclick="return confirm('Logout?');"><i class="fas fa-right-from-bracket"></i><span>Logout</span></a>
      <?php } else { ?>
         <a href="about.php"><i class="fas fa-question"></i><span>About Us</span></a>
         <a href="contact.php"><i class="fas fa-headset"></i><span>Contact Us</span></a>
      <?php } ?>
   </nav>

</div> <!-- CLOSE side-bar -->

<!-- PAGE WRAPPER (for sticky footer layout) -->
<div class="main-content">