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

<h1 style="text-align:center;">Torchlight Tutoring</h1>
<h2 style="text-align:center;">What would you like to be?</h2>

<!-- CHOOSE ROLE -->
<div style="text-align:center; margin-top:30px;">

   <!-- Student Button -->
   <form action="register.php" method="get" style="display:inline;">
      <button type="submit" class="btn">Student</button>
   </form>

   <!-- Tutor Button -->
   <form action="tutor/register.php" method="get" style="display:inline;">
      <button type="submit" class="btn">Tutor</button>
   </form>

</div>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>