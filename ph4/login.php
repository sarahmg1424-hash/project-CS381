<?php
session_start();
require_once 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

   $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email"
);
$stmt->execute([
    ':email' => $email
]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["user_role"] = $user["role"];

        header("Location: home.php");
        exit();
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<header>
    <h1 class="headerhome">Student Feedback System</h1>
</header>

<main>
    <section class="container">
        <h2>Login</h2>

        <form method="POST" id="loginForm">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p class="error" id="errorMsg"><?php echo htmlspecialchars($message); ?></p>
    </section>
</main>

<footer>
    <p>Student Feedback System @2026</p>
</footer>

<script>
let form = document.getElementById("loginForm");

form.addEventListener("submit", function (e) {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let error = document.getElementById("errorMsg");

    if (email === "" || password === "") {
        e.preventDefault();
        error.textContent = "Please fill all fields.";
    }
});
</script>

</body>
</html>