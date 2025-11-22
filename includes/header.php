<?php
if (!session_id()) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #1e202c;
        }
    </style>
</head>

<body class="text-[#bfc0d1]">

    <!-- FIXED SIDEBAR -->
    <aside class="fixed left-0 top-0 w-64 h-screen bg-[#1e202c] border-r border-[#31323e] flex flex-col py-6">

        <!-- Company Name -->
        <div class="text-center text-2xl font-bold text-[#60519b] mb-10">
            Your Company
        </div>

        <!-- Menu Items -->
        <nav class="flex-1 px-6 space-y-3">

            <a href="dashboard.php" 
               class="block py-2 px-3 rounded-md hover:bg-[#31323e] hover:text-white transition">
                Dashboard
            </a>

            <a href="operations.php" 
               class="block py-2 px-3 rounded-md hover:bg-[#31323e] hover:text-white transition">
                Operations
            </a>

            <a href="product.php" 
               class="block py-2 px-3 rounded-md hover:bg-[#31323e] hover:text-white transition">
                Product
            </a>

            <a href="history.php" 
               class="block py-2 px-3 rounded-md hover:bg-[#31323e] hover:text-white transition">
                History
            </a>

            <a href="setting.php" 
               class="block py-2 px-3 rounded-md hover:bg-[#31323e] hover:text-white transition">
                Setting
            </a>

        </nav>

        <!-- Logout Button -->
        <div class="px-6 mt-auto">
            <a href="../pages/login.php" 
               class="block w-full text-center py-2 bg-[#60519b] text-white rounded-md hover:bg-[#4f4181] transition">
                Log Out
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="ml-64 p-8">
        <!-- Your page content goes here -->
        <h1 class="text-3xl font-bold">Welcome to Inventory Management</h1>
    </main>

</body>
</html>
