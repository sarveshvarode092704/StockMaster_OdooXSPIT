<?php
session_start();
include("../config/db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare query
    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // If user found
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {

            // Store session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["email"] = $user["email"];

            // Redirect by role (optional)
            if ($user["role"] === "admin") {
                header("Location: admin_dashboard.php");
            } elseif ($user["role"] === "manager") {
                header("Location: manager_dashboard.php");
            } else {
                header("Location: staff_dashboard.php");
            }
            exit;

        } else {
            $message = "<p class='text-red-400 text-center mb-3'>Incorrect password!</p>";
        }

    } else {
        $message = "<p class='text-red-400 text-center mb-3'>Email not found!</p>";
    }

    $stmt->close();
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
  :root {
    --dark1: #1e202c;
    --purple: #60519b;
    --dark2: #31323e;
    --light: #bfc0d1;
  }
</style>
</head>

<body class="min-h-screen flex items-center justify-center bg-[var(--dark1)]">

<div class="bg-[var(--dark2)] w-96 p-8 rounded-2xl shadow-xl border border-[var(--purple)]">

  <h2 class="text-center text-2xl font-semibold mb-4 text-[var(--purple)]">Login</h2>

  <!-- PHP MESSAGE -->
  <?php if (!empty($message)) echo $message; ?>

  <form method="POST" action="">

    <label class="text-sm text-[var(--light)]">Email</label>
    <input name="email" required type="email"
           class="w-full p-3 rounded-lg bg-[var(--dark1)] text-white border border-[var(--light)]
                  focus:border-[var(--purple)] focus:ring-[var(--purple)] focus:ring-2 mb-4">

    <label class="text-sm text-[var(--light)]">Password</label>
    <input name="password" required type="password"
           class="w-full p-3 rounded-lg bg-[var(--dark1)] text-white border border-[var(--light)]
                  focus:border-[var(--purple)] focus:ring-[var(--purple)] focus:ring-2 mb-4">

    <button class="w-full py-3 rounded-lg bg-[var(--purple)] hover:bg-purple-700 transition text-white font-semibold">
      Login
    </button>

    <p class="text-center text-[var(--light)] mt-4">
      Don't have an account?
      <a href="signup.php" class="text-[var(--purple)] hover:underline">Sign Up</a>
    </p>

  </form>
</div>

</body>
</html>

