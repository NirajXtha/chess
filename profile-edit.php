<?php
	session_start();
	include('config/db.php');

	if(empty($_SESSION['token']) || empty($_SESSION['email']) || empty($_SESSION['username']) || empty($_SESSION['user_id'])) {
		header('Location: index.php');
		exit();
	}
	$username = $_SESSION['username'];
	$user_name = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];
	$email = $_SESSION['email'];
	$token = $_SESSION['token'];

	$profile_pic = "./img/user.png";

	$query = mysqli_query($conn,"SELECT * FROM users WHERE id = '$user_id'");
	if(mysqli_num_rows($query) == 0) {
		header('Location: index.php');
		exit();
	}

	if($row = mysqli_fetch_assoc($query)){
		if($row['pic'] != NULL){
			$profile_pic = $row['pic'];
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard.css">

</head>
<body>
<div class="app">
	<header class="app-header">
		<div class="app-header-logo">
			<div class="logo">
				<span class="logo-icon">
					<img src="./img/dashboard.png" />
				</span>
				<h1 class="logo-title">
					<span>MyChess</span>
					<span>Dashboard</span>
				</h1>
			</div>
		</div>
		<div class="app-header-navigation">
			<div class="tabs">
				<a href="./dashboard.php">
					Overview
				</a>
				<a href="./play.php">
					Play
				</a>
				<a href="./profile.php" class="active">
					Account
				</a>
				<a href="./friends.php">
					Friends
				</a>
				<a href="./games.php">
					Match  History
				</a>
			</div>
		</div>
		<div class="app-header-actions">
			<button class="user-profile">
				<span><?=$username?></span>
				<span>
					<img src="<?=$profile_pic?>" />
				</span>
			</button>
		</div>
		<div class="app-header-mobile">
			<button class="icon-button large">
				<i class="ph-list"></i>
			</button>
		</div>

	</header>
	<div class="app-body">
		<div class="app-body-navigation">
			<nav class="navigation">
				<a href="./dashboard.php">
					<i class="ph-crown-simple"></i>
					<span>Dashboard</span>
				</a>
				<a href="./profile.php">
					<i class="ph-user"></i>
					<span>Profile</span>
				</a>
				<a href="./games.php">
					<i class="ph-game-controller"></i>
					<span>Games</span>
				</a>
				<a href="./logout.php">
					<i class="ph-sign-out"></i>
					<span>Log Out</span>
				</a>
			</nav>
			<footer class="footer">
				<h1>MyChess<small>©</small></h1>
				<div>
					MyChess ©<br />
					All Rights Reserved 2024
					
				</div>
			</footer>
		</div>
		<div class="dashboard">
			<?php include 'config/profile-edit.php'; ?>
		</div> <!-- Dashboard | Overview -->
	</div>
</div>
<!-- partial -->
  <script src='https://unpkg.com/phosphor-icons'></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="js/jquery.js"></script>
  <script>
	document.querySelector('.user-profile').addEventListener('click', () => {
	  window.location.href = 'profile.php';
	});
  </script>
</body>
</html>