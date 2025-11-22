<?php
// Include DB connection file
include("../../config/db.php");

// Message variable for success or error
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Prepare insert query
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
    $message = "<p class='text-green-400 text-center mb-4'>Signup Successful!</p>";
} else {
    if ($conn->errno == 1062) {
        echo "<script>alert('Email already exists!');</script>";
    }
    $message = "<p class='text-red-400 text-center mb-4'>Email already exists!</p>";
}


    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Signup Page</title>
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

    <h2 class="text-center text-2xl font-semibold mb-4 text-[var(--purple)]">Create Account</h2>

    <!-- PHP MESSAGE -->
    <?php if(!empty($message)) echo $message; ?>

    <!-- SIGNUP FORM -->
    <form method="POST" action="">

      <label class="text-sm text-[var(--light)]">Full Name</label>
      <input name="name" type="text" required
             class="w-full p-3 rounded-lg bg-[var(--dark1)] text-white border border-[var(--light)]
                    focus:border-[var(--purple)] focus:ring-[var(--purple)] focus:ring-2 mb-4" />

      <label class="text-sm text-[var(--light)]">Email</label>
      <input name="email" type="email" required
             class="w-full p-3 rounded-lg bg-[var(--dark1)] text-white border border-[var(--light)]
                    focus:border-[var(--purple)] focus:ring-[var(--purple)] focus:ring-2 mb-4" />

      <label class="text-sm text-[var(--light)]">Password</label>
      <input name="password" type="password" required
             class="w-full p-3 rounded-lg bg-[var(--dark1)] text-white border border-[var(--light)]
                    focus:border-[var(--purple)] focus:ring-[var(--purple)] focus:ring-2 mb-4" />

      <label class="text-sm text-[var(--light)]">Role</label>
      <select name="role" required
              class="w-full p-3 rounded-lg bg-[var(--dark1)] text-white border border-[var(--light)]
                     focus:border-[var(--purple)] focus:ring-[var(--purple)] focus:ring-2 mb-6">
        <option value="admin">Admin</option>
        <option value="manager">Manager</option> 
        <option value="staff">Staff</option>
      </select>

      <button class="w-full py-3 rounded-lg bg-[var(--purple)] hover:bg-purple-700 transition text-white font-semibold">
        Sign Up
      </button>
      <p class="text-center text-[var(--light)] mt-4">
    Already have an account?
    <a href="login.php" class="text-[var(--purple)] hover:underline">Login</a>
</p>

    </form>
  </div>

</body>
</html>
