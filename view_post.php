<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('location:login.php');
    exit;
}

$username = $_SESSION['username'];
$admin_id = $_SESSION['id'];


function display_content($content, $limit = 15) {
    // Split content into an array of words
    $words = explode(' ', strip_tags($content)); // Removing any HTML tags

    // If word count exceeds the limit
    if (count($words) > $limit) {
        $content = implode(' ', array_slice($words, 0, $limit)) . '...';
    }
    return $content;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">All Posts</h1>

        <div class="flex flex-wrap gap-4 mt-10">
            <?php
            // Fetch posts from the database
            $select_posts_query = "SELECT * FROM `posts` WHERE admin_id = '$admin_id'";
            $select_posts_result = mysqli_query($conn, $select_posts_query);

            if (mysqli_num_rows($select_posts_result) > 0) {
                while ($fetch_posts = mysqli_fetch_assoc($select_posts_result)) {
                    $post_id = $fetch_posts['id'];

                    // Count comments for each post
                    $count_post_comments_query = "SELECT * FROM `comments` WHERE post_id = '$post_id'";
                    $count_post_comments_result = mysqli_query($conn, $count_post_comments_query);
                    $total_post_comments = mysqli_num_rows($count_post_comments_result);

                    // Count likes for each post
                    $count_post_likes_query = "SELECT * FROM `likes` WHERE post_id = '$post_id'";
                    $count_post_likes_result = mysqli_query($conn, $count_post_likes_query);
                    $total_post_likes = mysqli_num_rows($count_post_likes_result);
            ?>

                    <div class="max-w-sm bg-card rounded-lg shadow-lg overflow-hidden flex-grow">
                        <?php if ($fetch_posts['image'] != '') { ?>
                            <img class="w-full h-48 object-cover" src="<?= htmlspecialchars($fetch_posts['image']); ?>" alt="Post Image" />
                        <?php } ?>
                        <div class="p-4">
                            <span class="inline-block bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full"><?= htmlspecialchars($fetch_posts['status']) ?></span>
                            <h2 class="text-lg font-semibold mt-2"><?= htmlspecialchars($fetch_posts['title']) ?></h2>
                            <p class="text-muted-foreground mt-1"><?= display_content(htmlspecialchars($fetch_posts['content'])) ?></p>


                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center">
                                    <span class="mr-2">💬 <?= $total_post_comments ?></span>
                                    <span class="mr-4">❤️ <?= $total_post_likes ?></span>
                                </div>
                                <div class="flex space-x-2">
                                <button class="w-full"><a href="read_post.php?post_id=<?= $post_id; ?>" class="mt-4  bg-black text-white px-3 py-1 rounded">Read Post</a></button>
                                    <a href="edit.php?id=<?= $post_id; ?>" class="bg-zinc-200 text-secondary-foreground hover:bg-secondary/80 px-3 py-1 rounded">Edit</a>
                                    <a href="delete_post.php?id=<?= $post_id; ?>" class="bg-red-800 text-white hover:bg-destructive/80 px-3 py-1 rounded">Delete</a>
                                </div>
                            </div>

                        </div>
                    </div>

            <?php
                }
            } else {
                echo "<p>No posts found.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>
