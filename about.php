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
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/company-logo.png" alt="">
      </div>

      <div class="content">
         <h3>"One mind lights another."</h3>
         <p>As our saying goes, we wish to help connect students and tutors to flourish and collaborate with one another, 
            bridging the gap in education by delivering quality education.
         </p>
         <a href="courses.php" class="inline-btn">Our Courses</a>
      </div>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-graduation-cap"></i>
         <div>
            <h3>+500</h3>
            <span>Courses</span>
         </div>
      </div>
      <!--  -->
      <div class="box">
         <i class="fas fa-user-graduate"></i>
         <div>
            <h3>+25k</h3>
            <span>Students</span>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-chalkboard-user"></i>
         <div>
            <h3>+5k</h3>
            <span>Tutors</span>
         </div>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- reviews section starts  -->

<section class="reviews">

   <h1 class="heading">User Reviews</h1>

   <div class="box-container">

      <div class="box">
         <p>Everyone has so much engagement with each other, both students and teachers. It's the most memorable community I've ever been apart of!</p>
         <div class="user">
            <img src="images/pic-2.jpg" alt=""> 
            <div>
               <h3>S.A.L</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="box">
         <p>Really nice app! I love it!</p>
         <div class="user">
            <img src="images/pic-3.jpg" alt="">
            <div>
               <h3>H.A.S</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="box">
         <p>I am impressed with the app!</p>
         <div class="user">
            <img src="images/pic-4.jpg" alt="">
            <div>
               <h3>Anonymous</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

   </div>

</section>

<!-- reviews section ends -->

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>