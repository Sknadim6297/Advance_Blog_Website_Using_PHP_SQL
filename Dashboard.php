<?php

include 'connection.php';
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('location:login.php');
    exit();
}
$username = $_SESSION['username'];
$admin_id = $_SESSION['id'];
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="h-screen flex bg-background">
        <!-- Left menu section -->
        <div class="w-1/4 bg-black flex flex-col justify-center items-center gap-10">
            <div class="text-white">
                <h1 class="text-4xl font-bold">Namaste, <br><?php echo htmlspecialchars($username); ?>!</h1>
            </div>
            <div class="p-4">
                <button class="bg-black text-white w-full py-2 rounded-lg mb-4">Update Profile</button>
                <button class="bg-black text-white w-full py-2 rounded-lg mb-4"><a href="Home.php">Home</a></button>
                <a href="add_posts.php"><button class="bg-black text-white w-full py-2 rounded-lg mb-4">Add Post</button></a>
                <a href="view_post.php"><button class="bg-black text-white w-full py-2 rounded-lg mb-4">View Post</button></a>
                <button class="bg-black text-white w-full py-2 rounded-lg mb-4"><a href="admin_accounts.php">Accounts</a></button>
            </div>
            <div class="flex justify-center items-center">
                <a href="logout.php"><button class="bg-white text-black w-full px-10 py-2 rounded-lg mb-4">Logout</button></a>
            </div>
        </div>
        <div class="w-3/4 p-6 bg-background rounded-lg shadow-md h-screen overflow-y-auto">
            <h1 class="text-center text-4xl">Dashboard</h1>
            <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="bg-card p-10 rounded-lg shadow border flex flex-col">
                    <?php
                    $select_posts = mysqli_query($conn, "SELECT * FROM `posts` WHERE admin_id = '$admin_id'") or die('query failed');
                    $numbers_of_posts = mysqli_num_rows($select_posts);
                    $select_active_post = mysqli_query($conn, "SELECT * FROM `posts` WHERE admin_id = '$admin_id' AND status = 'active'") or die('query failed');
                    $numbers_of_active_posts = mysqli_num_rows($select_active_post);

                    $number_of_admin = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');

                    $numbers_of_admin = mysqli_num_rows($number_of_admin);

                    $number_of_comments = mysqli_query($conn, "SELECT * FROM `comments`") or die('query failed');
                    $comments = mysqli_num_rows($number_of_comments);

                    $number_of_likes= mysqli_query($conn, "SELECT * FROM `likes`") or die('query failed');
                    $likes = mysqli_num_rows($number_of_likes);

                    $number_of_users= mysqli_query($conn, "SELECT * FROM `user2`") or die('query failed');
                    $users = mysqli_num_rows($number_of_users);
                    ?>
                    <h2 class="text-lg font-semibold text-center"><?= $numbers_of_posts; ?></h2>
                    <p class="border p-2 text-center">posts added</p>
                    <button class="bg-black text-white  mt-5 p-2 rounded-xl"><a href="add_posts.php">Add Post</a></button>
                </div>
                <div class="bg-card p-10 rounded-lg shadow border flex flex-col">
                    <h2 class="text-lg font-semibold text-center"><?= $numbers_of_active_posts; ?></h2>
                    <p class="border p-2 text-center">Active posts</p>
                    <button class="bg-black text-white  mt-5 p-2 rounded-xl"><a href="view_post.php">See Posts</a></button>
                </div>
                <div class="bg-card p-10 rounded-lg shadow border flex flex-col">
                    <h2 class="text-lg font-semibold text-center">0</h2>
                    <p class="border p-2 text-center">Deactive posts</p>
                    <button class="bg-black text-white  mt-5 p-2 rounded-xl"><a href="deactive.php">See Posts</a></button>
                </div>
                <div class="bg-card p-10 rounded-lg shadow border flex flex-col">
                    <h2 class="text-lg font-semibold text-center"><?=$users;?></h2>
                    <p class="border p-2 text-center">User Accounts</p>
                    <button class="bg-black text-white  mt-5 p-2 rounded-xl">See Users</button>
                </div>
                <div class="bg-card p-10 rounded-lg shadow border flex flex-col">
                    <h2 class="text-lg font-semibold text-center"><?= $numbers_of_admin; ?></h2>
                    <p class="border p-2 text-center">Admin Accounts</p>
                    <button class="bg-black text-white  mt-5 p-2 rounded-xl">See Admins</button>
                </div>
                <div class="bg-card p-10 rounded-lg shadow border flex flex-col">
                    <h2 class="text-lg font-semibold text-center"><?= $comments; ?></h2>
                    <p class="border p-2 text-center">Comment Added</p>
                    <button class="bg-black text-white  mt-5 p-2 rounded-xl">See Comments</button>
                </div>
                <div class="bg-card p-10 rounded-lg shadow border flex flex-col">
                    <h2 class="text-lg font-semibold text-center"><?=$likes;?></h2>
                    <p class="border p-2 text-center">Total likes</p>
                    <button class="bg-black text-white  mt-5 p-2 rounded-xl">See Posts</button>
                </div>

            </div>
        </div>
    </div>
</body>

</html>