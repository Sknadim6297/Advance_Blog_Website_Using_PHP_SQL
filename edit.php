<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('location:login.php');
    exit;
}

$username = $_SESSION['username'];
$admin_id = $_SESSION['id'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="min-h-screen bg-gray-100 flex justify-center items-center">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="bg-background text-primary-foreground p-6 rounded-lg shadow-lg w-full max-w-2xl">
            <h2 class="text-2xl font-bold mb-4 text-center">Create a New Post</h2>

            <label for="post-title" class="block text-sm font-medium mt-2">Post Title</label>
            <input type="text" id="post-title" name="title" class="w-full px-3 py-2 rounded-lg border bg-input focus:outline-none focus:ring focus:ring-primary" placeholder="Enter post title..." required />

            <label for="post-content" class="block text-sm font-medium mt-4">Post Content</label>
            <textarea id="post-content" name="content" class="w-full px-3 py-2 rounded-lg border bg-input focus:outline-none focus:ring focus:ring-primary" placeholder="Write your post content..." required></textarea>

            <label for="post-categories" class="block text-sm font-medium mt-4">Category</label>
            <select name="category" class="w-full px-3 py-2 rounded-lg border bg-input focus:outline-none focus:ring focus:ring-primary" required>
                <option value="" selected disabled>-- select category* --</option>
                <option value="nature">Nature</option>
                <option value="education">Education</option>
                <option value="pets and animals">Pets and Animals</option>
                <option value="technology">Technology</option>
                <!-- Add other categories here -->
            </select>

            <label for="post-image" class="block text-sm font-medium mt-4">Post Image</label>
            <input type="file" id="post-image" name="image" accept="image/*" class="mt-2 mb-8" />

            <button name="post" class="bg-black text-white mt-4 px-4 py-2 w-full rounded-lg">Create Post</button>
        </div>
    </form>
</body>

</html>