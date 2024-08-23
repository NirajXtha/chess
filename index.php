<?php
    session_start();
    require './config/db.php';
    include './config/mail_handler.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login | SignUp</title>
	<link rel="stylesheet" type="text/css" href="css/customStyle.css">
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <style>
        /* body {
        font: normal 14px/100% "Andale Mono", AndaleMono, monospace;
        width: 300px;
        margin: 0 auto;
        display:flex;
        align-items:center;
        height:100vh;
        } */
        .Click-here{
            display: none;
        }
        .custom-model-main {
        text-align: center;
        overflow: hidden;
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0; /* z-index: 1050; */
        -webkit-overflow-scrolling: touch;
        outline: 0;
        opacity: 0;
        -webkit-transition: opacity 0.15s linear, z-index 0.15;
        -o-transition: opacity 0.15s linear, z-index 0.15;
        transition: opacity 0.15s linear, z-index 0.15;
        z-index: -1;
        overflow-x: hidden;
        overflow-y: auto;
        }

        .model-open {
        z-index: 99999;
        opacity: 1;
        overflow: hidden;
        }
        .custom-model-inner {
        -webkit-transform: translate(0, -25%);
        -ms-transform: translate(0, -25%);
        transform: translate(0, -25%);
        -webkit-transition: -webkit-transform 0.3s ease-out;
        -o-transition: -o-transform 0.3s ease-out;
        transition: -webkit-transform 0.3s ease-out;
        -o-transition: transform 0.3s ease-out;
        transition: transform 0.3s ease-out;
        transition: transform 0.3s ease-out, -webkit-transform 0.3s ease-out;
        display: inline-block;
        vertical-align: middle;
        width: 600px;
        margin: 30px auto;
        max-width: 97%;
        }
        .custom-model-wrap {
        display: block;
        width: 100%;
        position: relative;
        background-color: #fff;
        border: 1px solid #999;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 6px;
        -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
        box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
        background-clip: padding-box;
        outline: 0;
        text-align: left;
        padding: 20px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        max-height: calc(100vh - 70px);
            overflow-y: auto;
        }
        .model-open .custom-model-inner {
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        transform: translate(0, 0);
        position: relative;
        z-index: 999;
        }
        .model-open .bg-overlay {
        background: rgba(0, 0, 0, 0.6);
        z-index: 99;
        }
        .bg-overlay {
        background: rgba(0, 0, 0, 0);
        height: 100vh;
        width: 100%;
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-transition: background 0.15s linear;
        -o-transition: background 0.15s linear;
        transition: background 0.15s linear;
        }
        .close-btn {
        position: absolute;
        right: 0;
        top: -30px;
        cursor: pointer;
        z-index: 99;
        font-size: 30px;
        color: #fff;
        }

        @media screen and (min-width:800px){
            .custom-model-main:before {
            content: "";
            display: inline-block;
            height: auto;
            vertical-align: middle;
            margin-right: -0px;
            height: 100%;
            }
        }
        @media screen and (max-width:799px){
        .custom-model-inner{margin-top: 45px;}
        }

    </style>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form method="POST" action="index.php">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="txt" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required>
					<input type="password" name="pswd" placeholder="Password" required="">
					<input type="submit" value="Sign up" name="signup">
				</form>
			</div>

			<div class="login">
				<form method="POST" action="index.php">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="name" placeholder="Username / Email" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<input type="submit" value="Login" name="login">
				</form>
			</div>
	</div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/jquery.js"></script>
