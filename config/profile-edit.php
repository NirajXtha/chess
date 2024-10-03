<?php
    $sql = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
    if(mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];
        $token = $row['token'];
        $is_verified = $row['is_verified'];
        $is_online = $row['online'];
        $pic = $row['pic'];
        $created_at = $row['created_at'];
    }
    // Check if the connection is secure
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Get the host name
$host = $_SERVER['HTTP_HOST'];

// Get the request URI (the path and query string)
$requestUri = $_SERVER['REQUEST_URI'];

// Combine them to get the full URL
$url = $protocol . $host . $requestUri;
?>
<style>
.input {
  max-width: 190px;
  height: 44px;
  background-color: #05060f;
  border-radius: .5rem;
  padding: 0 1rem;
  border: 2px solid transparent;
  font-size: 1rem;
  transition: border-color .3s cubic-bezier(.25,.01,.25,1) 0s, color .3s cubic-bezier(.25,.01,.25,1) 0s,background .2s cubic-bezier(.25,.01,.25,1) 0s;
}

.label {
  display: block;
  margin-bottom: .3rem;
  font-size: .9rem;
  font-weight: bold;
  color: antiquewhite;
  transition: color .3s cubic-bezier(.25,.01,.25,1) 0s;
}

.input:hover, .input:focus, .input-group:hover .input {
  outline: none;
  border-color: #05060f;
}

.input-group:hover .label, .input:focus {
  color: antiquewhite;
}

.custum-file-upload {
  height: 200px;
  width: 300px;
  display: flex;
  flex-direction: column;
  align-items: space-between;
  gap: 20px;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  border: 2px dashed #cacaca;
  background-color: rgba(255, 255, 255, 1);
  padding: 1.5rem;
  border-radius: 10px;
  box-shadow: 0px 48px 35px -48px rgba(0,0,0,0.1);
}

.custum-file-upload .icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

.custum-file-upload .icon svg {
  height: 80px;
  fill: rgba(75, 85, 99, 1);
}

.custum-file-upload .text {
  display: flex;
  align-items: center;
  justify-content: center;
}

.custum-file-upload .text span {
  font-weight: 400;
  color: rgba(75, 85, 99, 1);
}

.custum-file-upload input {
  display: none;
}

/* From Uiverse.io by CristianMontoya98 */ 
.btn {
 width: 6.5em;
 height: 2.3em;
 margin: 0.5em;
 background: black;
 color: white;
 border: none;
 border-radius: 0.625em;
 font-size: 20px;
 font-weight: bold;
 cursor: pointer;
 position: relative;
 z-index: 1;
 overflow: hidden;
}

button:hover {
 color: black;
}

button:after {
 content: "";
 background: white;
 position: absolute;
 z-index: -1;
 left: -20%;
 right: -20%;
 top: 0;
 bottom: 0;
 transform: skewX(-45deg) scale(0, 1);
 transition: all 0.5s;
}

button:hover:after {
 transform: skewX(-45deg) scale(1, 1);
 -webkit-transition: all 0.5s;
 transition: all 0.5s;
}
</style>
<div class="app-body-main-content">
    <section class="profile-section">
        <h2>Edit Your Account</h2>
        <div class="account">
            <div class="account-details">
                <div class="account-details-header">
                    
                    <div class="account-details-logo">
                        <img src="<?=$pic?>" />
                    </div>
                    <div class="account-details-info">
                        <form id="form" action="<?=$url?>" method="post" enctype="multipart/form-data">
                            <div class="input-group">
                                <label class="label">Username</label>
                                <input autocomplete="off" name="username" id="Email" class="input" type="text" value="<?=$username?>">
                            <div><br>
                            <div class="input-group">
                                <label class="label">Email address</label>
                                <input autocomplete="off" name="email" id="Email" class="input" type="email" value="<?=$email?>">
                            <div><br>
                            <input type="password" name="old_password" value="<?=$password?>" hidden>
                            <div class="input-group">
                                <label class="label">Password</label>
                                <input autocomplete="off" name="new_password" id="Email" class="input" type="password">
                            <div><br>
                            <label class="custum-file-upload" for="file">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                                </div>
                                <div class="text">
                                    <span>Click to upload image</span>
                                </div>
                                <input type="file" id="file" name="pic">
                            </label>
                            <button class="btn" onclick="document.getElementById('form').submit()"> Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = htmlspecialchars(trim($_POST['username']));
        $email = htmlspecialchars(trim($_POST['email']));
        $oldPassword = $_POST['old_password'];
        $newPassword = htmlspecialchars(trim($_POST['new_password']));
        if($newPassword == NULL){
            $password = $oldPassword;
        }else{
            $password = $newPassword;
        }
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
        if(empty(isset($_FILES))){
            if($user_name == $username){
                $sql = mysqli_query($conn, "UPDATE users SET username = '$username', email = '$email', password = '$password' WHERE id = '$user_id'");
                if($sql){
                    echo '<script>window.location.replace("profile.php")</script>';
                }else{
                    echo '
                    <script>
                        $(document).ready(function(){
                            Swal.fire({
                                icon: "error",
                                title: "Something went Wrong!",
                                text: "Please Try again!",
                            });
                        });
                    </script>
                ';
                exit();
                }
            }else{
                $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
                if(mysqli_num_rows($check) >= 1){
                    echo '
                        <script>
                            $(document).ready(function(){
                                Swal.fire({
                                    icon: "error",
                                    title: "Username Already Exists!",
                                    text: "Please Try again!",
                                });
                            });
                        </script>
                        ';
                        exit();
                }else{
                    $sql = mysqli_query($conn, "UPDATE users SET username = '$username', email = '$email', password = '$password' WHERE id = '$user_id'");
                    if($sql){
                        echo '<script>window.location.replace("profile.php")</script>';
                    }else{
                        echo '
                            <script>
                                $(document).ready(function(){
                                    Swal.fire({
                                        icon: "error",
                                        title: "Something went Wrong!",
                                        text: "Please Try again!",
                                    });
                                });
                            </script>
                            ';
                        exit();
                    }
                }
            }
        }
        elseif (isset($_FILES['pic']) && $_FILES['pic']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['pic']['tmp_name'];
            $fileName = $_FILES['pic']['name'];
            $fileSize = $_FILES['pic']['size'];
            $fileType = $_FILES['pic']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            // Define allowed file extensions
            $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Define upload directory and file name
                $uploadFileDir = './img/';
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;
    
                // Move the uploaded file to the upload directory
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    $pic = './img/' . $newFileName; // Store the new file name in the database
                } else {
                    echo '
                        <script>
                            $(document).ready(function(){
                                Swal.fire({
                                    icon: "error",
                                    title: "Error moving the file!",
                                });
                            });
                        </script>
                    ';
                }
            } else {
                echo '
                    <script>
                        $(document).ready(function(){
                            Swal.fire({
                                icon: "error",
                                title: "Upload Failed!",
                                text: "Allowed file types: jpg, jpeg, png, gif, webp",
                            });
                        });
                    </script>
                ';
            }
        }
        else{
            $sql = mysqli_query($conn, "UPDATE users SET username = '$username', email = '$email', password = '$password', pic = '$pic' WHERE id = '$user_id'");
            if($sql){
                echo '<script>window.location.replace("profile.php")</script>';
            }else{
                echo '
                    <script>
                        $(document).ready(function(){
                            Swal.fire({
                                icon: "error",
                                title: "Something went Wrong!",
                                text: "Please Try again!",
                            });
                        });
                    </script>
                ';
            }
        }

        
    }
?>