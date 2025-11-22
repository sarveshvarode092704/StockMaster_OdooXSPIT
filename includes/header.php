<?php
if (!session_id()) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: ./auth/login.php");
    exit();
}
?>

<!-- Alpine & Tailwind -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                dark1: "#1e202c",
                purple: "#60519b",
                dark2: "#31323e",
                light: "#bfc0d1",
            }
        }
    }
}
</script>

<!-- SIDEBAR -->
<aside class="fixed left-0 top-0 w-64 h-screen bg-dark1 border-r border-dark2 flex flex-col py-6">

    <!-- Company Name -->
    <div class="text-center text-2xl font-bold text-purple mb-10">
        Company
    </div>

    <!-- MENU -->
    <nav class="flex-1 px-6 space-y-3 text-light">

        <a href="../pages/dashboard.php" 
           class="block py-2 px-3 rounded-md hover:bg-dark2 hover:text-white transition">
            Dashboard
        </a>

        <a href="../pages/product.php" 
           class="block py-2 px-3 rounded-md hover:bg-dark2 hover:text-white transition">
            Product
        </a>

        <!-- Warehouse -->
        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open"
                class="w-full flex justify-between items-center py-2 px-3 rounded-md hover:bg-dark2 hover:text-white transition">
                <span>Warehouse</span>
                <span x-text="open ? '-' : '+'"></span>
            </button>

            <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
                <a href="/StockMaster_OdooXSPIT/pages/warehouses/add.php" 
                   class="block py-2 px-3 rounded-md hover:bg-dark2 transition">
                    Add Warehouse
                </a>

                <a href="/StockMaster_OdooXSPIT/pages/warehouses/list.php" 
                   class="block py-2 px-3 rounded-md hover:bg-dark2 transition">
                    View / Edit Warehouse
                </a>
            </div>
        </div>

        <!-- Deliveries -->
        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open"
                class="w-full flex justify-between items-center py-2 px-3 rounded-md hover:bg-dark2 hover:text-white transition">
                <span>Deliveries</span>
                <span x-text="open ? '-' : '+'"></span>
            </button>

            <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
                <a href="/StockMaster_OdooXSPIT/pages/deliveries/create.php" 
                   class="block py-2 px-3 rounded-md hover:bg-dark2 transition">
                    Add Delivery
                </a>

                <a href="/StockMaster_OdooXSPIT/pages/deliveries/list.php" 
                   class="block py-2 px-3 rounded-md hover:bg-dark2 transition">
                    View / Edit Deliveries
                </a>
            </div>
        </div>

        <!-- Transfers -->
        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open"
                class="w-full flex justify-between items-center py-2 px-3 rounded-md hover:bg-dark2 hover:text-white transition">
                <span>Transfers</span>
                <span x-text="open ? '-' : '+'"></span>
            </button>

            <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
                <a href="/StockMaster_OdooXSPIT/pages/transfers/create.php" 
                   class="block py-2 px-3 rounded-md hover:bg-dark2 transition">
                    Add Transfer
                </a>

                <a href="/StockMaster_OdooXSPIT/pages/transfers/list.php" 
                   class="block py-2 px-3 rounded-md hover:bg-dark2 transition">
                    View / Edit Transfers
                </a>
            </div>
        </div>

    </nav>

    <!-- Logout Button -->
    <div class="px-6 mt-auto">
        <a href="./auth/logout.php" 
           class="block w-full text-center py-2 bg-purple text-white rounded-md hover:bg-purple/80 transition">
            Log Out
        </a>
    </div>

</aside>
