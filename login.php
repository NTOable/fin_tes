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
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data" class="login">
      <h3>welcome back!</h3>
      <p>your email <span>*</span></p>
      <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
      <p>your password <span>*</span></p>
      <input type="password" name="pass" placeholder="enter your password" maxlength="20" required class="box">
      <p class="link">don't have an account? <a href="register.php">register now</a></p>
      <input type="submit" name="submit" value="login now" class="btn">
   </form>

<?php

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);


   // =====================
   // CHECK ADMINS
   // =====================
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE email = ? AND password = ? LIMIT 1");
   $select_admin->execute([$email, $pass]);
   $admin = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){

      setcookie('admin_id', $admin['id'], time() + 60*60*24*30, '/');
      header('location:admin/dashboard.php');
      exit();

   }


   // =====================
   // CHECK TUTORS
   // =====================
   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND password = ? LIMIT 1");
   $select_tutor->execute([$email, $pass]);
   $tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

   if($select_tutor->rowCount() > 0){

      setcookie('tutor_id', $tutor['id'], time() + 60*60*24*30, '/');
      header('location:tutor_home.php');
      exit();

   }


   // =====================
   // CHECK USERS (students)
   // =====================
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $select_user->execute([$email, $pass]);
   $user = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){

      setcookie('user_id', $user['id'], time() + 60*60*24*30, '/');
      header('location:home.php');
      exit();

   }

   // =====================
   // NOT FOUND
   // =====================
   $message[] = 'incorrect email or password!';

}

?>

</section>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>