<?php
if(isset($_POST['signup']))
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
        $username = trim(stripslashes($_POST['txt']));
        $email = trim(stripslashes($_POST['email']));
        $password = trim(stripslashes($_POST['pswd']));

        $checkUser = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $checkUser);
        if (mysqli_num_rows($result) > 0) {
            $errors[] = "Username already exists.";
            echo '
                <script>
                    $(document).ready(function(){
                        Swal.fire({
                            icon: "error",
                            title: "Username already exists!",
                        });
                    });
                </script>
            ';
        }
        // Validate username
        if (empty($username)) {
            $errors[] = "Username is required.";
            echo '
                <script>
                    $(document).ready(function(){
                        Swal.fire({
                            icon: "error",
                            title: "User name is required!",
                        });
                    });
                </script>
            ';
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                $errors[] = "Username must contain only letters and numbers.";
                echo '
                    <script>
                    $(document).ready(function(){
                        Swal.fire({
                            icon: "error",
                            text: "Only letters and numbers allowed in username!",
                        });
                    });
                </script>
                ';
            }
        }
    
        // Validate email
        if (empty($email)) {
            $errors[] = "Email is required.";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
        }
    
        // Validate password
        if (empty($password)) {
            $errors[] = "Password is required.";
        } else {
            if (strlen($password) < 6) {
                $errors[] = "Password must be at least 6 characters.";
                echo '
                    <script>
                    $(document).ready(function(){
                        Swal.fire({
                            icon: "error",
                            text: "Password must be at least 6 characters!",
                        });
                    });
                </script>
                ';
            }
        }
    
        // If there are no errors, proceed with form submission (e.g., save to database)
        if (empty($errors)) {
            // Your code to handle successful form submission goes here
            $token = bin2hex(random_bytes(16));

            $sql = "INSERT INTO users (username, email, password, token, pic) VALUES ('$username', '$email', '$password', '$token', './img/user.png')";
            if (mysqli_query($conn, $sql)) {
                // For OTP verification | using PHP Mailer
                $otp = generateOtp();
                $q = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND email = '$email'");
                $user_id = 0;
                while($row = mysqli_fetch_assoc($q)) { $user_id = $row['id']; }
                $result = sendMail($username, $email, $otp);
                if($result) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['token'] = $token;
                    
                    $current_date = date('Y-m-d H:i:s', time());
                    $expiry_date = date('Y-m-d H:i:s', strtotime('+5 minutes', time()));
                    $sql = "INSERT INTO otp (user_id, otp, created_at, expire_at) VALUES ('$user_id', '$otp', '$current_date', '$expiry_date')";
                    mysqli_query($conn, $sql);
                    
                    echo '<script>window.location.href = "otp.php?token='.$token.'&email='.$email.'&username='.$username.'";</script>';
                    exit();
                }
                if($result == false) {
                    $sql = "DELETE FROM users WHERE email = '$email' AND username = '$username'";
                    $que = mysqli_query($conn, $sql);
                }
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                echo '
                    <script>
                        $(document).ready(function(){
                            Swal.fire({
                                icon: "error",
                                text: "'. mysqli_error($conn) .'",
                            });
                        });
                    </script>
                ';
            }
        }
    }
} // SignUp end

// Login Start
if(isset($_POST['login'])) {
    $username = trim(stripslashes($_POST['name']));
    $password = trim(stripslashes($_POST['pswd']));

    $sql = mysqli_query($conn, "SELECT * FROM users WHERE password = '$password' && username = '$username' || email = '$username'");
    if(mysqli_num_rows($sql) != 0) {
        while($row = mysqli_fetch_assoc($sql)) {
            $token = tokenGenerator();
            $user_id = $row['id'];
            $username = $row['username'];
            $sql = mysqli_query($conn, "UPDATE users SET token = '$token', `online` = '1' WHERE id = '$user_id' && username = '$username'");
            if($sql) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['token'] = $token;
                echo '
                <script>
                    $(document).ready(function(){
                        Swal.fire({
                            icon: "success",
                            text: "Logged in successfully!",
                        });
                    });
                </script>
            ';
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
                            text: "Invalid username or password!",
                        });
                    });
                </script>
            ';
    }
}

//OTP failed
if(isset($_GET['otp'])) {
    if($_GET['otp'] == 'timeout') {
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
    }
}

function generateOtp() {
    $generator = "1357902468";
    $result = ""; 
    for ($i = 1; $i <= 6; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    }
    return $result; 
}
?>
</body>
</html>
