<?php
include '../connection.php';

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT); 


    $sql = "SELECT * FROM `user2` WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('User Already Exists')</script>";
    } else {

        $insert_user = "INSERT INTO `user2`(`username`, `email`, `password`,`role`) VALUES ('$username','$email','$hashed_pass', 'user')";
        
        if(mysqli_query($conn, $insert_user)){
            echo "<script>alert('User Registration Successful')
            window.location.href='User_login.php';

            </script>";
        } else {
            echo "<script>alert('Error in Registration')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

<div class="flex items-center justify-center min-h-screen bg-background">
  <div class="bg-card shadow-lg rounded-lg p-8 max-w-md w-full">
    <h2 class="text-2xl font-bold text-primary text-center mb-6">User Register</h2>
    <form class="space-y-4" action=""  method="post">
    <div>
        <label for="email" class="block text-sm font-medium text-primary">Username</label>
        <input type="text" id="email" name="username" class="w-full px-3 py-2 rounded-lg border focus:outline-none focus:ring focus:ring-primary" placeholder="Enter your username" required />
      </div>
      <div>
        <label for="email" class="block text-sm font-medium text-primary">Email</label>
        <input type="email" id="email" name="email" class="w-full px-3 py-2 rounded-lg border focus:outline-none focus:ring focus:ring-primary" placeholder="john.doe@example.com" required />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-primary">Password</label>
        <input type="password" id="password" name="pass" class="w-full px-3 py-2 rounded-lg border focus:outline-none focus:ring focus:ring-primary" placeholder="Enter your password" required />
      </div>
      <button type="submit" class="w-full bg-black text-white py-2 rounded-lg" name="submit">Register</button>
    </form>
    <div class="flex gap-2 mt-4">
        Already have an account?
    <a href="User_login.php" class="text-red-600 font-bold">Login </a>
    </div>

  </div>
</div>
   
</body>

</html>