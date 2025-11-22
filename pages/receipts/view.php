<?php
include "../../includes/header.php";
include "../../config/db.php";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Receipt View</title>
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
  <main class="p-6 ml-64"> <!-- leave space for fixed sidebar -->
    <div class="max-w-4xl mx-auto">

<?php
// -----------------------------
// Search by receipt_no handling
// -----------------------------
$search_error = null;
if (isset($_GET['receipt_no']) && $_GET['receipt_no'] !== '') {
    $rc = trim($_GET['receipt_no']);

    $s = $conn->prepare("SELECT id FROM receipts WHERE receipt_no = ?");
    $s->bind_param("s", $rc);
    $s->execute();
    $res = $s->get_result()->fetch_assoc();
    $s->close();

    if ($res) {
        // Redirect to id-based view
        header("Location: view.php?id=" . intval($res['id']));
        exit;
    } else {
        $search_error = "Receipt not found: " . htmlspecialchars($rc);
    }
}

// -----------------------------
// Validate & get ID (if using id-based view)
// -----------------------------
$id = 0;
if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = intval($_GET['id']);
}

// If no id provided yet, just show search box and stop
if ($id <= 0 && !$search_error) {
    // show search-only UI below
}
?>

      <div class="bg-[var(--dark2)] p-6 rounded-2xl shadow-xl border border-[var(--purple)]">

        <!-- Search Form -->
        <form action="view.php" method="GET" class="mb-6">
          <div class="flex gap-3">
              <input type="text" name="receipt_no"
                     placeholder="Enter Receipt No (e.g., REC-0005)"
                     class="w-full p-3 bg-[var(--dark1)] rounded-lg text-white border border-[var(--light)]
                            focus:ring-2 focus:ring-[var(--purple)]"
                     value="<?php echo isset($_GET['receipt_no']) ? htmlspecialchars($_GET['receipt_no']) : ''; ?>">
              <button type="submit"
                      class="px-5 py-3 bg-[var(--purple)] text-white rounded-lg hover:bg-purple-700 transition">
                  Search
              </button>
          </div>
        </form>

<?php if ($search_error) { ?>
        <div class="bg-red-600 text-white p-3 rounded-lg mb-4"><?php echo $search_error; ?></div>
<?php } ?>

<?php
// If no id supplied (and no search found), show a friendly note
if ($id <= 0) {
    if (!$search_error) {
        echo '<div class="text-[var(--light)] mb-4">Enter a receipt number above or open a receipt from the <a href="/StockMaster_OdooXSPIT/pages/receipts/list.php" class="text-[var(--purple)] hover:underline">Receipts list</a>.</div>';
    }
    echo '</div></main>';
    include "../../includes/footer.php";
    echo '</body></html>';
    exit;
}

// -----------------------------
// Fetch receipt & warehouse
// -----------------------------
$rcpStmt = $conn->prepare("SELECT r.*, w.name AS warehouse_name FROM receipts r LEFT JOIN warehouses w ON w.id = r.warehouse_id WHERE r.id = ?");
$rcpStmt->bind_param("i", $id);
$rcpStmt->execute();
$receipt = $rcpStmt->get_result()->fetch_assoc();
$rcpStmt->close();

if (!$receipt) {
    echo '<div class="bg-red-600 text-white p-4 rounded-lg">Receipt not found.</div>';
    include "../../includes/footer.php";
    echo '</body></html>';
    exit;
}

// -----------------------------
// Fetch items with product names
// -----------------------------
$itemsStmt = $conn->prepare("
    SELECT ri.quantity, p.name AS product_name, p.sku
    FROM receipt_items ri
    JOIN products p ON p.id = ri.product_id
    WHERE ri.receipt_id = ?
");
$itemsStmt->bind_param("i", $id);
$itemsStmt->execute();
$items = $itemsStmt->get_result();
?>

        <div class="flex items-start justify-between mb-6">
          <div>
            <h1 class="text-2xl font-bold text-white mb-1">Receipt <?php echo htmlspecialchars($receipt['receipt_no']); ?></h1>
            <p class="text-sm text-[var(--light)]">Created: <?php echo htmlspecialchars($receipt['created_at'] ?? ''); ?></p>
          </div>

          <div class="text-right">
            <div class="text-sm text-[var(--light)] mb-2">Status</div>
            <div class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        <?php echo ($receipt['status'] === 'Draft') ? 'bg-yellow-500 text-black' : 'bg-green-600 text-white'; ?>">
              <?php echo htmlspecialchars($receipt['status']); ?>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-[var(--light)]">
          <div>
            <div class="text-xs text-[var(--light)]">Supplier</div>
            <div class="font-medium text-white"><?php echo htmlspecialchars($receipt['supplier']); ?></div>
          </div>
          <div>
            <div class="text-xs text-[var(--light)]">Warehouse</div>
            <div class="font-medium text-white"><?php echo htmlspecialchars($receipt['warehouse_name'] ?? $receipt['warehouse_id']); ?></div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full table-auto border-collapse">
            <thead>
              <tr class="bg-[var(--purple)] text-white">
                <th class="p-3 text-left">Product</th>
                <th class="p-3 text-left">SKU</th>
                <th class="p-3 text-left">Quantity</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $items->fetch_assoc()) { ?>
                <tr class="border-b border-[#2a2b33]">
                  <td class="p-3 text-[var(--light)]"><?php echo htmlspecialchars($row['product_name']); ?></td>
                  <td class="p-3 text-[var(--light)]"><?php echo htmlspecialchars($row['sku'] ?? ''); ?></td>
                  <td class="p-3 text-[var(--light)]"><?php echo $row['quantity']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div class="flex items-center justify-between mt-6">
          <div>
            <a href="/StockMaster_OdooXSPIT/pages/receipts/list.php"
               class="inline-block px-4 py-2 rounded-lg border border-[var(--purple)] text-[var(--light)] hover:bg-[#2a2b33]">
              ← Back to Receipts
            </a>
          </div>

<?php if ($receipt['status'] === 'Draft') { ?>
          <div>
            <form action="/StockMaster_OdooXSPIT/actions/validate_receipt_action.php" method="POST" onsubmit="return confirm('Validate this receipt and update stock?');">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <button type="submit" class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
                Validate Receipt
              </button>
            </form>
          </div>
<?php } else { ?>
          <div class="text-sm text-[var(--light)]">Validated on: <?php echo htmlspecialchars($receipt['updated_at'] ?? $receipt['created_at'] ?? ''); ?></div>
<?php } ?>

        </div>
      </div>

    </div>
  </main>

<?php include "../../includes/footer.php"; ?>
</body>
</html>
