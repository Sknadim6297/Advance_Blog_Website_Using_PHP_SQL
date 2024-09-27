<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="flex justify-between items-center p-4 h-14 mx-20 mt-2">
        <!-- Logo -->
        <div class="font-bold text-3xl">Sk.Blog</div>

        <!-- Search bar -->
        <div class="relative w-1/3 " >
            <input type="text" placeholder="Search posts..." class="w-full p-1 rounded border border-gray-300 outline-none">
            <button class="absolute right-2 top-2 flex" >
                <i class="fa-solid fa-magnifying-glass h-6 w-6 text-gray-600"></i>
            </button>
        </div>

        <!-- Icons with dropdown -->
        <div class="flex space-x-2">
            <!-- Settings Icon -->
            <div class="relative">
                <button id="settingsIcon" class="bg-gray-300 p-2 px-3">
                <i class="fa-solid fa-bars"></i>
                </button>
                <div id="settingsDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Posts</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Categories</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Authors</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Login</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Register</a>
                </div>
            </div>

            <!-- Profile Icon -->
            <div class="relative">
                <button id="profileIcon" class="bg-gray-300 p-2 px-3">
                <i class="fa-solid fa-user"></i>
                </button>
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="../../../PHP Projects/SimpleLoginSignup/Dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Admin </a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>