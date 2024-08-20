<?php
	session_start();
	require './config/db.php';

	if(empty($_GET)){
		// header('Location: index.php');
		// exit();
		echo "Error: Empty get";
	}

	if(empty($_SESSION['token']) || empty($_SESSION['email']) || empty($_SESSION['username']) || empty($_SESSION['user_id'])) {
		header('Location: index.php');
		exit();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>OTP Verification</title>
	<link rel="stylesheet" type="text/css" href="css/CustomStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    
	<div class="main" style="height: 350px;">  	
		<input type="checkbox" id="chk" aria-hidden="true">
			<div class="otp">
				<form method="POST" action="otp.php?verify=true">
					<label for="chk" aria-hidden="true">OTP</label>
					<input type="text" name="otp" placeholder="OTP Code" required="" autofocus>
					<input type="submit" value="Submit" name="submit">
				</form>
			</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/jquery.js"></script>
    <?php
		$token = $_SESSION['token'];
		$email = $_SESSION['email'];
		$username = $_SESSION['username'];
		$user_id = $_SESSION['user_id'];
		if(isset($_GET['token']) && isset($_GET['email']) && isset($_GET['username'])) {
			$getToken = $_GET['token'];
			$getEmail = $_GET['email'];
			$getUsername = $_GET['username'];
	
			if($getToken != $token || $getEmail != $email || $getUsername != $username) {
				// header('Location: index.php');
				// exit();
				// echo "Error: Invalid get";
			}
			
		}
		$date = date('Y-m-d H:i:s', time());
				echo $date;
	
		$sql = "SELECT * FROM users WHERE token = '$token' AND email = '$email' AND username = '$username' AND id = '$user_id'";
		$result = mysqli_query($conn, $sql);
	
		if($result && mysqli_num_rows($result) == 0) {
			// header('Location: index.php');
			// exit();
			echo "Error: Invalid session";
		}
	
		if(isset($_POST['otp'])) {
			$otp = $_POST['otp'];
			$sql = mysqli_query($conn, "SELECT * FROM otp WHERE otp = '$otp' AND user_id = '$user_id'");
			if(mysqli_num_rows($sql) != 0) {
				if($row = mysqli_fetch_assoc($sql)) {
					$date = date('Y-m-d H:i:s', time());
					
					if($date > $row['expire_at']) { 
						echo '
							<script>
							$(document).ready(function(){
								Swal.fire({
									icon: "error",
									text: "OTP has expired. Please Register again.",
								});
							});
						</script>
						';
						$sql = mysqli_query($conn, "DELETE FROM otp WHERE user_id = '$user_id'");
						$sql = mysqli_query($conn, "DELETE FROM users WHERE id = '$user_id'");
		
						if($sql) {
							echo '<script>
							const delay = ms => new Promise(res => setTimeout(res, ms));
							$(await delay(3000));
							window.location.href = "index.php?otp=timeout";
							</script>';
							exit();
						}
					}else{
						$sql = mysqli_query($conn, "DELETE FROM otp WHERE user_id = '$user_id'");
						$sql = mysqli_query($conn, "UPDATE users SET is_verified = '1', `online` = '1' WHERE id = '$user_id'");
		
						if($sql) {
							echo '<script>window.location.href = "dashboard.php";</script>';
							exit();
						}
					}
				}else{
					echo '
						<script>
						$(document).ready(function(){
							Swal.fire({
								icon: "error",
								text: "SQL Error!",
							});
						});
					</script>
					';
				}
			}else{
				echo '
						<script>
						$(document).ready(function(){
							Swal.fire({
								icon: "error",
								text: "The OTP is incorrect! Please Try again!",
							});
						});
					</script>
					';
			}
		}
	?>
</body>
</html>