<?php
	require_once "config.php";
	require_once "session.php";

	$error = '';
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);

		if (empty($email)){
			$error .= '<p class="error">Wpisz email</p>';
		}

		if (empty($password)){
			$error .= '<p class="error">Wpisz hasło</p>';
		}

		if (empty($error)){
			if ($query = $db->prepare("SELECT * FROM users WHERE email = ?")){
				$query->bind_param('s', $email);
				$query->execute();
				$row = $query->fetch();
				if ($row){
					if (password_verify($password, $row['password'])){
						$_SESSION['userid'] = $row['id'];
						$_SESSION['user'] = $row;

						header("location: welcome.php");
						exit;
					}else{
						$error .= '<p class="error"> Hasło jest nieprawidłowe </p>';
					}
				}else{
					$error .= '<p class="error">Nie istnieje uzytkownik z tym adresem email</p>';
				}
			}
			$query->close();
		}
		mysqli_close($db);
	}
?>
<!doctype html> 
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<title>Logowanie</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Logowanie</h2>
					<p>Wpisz email i hasło</p>
					<form action="" method="post">
						<div class="form-group">
							<label>E-mail</label>
							<input type="text" name="email" class="form-control" required/>
						</div>
						<div class="form-group">
							<label>Hasło</label>
							<input type="password" name="password" class="form-control" required>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-primary" value="Zaloguj">
						</div>
						<p>Nie masz konta? <a href="register.php">Zarajestruj się. </a></p>
						<p>Nie pamiętasz hasła? <a href="reset-password.php">Zmień hasło. </a></p>																		
					</form>
				</div>
			</div>
		</div>
	</body>
</html>