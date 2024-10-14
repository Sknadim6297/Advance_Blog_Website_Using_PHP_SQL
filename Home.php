<?php
include 'connection.php';
session_start();

// Fetch posts
$query = "SELECT id, name, title, content, category, image, date, likes FROM posts ORDER BY date DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
    exit();
}

// Handle Like Request
// Handle Like Request
if (isset($_POST['action']) && $_POST['action'] == 'like') {
    if (isset($_POST['post_id']) && isset($_SESSION['login_id'])) {
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['login_id'];

        // Check if the user has already liked the post
        $check_like_query = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
        $check_like_result = mysqli_query($conn, $check_like_query);

        if (mysqli_num_rows($check_like_result) > 0) {
            // User has already liked the post, so we can 'unlike' it
            $unlike_query = "DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
            $unlike_result = mysqli_query($conn, $unlike_query);
            if ($unlike_result) {
                // Decrease like count in posts table
                $update_like_query = "UPDATE posts SET likes = likes - 1 WHERE id = '$post_id'";
                mysqli_query($conn, $update_like_query);
                echo "Post unliked successfully";
            } else {
                echo "Failed to unlike post";
            }
        } else {
            // Insert like
            $like_query = "INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')";
            $like_result = mysqli_query($conn, $like_query);

            if ($like_result) {
                // Update like count in posts table
                $update_like_query = "UPDATE posts SET likes = likes + 1 WHERE id = '$post_id'";
                mysqli_query($conn, $update_like_query);
                echo "Post liked successfully";
            } else {
                echo "Failed to like post";
            }
        }
    } else {
        echo "You need to be logged in to like this post";
    }
    exit(); // Stop further execution for AJAX request
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Posts</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include './user/user_header.php'; ?>

    <!-- Login/Register Section -->
    <div class="flex items-center justify-center w-full my-10">
        <div class="p-6 bg-white rounded-md text-center">
            <?php if (isset($_SESSION['login_username'])): ?>
                <p class="text-gray-700 text-5xl mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['login_username']); ?>!</p>
                <p>Now You can like or comment and share in blogs</p>
            <?php else: ?>
                <p class="text-gray-700 text-3xl mb-4">Login or Register!</p>
                <div class="flex justify-center space-x-4">
                    <button class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                        <a href="./user/User_login.php">Login</a>
                    </button>
                    <button class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                        <a href="./user/User_register.php">Register</a>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <h1 class="text-center m-10 text-5xl">Latest Posts</h1>

    <!-- Posts Section -->
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="bg-card p-6 rounded-lg shadow-lg flex flex-col h-full post" data-post-id="<?php echo $row['id']; ?>">
                    <!-- Blog Post Content -->
                    <div class="flex-grow">
                        <span class="border px-4 bg-black text-white rounded-full"><?php echo htmlspecialchars($row['name']); ?></span>
                        <span class="border text-sm px-4 bg-gray-400 rounded-md"><?php echo htmlspecialchars($row['date']); ?></span>
                        <br>
                        <span class="border px-4 bg-green-400 rounded-full"><?php echo htmlspecialchars($row['category']); ?></span>

                        <?php if (!empty($row['image'])): ?>
                            <img aria-hidden="true" alt="Post Image"
                                src="<?php echo htmlspecialchars($row['image']); ?>"
                                class="w-full h-48 object-cover rounded-lg mb-4 mt-3" />
                        <?php endif; ?>

                        <div class="text-center">
                            <p class="text-lg font-bold text-primary"><?php echo htmlspecialchars($row['title']); ?></p>
                            <p class="text-md text-muted-foreground"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                        </div>
                    </div>

                    <!-- Like, Comment, Share Buttons -->
                    <div class="flex justify-between items-center mt-4 text-gray-600">
                        <button class="flex items-center space-x-1 hover:text-blue-500 like-btn" data-liked="false">
                            <i class="fa-regular fa-heart"></i>
                            <span>Like</span>
                            <span class="like-count text-sm text-gray-400">(<?php echo $row['likes']; ?>)</span>
                        </button>
                        <button class="flex items-center space-x-1 hover:text-blue-500">
                            <i class="fa-regular fa-comment"></i>
                            <span>Comment</span>
                            <span class="text-sm text-gray-400">(12)</span>
                        </button>
                        <button class="flex items-center space-x-1 hover:text-blue-500">
                            <i class="fa-solid fa-share"></i>
                            <span>Share</span>
                        </button>
                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.closest('.post').getAttribute('data-post-id');
                const likeCountSpan = this.querySelector('.like-count');
                const isLiked = this.getAttribute('data-liked') === 'true';

                // Make an AJAX request to like/unlike the post
                fetch('', { // Empty string for the current file
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `action=like&post_id=${postId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data); // Display the response message

                        if (data.includes("Post liked successfully")) {
                            // Increment the like count and toggle button state
                            let currentCount = parseInt(likeCountSpan.textContent.replace(/[()]/g, ''));
                            likeCountSpan.textContent = `(${currentCount + 1})`;
                            this.setAttribute('data-liked', 'true'); // Update the like status
                            this.classList.add('text-blue-500'); // Change text color to blue
                        } else if (data.includes("You have already liked this post")) {
                            // If already liked, show an alert or feedback
                            alert("You've already liked this post.");
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

</body>

</html>