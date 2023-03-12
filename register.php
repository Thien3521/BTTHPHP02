<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<h1>Đăng kí</h1>
	<form action="process_register.php" method="post">
        <label for="username">Username</label>
		<input type="username" id="username" name="username" required>
		<br>
		<label for="email">Email</label>
		<input type="email" id="email" name="email" required>
		<br>
		<label for="password">Password</label>
		<input type="password" id="password" name="pass1" required>
		<br>
		<label for="confirm_password">Confirm Password</label>
		<input type="password" id="confirm_password" name="pass2" required>
		<br>
		<input name="register" type="submit" value="Register">
	</form>
</body>
</html>
