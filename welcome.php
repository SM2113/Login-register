<?php 
session_start();
	
	if (!isset($_SESSION['userid']) || $_SESSION['userid'] !== true){
		header("location: login.php");
		exit;
	}
?>
<!doctype html> 
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<title>Witaj!</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Witaj <?php echo $_SESSION['name']; ?></h2>
				</div>
				<p><a href="logout.php" class="btn btn-secondary btn-lg active" role="button" ariapressed="true">Wyloguj</a></p>
			</div>
		</div>
	</body>
</html>