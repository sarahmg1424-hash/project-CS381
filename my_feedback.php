<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["user_role"] != "student") {
    die("Access denied");
}

$user_id = $_SESSION["user_id"];
$stmt = $pdo->prepare(
    "SELECT subject, message, status, created_at
     FROM feedback
     WHERE user_id = :user_id
     ORDER BY created_at DESC"
);

$stmt->execute([
    ':user_id' => $user_id
]);
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Feedback</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="myfeedback-page">

<header>
    <h1 class="headerhome">Student Feedback System</h1>
</header>

<main>
    <section class="container">
        <h2>My Feedback</h2>

        <div class="ta">
        <table>
            <tr>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Date</th>
            </tr>

            <?php if (count($rows) > 0) { ?>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["subject"]); ?></td>
                        <td><?php echo htmlspecialchars($row["message"]); ?></td>
                        <td><?php echo htmlspecialchars($row["status"]); ?></td>
                        <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No feedback found</td>
                </tr>
            <?php } ?>

        </table>
        </div>

        <p><a href="home.php">Back to Home</a></p>
    </section>
</main>

<footer>
    <p>Student Feedback System @2026</p>
</footer>

</body>
</html>