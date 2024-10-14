<?php
session_start();

if (!isset($_SESSION['username'])) {
	header("Location: register.php");
	exit();
}

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
	$comment = $_POST['comment'];
	$username=$_SESSION['username'];

	$sql="INSERT INTO comments (username, comment) VALUES(?,?)";
	$stmt=$conn->prepare($sql);
	$stmt->bind_param("ss", $username, $comment);
	if ($stmt->execute()) {
		echo "Comment added succesfully!";
	} else{
		echo "Error: " . $stmt->error;
	}
	$stmt->close();
}

$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result=$conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>

<h2>Welcome to your Dashboard, <?php echo $_SESSION['username']; ?>!</h2>
<p>You have successfully logged in.</p>

<h3>Leave a comment</h3>
<form action="dashboard.php" method="POST">
	<textarea name="comment" rows="4" cols="50" required></textarea><br><br>
	<input type="submit" value="Submit Comment">
</form>

<h3>Comments</h3>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" .($row['username']) . ":</strong> " . ($row['comment']) . " <br><small>" . $row['created_at'] . "</small></p>";
    }
} else {
    echo "<p>No comments yet.</p>";
}
?>
</body>
</html>