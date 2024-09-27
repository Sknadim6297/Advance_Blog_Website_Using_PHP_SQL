<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('location:login.php');
    exit;
}

$username = $_SESSION['username'];
$admin_id = $_SESSION['id'];

if (isset($_POST['post'])) {
    $name = $_SESSION['username'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    $status = 'active';

    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = './uploaded_img/' . basename($image);

        // Create the folder if it doesn't exist
        if (!is_dir('./uploaded_img')) {
            mkdir('./uploaded_img', 0777, true);
        }

        $select_image_query = "SELECT * FROM `posts` WHERE image = '$image' AND admin_id = '$admin_id'";
        $select_image_result = mysqli_query($conn, $select_image_query);

        if (mysqli_num_rows($select_image_result) > 0) {
            echo "<script>alert('Image name repeated!')</script>";
            $image = '';
        } elseif ($image_size > 2000000) {
            echo "<script>alert('Image size is too large!')</script>";
            $image = '';
        } else {
            // Move uploaded image to the correct folder
            if (!move_uploaded_file($image_tmp_name, $image_folder)) {
                echo "<script>alert('Failed to upload image!')</script>";
                $image = '';
            }
        }
    }

    // Save image path in the database
    if ($image !== '') {
        $image_path = 'uploaded_img/' . $image;  // Relative path for saving in the database
    } else {
        $image_path = '';  // Handle case if no image is uploaded
    }

    $insert_post_query = "INSERT INTO `posts` (admin_id, name, title, content, category, image, status) 
                      VALUES ('$admin_id', '$name', '$title', '$content', '$category', '$image_path', '$status')";

if (mysqli_query($conn, $insert_post_query)) {
    echo "<script>
        alert('Post created successfully!');
        window.location.href='Dashboard.php';
    </script>";
} else {
    die('Query failed: ' . mysqli_error($conn));
}
}
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