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
    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #1e202c;
        }
    </style>
</head>

<body class="text-[#bfc0d1]">

    <!-- INCLUDE SIDEBAR -->
    <?php include '../includes/header.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="ml-64 p-8">

        <h1 class="text-3xl font-bold mb-8">Dashboard Overview</h1>

        <!-- KPI CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <!-- Total Stock -->
            <div class="bg-[#262836] rounded-xl p-6 border border-[#31323e]">
                <div class="text-lg font-semibold">Total Stock</div>
                <div class="text-3xl font-bold text-white mt-3">
                    <?php echo 0; ?>
                </div>
            </div>

            <!-- Low Stock Items -->
            <div class="bg-[#262836] rounded-xl p-6 border border-[#31323e]">
                <div class="text-lg font-semibold">Low Stock</div>
                <div class="text-3xl font-bold text-yellow-400 mt-3">
                    <?php echo 0; ?>
                </div>
            </div>

            <!-- Pending Receipts -->
            <div class="bg-[#262836] rounded-xl p-6 border border-[#31323e]">
                <div class="text-lg font-semibold">Pending Receipts</div>
                <div class="text-3xl font-bold text-blue-400 mt-3">
                    <?php echo 0; ?>
                </div>
            </div>

            <!-- Pending Deliveries -->
            <div class="bg-[#262836] rounded-xl p-6 border border-[#31323e]">
                <div class="text-lg font-semibold">Pending Deliveries</div>
                <div class="text-3xl font-bold text-red-400 mt-3">
                    <?php echo 0; ?>
                </div>
            </div>

        </div>

    </main>
    <!-- Recent Receipts Section -->
<div class="mt-10">
    <h2 class="text-2xl font-bold mb-4">Recent Receipts</h2>

    <div class="bg-[#262836] border border-[#31323e] rounded-xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-[#31323e] text-white">
                <tr>
                    <th class="py-3 px-4">Receipt No</th>
                    <th class="py-3 px-4">Supplier</th>
                    <th class="py-3 px-4">Warehouse</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Placeholder until DB is connected
                for ($i=1; $i<=3; $i++): ?>
                    <tr class="border-t border-[#31323e]">
                        <td class="py-3 px-4">RCPT-00<?php echo $i; ?></td>
                        <td class="py-3 px-4">Supplier <?php echo $i; ?></td>
                        <td class="py-3 px-4">Main Warehouse</td>
                        <td class="py-3 px-4 text-blue-400">Pending</td>
                        <td class="py-3 px-4"><?php echo date("Y-m-d"); ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Recent Deliveries Section -->
<div class="mt-10">
    <h2 class="text-2xl font-bold mb-4">Recent Deliveries</h2>

    <div class="bg-[#262836] border border-[#31323e] rounded-xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-[#31323e] text-white">
                <tr>
                    <th class="py-3 px-4">Delivery No</th>
                    <th class="py-3 px-4">Customer</th>
                    <th class="py-3 px-4">Warehouse</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Placeholder until DB is connected
                for ($i=1; $i<=3; $i++): ?>
                    <tr class="border-t border-[#31323e]">
                        <td class="py-3 px-4">DLV-00<?php echo $i; ?></td>
                        <td class="py-3 px-4">Customer <?php echo $i; ?></td>
                        <td class="py-3 px-4">Main Warehouse</td>
                        <td class="py-3 px-4 text-yellow-400">Processing</td>
                        <td class="py-3 px-4"><?php echo date("Y-m-d"); ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>
