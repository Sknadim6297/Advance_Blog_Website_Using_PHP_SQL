<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('location:login.php');
    exit();
}

$admin_id = $_SESSION['id'];
$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    echo "Invalid post ID.";
    exit();
}

// Verify if the post belongs to the logged-in admin
$select_post_query = "SELECT * FROM `posts` WHERE id = '$post_id' AND admin_id = '$admin_id'";
$select_post_result = mysqli_query($conn, $select_post_query);

if (mysqli_num_rows($select_post_result) > 0) {
    $fetch_post = mysqli_fetch_assoc($select_post_result);
    
    // Delete post image if exists
    if ($fetch_post['image'] != '') {
        $image_path = '../uploaded_img/' . $fetch_post['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // Delete post and related comments
    $delete_post_query = "DELETE FROM `posts` WHERE id = '$post_id'";
    $delete_comments_query = "DELETE FROM `comments` WHERE post_id = '$post_id'";

    mysqli_query($conn, $delete_post_query);
    mysqli_query($conn, $delete_comments_query);

    echo "<script>
            alert('Post deleted successfully!');
            window.location.href = 'view_post.php';
          </script>";
    exit();
} else {
    echo "Post not found or you do not have permission to delete this post.";
    exit();
}
?>
