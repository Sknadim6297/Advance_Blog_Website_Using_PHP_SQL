<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('location:login.php');
    exit();
}
$username = $_SESSION['username'];
$admin_id = $_SESSION['id'];

$get_id = $_GET['post_id'] ?? null;
if (!$get_id) {
    echo "Invalid post ID.";
    exit();
}

// Fetch post by ID and admin ID
$select_posts_query = "SELECT * FROM `posts` WHERE admin_id = '$admin_id' AND id = '$get_id'";
$select_posts_result = mysqli_query($conn, $select_posts_query);

if (mysqli_num_rows($select_posts_result) > 0) {
    $fetch_posts = mysqli_fetch_assoc($select_posts_result);
    $post_id = $fetch_posts['id'];

    // Count post comments
    $count_post_comments_query = "SELECT * FROM `comments` WHERE post_id = '$post_id'";
    $count_post_comments_result = mysqli_query($conn, $count_post_comments_query);
    $total_post_comments = mysqli_num_rows($count_post_comments_result);

    // Count post likes
    $count_post_likes_query = "SELECT * FROM `likes` WHERE post_id = '$post_id'";
    $count_post_likes_result = mysqli_query($conn, $count_post_likes_query);
    $total_post_likes = mysqli_num_rows($count_post_likes_result);
} else {
    echo "Post not found.";
    exit();
}

if (isset($_POST['delete'])) {
    // Sanitize post ID
    $p_id = filter_var($get_id, FILTER_SANITIZE_STRING);

    // Select and delete post's image
    $delete_image_query = "SELECT * FROM `posts` WHERE id = '$p_id'";
    $delete_image_result = mysqli_query($conn, $delete_image_query);
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_result);

    if ($fetch_delete_image && !empty($fetch_delete_image['image'])) {
        $image_path = '../uploaded_img/' . $fetch_delete_image['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // Delete post and its comments
    mysqli_query($conn, "DELETE FROM `posts` WHERE id = '$p_id'");
    mysqli_query($conn, "DELETE FROM `comments` WHERE post_id = '$p_id'");

    header('location:view_posts.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen flex-col">
    <h1 class="text-5xl mt-5">Your Post</h1>
    <div class="status inline-block bg-green-500 text-white text-xs font-bold px-2 m-3 py-1 rounded-full" style="background-color:<?= $fetch_posts['status'] == 'active' ? 'limegreen' : 'coral'; ?>;">
        <?= htmlspecialchars($fetch_posts['status']); ?>
    </div>
    <div class="w-full max-w-5xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">


        <form method="post">
            <input type="hidden" name="post_id" value="<?= $post_id; ?>">

            <?php if ($fetch_posts['image'] != '') { ?>
                <img class="w-full h-full object-cover" src="<?= htmlspecialchars($fetch_posts['image']); ?>" alt="Post Image" />
            <?php } ?>

            <!-- Post Content -->
            <div class="p-6">
                <!-- Post Title -->
                <h1 class="text-2xl font-semibold mb-2"><?= htmlspecialchars($fetch_posts['title']) ?></h1>
                <!-- Post Description -->
                <p class="text-gray-700 mb-4"><?= htmlspecialchars($fetch_posts['content']) ?></p>

                <!-- Comment and Like Section -->
                <div class="flex items-center justify-between text-gray-500 text-sm mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center">
                            <span class="ml-1"><?= $total_post_comments ?> 💬</span>
                        </span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <span class="ml-1"><?= $total_post_likes ?> ❤️</span>
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between">
                    <button name="edit" class="bg-zinc-400 text-white px-4 py-2 rounded-lg"><a href="edit.php?id=<?= $post_id; ?>">Edit</a></button>
                    <button name="delete" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"><a href="delete_post.php?id=<?= $post_id; ?>">Delete</a></button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>