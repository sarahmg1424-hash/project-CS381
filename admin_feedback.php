<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["user_role"] != "admin") {
    die("Access denied");
}

if (isset($_GET["id"]) && isset($_GET["status"])) {
    $id = $_GET["id"];
    $status = $_GET["status"];

    if ($status == "Reviewed" || $status == "Resolved") {
        $stmt = $pdo->prepare(
    "UPDATE feedback SET status = :status WHERE id = :id"
);
$stmt->execute([
    ':status' => $status,
    ':id' => $id
]);
    }
if ($status == "Delete") {
    $stmt = $pdo->prepare(
        "DELETE FROM feedback WHERE id = :id"
    );

    $stmt->execute([
        ':id' => $id
    ]);
}
    header("Location: admin_feedback.php");
    exit();
}
$stmt = $pdo->query("
    SELECT feedback.*, users.email 
    FROM feedback 
    JOIN users ON feedback.user_id = users.id 
    ORDER BY feedback.created_at DESC
");

$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-page">

<header>
    <h1 class="headerhome">Student Feedback System</h1>
</header>

<main>
    <section class="container">
        <h2>Manage Feedback</h2>

        <div class="ta">
            <table>
                <tr>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>

                <?php if (count($rows) > 0) { ?>
                    <?php foreach ($rows as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["subject"]); ?></td>
                            <td><?php echo htmlspecialchars($row["message"]); ?></td>
                            <td><?php echo htmlspecialchars($row["status"]); ?></td>
                            <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
                            <td>
                                <a class="link-btn" href="admin_feedback.php?id=<?php echo $row['id']; ?>&status=Reviewed">Reviewed</a>
                                <a class="link-btn" href="admin_feedback.php?id=<?php echo $row['id']; ?>&status=Resolved">Resolved</a>
                                <a class="link-btn" href="admin_feedback.php?id=<?php echo $row['id']; ?>&status=Delete">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6">No feedback found</td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <p><a href="home.php">Back to Home</a></p>
        <p><a href="logout.php">Logout</a></p>
    </section>
</main>

<footer>
    <p>Student Feedback System @2026</p>
</footer>

</body>
</html>