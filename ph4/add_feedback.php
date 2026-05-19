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

$message = "";
if (!isset($_SESSION["token"])) {

    $_SESSION["token"] =
        bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
    !isset($_POST["token"]) ||
    $_POST["token"] !== $_SESSION["token"]
) {

    die("Invalid CSRF Token");
}
    $subject = trim($_POST["subject"]);
    $feedback_message = trim($_POST["message"]);
    $user_id = $_SESSION["user_id"];

    if ($subject == "" || $feedback_message == "") {
        $message = "Please fill all fields.";
    } else {
       $stmt = $pdo->prepare(
     "INSERT INTO feedback (user_id, subject, message, status)
     VALUES (:user_id, :subject, :message, 'New')"
);

$stmt->execute([
    ':user_id' => $user_id,
    ':subject' => $subject,
    ':message' => $feedback_message
]);

        $message = "Feedback submitted successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Feedback</title>
    <link rel="stylesheet" href="style.css">
</head>
<body  class="home-page">

<header>
    <h1 class="headerhome">Student Feedback System</h1>
</header>

<main>
    <section class="container">
        <h2>Add Feedback</h2>

        <form method="POST">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            <input type="text" name="subject" placeholder="Subject" required minlength="3" maxlength="10">
            <textarea name="message" placeholder="Write your feedback" required minlength="5" maxlength="200"></textarea>
            <button type="submit">Submit</button>
        </form>

        <p class="success"><?php echo htmlspecialchars($message); ?></p>
        <p><a href="home.php">Back to Home</a></p>
    </section>
</main>

<footer>
    <p>Student Feedback System @2026</p>
</footer>

</body>
</html>
