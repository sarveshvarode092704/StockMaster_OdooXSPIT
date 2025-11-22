<?php
if (!session_id()) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: ./auth/login.php");
    exit();
}
?>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


<!-- SIDEBAR --><aside class="fixed left-0 top-0 w-64 h-screen bg-[#1e202c] border-r border-[#31323e] flex flex-col py-6">

    <!-- Company Name -->
    <div class="text-center text-2xl font-bold text-[#60519b] mb-10">
        Company
    </div>

    <!-- Menu Items -->
    <nav class="flex-1 px-6 space-y-3">

        <a href="../pages/dashboard.php" 
           class="block py-2 px-3 rounded-md hover:bg-[#31323e] hover:text-white transition">
            Dashboard
        </a>

        <a href="../pages/product.php" 
           class="block py-2 px-3 rounded-md hover:bg-[#31323e] hover:text-white transition">
            Product
        </a>
<div x-data="{ open: false }" class="mt-2">

    <button @click="open = !open" 
        class="w-full flex justify-between items-center py-2 px-3 rounded-md hover:bg-[#31323e] hover:text-white transition">
        <span>Warehouse</span>
        <span x-text="open ? '-' : '+'"></span>
    </button>

    <div x-show="open" x-transition class="ml-4 mt-1">
        <a href="http://localhost/StockMaster_OdooXSPIT/pages/warehouses/add.php" 
           class="block py-2 px-3 rounded-md hover:bg-[#31323e] transition">
            Add Warehouse
        </a>

        <a href="http://localhost/StockMaster_OdooXSPIT/pages/warehouses/list.php" 
           class="block py-2 px-3 rounded-md hover:bg-[#31323e] transition">
            View / Edit Warehouse
        </a>
    </div>

</div>

        
       
    </nav>

    <!-- LOGOUT -->
    <div class="px-6 mt-auto">
        <a href="./auth/logout.php" 
           class="block w-full text-center py-2 bg-[#60519b] text-white rounded-md hover:bg-[#4f4181] transition">
            Log Outtt
        </a>
    </div>

</aside>
