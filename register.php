
<!doctype html> 
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<title>Rejestracja</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Rejestracja</h2>
					<p>Uzupełnij aby stworzyć konto.</p>
					<form action="" method="post">
						<div class="form-group">
							<label>Imię i Nazwisko</label>
							<input type="text" name="name" class="form-control" required/>
						</div>
						<div class="form-group">
							<label>E-mail</label>
							<input type="text" name="email" class="form-control" required/>
						</div>
						<div class="form-group">
							<label>Hasło</label>
							<input type="password" name="password" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Potwierdź hasło</label>
							<input type="password" name="conf_password" class="form-control" required>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-primary" value="Utwórz">
						</div>
						<p>Masz już konto? <a href="login.php">Zaloguj się. </a></p>																		
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?php 
	require_once "config.php";
	require_once "session.php";

	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])){
		$fullname = trim($_POST['name']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$confirm_password = trim($_POST['conf_password']);
		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		if($query = $db->prepare("SELECT * FROM users WHERE email = ?")){
			$error = '';

			$query->bind_param('s', $email); 
			$query->execute();

			$query->store_result();
				if ($query->num_rows > 0) {
					$error .= '<p class="error">Konto z tym emailem już istneije</p>';
				}else{
					if (strlen($password) < 8){
						$error .= '<p class="error">Hasło musi mieć co najmniej 8 znaków</p>';
					}
				
					if (empty($conf_password)){
						$error .= '<p class="error">Potwierdź hasło wpisując je jeszcze raz</p>';
					}else{
						if (empty($error) && ($password != $conf_password)){
							$error .= '<p class="error">Hasło nie jest zgodne</p>';
						}
					}

					if (empty($error)){
						$insertQuery = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?);");

						$insertQuery->bind_param("sss", $fullname, $email, $password_hash);
						$result = $insertQuery->execute();
						if ($result){
							$error .= '<p class="success">Twoje konto zostało utworzone</p>';
						}else{
							$error .= '<p class="error">Coś poszło nie tak</p>';
						}$insertQuery->close();
					}
				
		}
		$query->close();
		mysqli_close($db);
	}
}
?>