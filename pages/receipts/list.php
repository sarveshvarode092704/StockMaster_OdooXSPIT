<?php
include "../../includes/header.php";
include "../../config/db.php";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Receipts List</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --dark1: #1e202c;
      --dark2: #31323e;
      --purple: #60519b;
      --light: #bfc0d1;
    }
  </style>
</head>

<body class="min-h-screen bg-[var(--dark1)] text-[var(--light)]">
<main class="p-6 ml-64">

  <div class="max-w-5xl mx-auto bg-[var(--dark2)] p-8 rounded-2xl shadow-xl border border-[var(--purple)]">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-white">Receipts</h1>

      <a href="/StockMaster_OdooXSPIT/pages/receipts/create.php"
         class="px-5 py-2 bg-[var(--purple)] text-white rounded-lg hover:bg-purple-700 transition">
        + Create Receipt
      </a>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead>
          <tr class="bg-[var(--purple)] text-white">
            <th class="p-3">ID</th>
            <th class="p-3">Receipt No</th>
            <th class="p-3">Supplier</th>
            <th class="p-3">Warehouse</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = "
            SELECT r.*, w.name AS warehouse_name 
            FROM receipts r 
            LEFT JOIN warehouses w ON w.id = r.warehouse_id 
            ORDER BY r.id DESC
          ";
          $rows = $conn->query($query);

          while ($r = $rows->fetch_assoc()) {
              echo "
              <tr class='border-b border-[#1e202c] hover:bg-[#2a2b33] transition'>
                <td class='p-3'>{$r['id']}</td>
                <td class='p-3'>" . htmlspecialchars($r['receipt_no']) . "</td>
                <td class='p-3'>" . htmlspecialchars($r['supplier']) . "</td>
                <td class='p-3'>" . htmlspecialchars($r['warehouse_name']) . "</td>
                <td class='p-3'>
                   <span class='px-3 py-1 rounded-full text-sm 
                       " . ($r['status'] == 'Draft' ? 'bg-yellow-500 text-black' : 'bg-green-600 text-white') . "'>
                       {$r['status']}
                   </span>
                </td>
                <td class='p-3'>
                  <a href='view.php?id={$r['id']}' class='text-purple-400 hover:underline'>
                    View
                  </a>
                </td>
              </tr>
              ";
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>

</main>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
