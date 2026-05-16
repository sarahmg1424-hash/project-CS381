<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="home-page">

<header>
    <h1 class="headerhome">Student Feedback System</h1>
</header>

<main>
    <section class="container">
        <h2 id="p">Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></h2>

        <nav class="menu">
            <?php if ($_SESSION["user_role"] == "student") { ?>
                <a href="add_feedback.php">Add Feedback</a>
                <a href="my_feedback.php">My Feedback</a>
            <?php } ?>

            <?php if ($_SESSION["user_role"] == "admin") { ?>
                <a href="admin_feedback.php">Manage Feedback</a>
            <?php } ?>

            <a href="logout.php">Logout</a>
        </nav>
    </section>
</main>

<footer>
    <p>Student Feedback System @2026</p>
</footer>

</body>
</html>