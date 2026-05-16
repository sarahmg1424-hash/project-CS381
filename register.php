<?php
session_start();
require_once 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];
    $role = "student";

    if ($name == "" || $email == "" || $password == "" || $confirm == "") {
        $message = "Please fill all fields.";
    }
    elseif ($password != $confirm) {
    $message = "Passwords do not match.";
    }
   else {
       $stmt = $pdo->prepare( "SELECT id FROM users WHERE email = :email"
);
$stmt->execute([
    ':email' => $email
]);

        if ($stmt->fetch()) {
            $message = "Email already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(
    "INSERT INTO users (name, email, password, role)
     VALUES (:name, :email, :password, :role)"
);
$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':password' => $hashedPassword,
    ':role' => $role
]);
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<header>
    <h1 class="headerhome">Student Feedback System</h1>
</header>

<main>
    <section class="container">
        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required minlength="8">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required minlength="8">
            <button type="submit">Register</button>
        </form>

        <p class="error"><?php echo htmlspecialchars($message); ?></p>
        <p><a href="login.php">Already have an account? Login</a></p>
    </section>
</main>

<footer>
    <p>Student Feedback System @2026</p>
</footer>

</body>
</html>