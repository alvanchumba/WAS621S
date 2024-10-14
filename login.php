<?php
include 'db_connect.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	 $username = $_POST['username'];
     $password = $_POST['password'];

     $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    	 $user = $result->fetch_assoc();

	 if (($password === $user['password'])){
	 	$_SESSION['username'] = $user['username'];
	 	header("Location: dashboard.php");
	 	exit();
	 }else {
	 	echo "Invalid password!";
	 }

	}else {
	 	echo "User not found!";
	 }

	 $stmt->close();
	 $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>User Login</h2>
<form action="https://www.alvanlocal.com/login.php" method="POST">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>

</body>
</html>