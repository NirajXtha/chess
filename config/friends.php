<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$requestUri = $_SERVER['REQUEST_URI'];
$url = $protocol . $host . $requestUri;
?>
<style>
.group {
  display: flex;
  line-height: 28px;
  align-items: center;
  position: relative;
  max-width: 190px;
}

.input {
  font-family: "Montserrat", sans-serif;
  /* width: 100%; */
  height: 45px;
  padding-left: 2.5rem;
  box-shadow: 0 0 0 1.5px #2b2c37, 0 0 25px -17px #000;
  border: 0;
  border-radius: 12px;
  background-color: #16171d;
  outline: none;
  color: #bdbecb;
  transition: all 0.25s cubic-bezier(0.19, 1, 0.22, 1);
  cursor: text;
  z-index: 0;
}

.input::placeholder {
  color: #bdbecb;
}

.input:hover {
  box-shadow: 0 0 0 2.5px #2f303d, 0px 0px 25px -15px #000;
}

.input:active {
  transform: scale(0.95);
}

.input:focus {
  box-shadow: 0 0 0 2.5px #2f303d;
}

.search-icon {
  position: absolute;
  left: 1rem;
  fill: #bdbecb;
  width: 1rem;
  height: 1rem;
  pointer-events: none;
  z-index: 1;
}

#searchBtn {
  width: auto;
  height: 60px;
  align-items: center;
  justify-content: center;
  display: flex;
}

.svg {
  width: 70px;
  height: 70px;
  opacity: 80%;
  cursor: pointer;
  padding: 13px 20px;
  transition: 0.2s;
}

.li .svg:hover {
  transition: 0.1s;
  color: rgb(235, 40, 176);
  position: relative;
  margin-top: -4px;
  opacity: 100%;
}

.li {
  display: inline-block;
}

.search_btn{
    display: none;
}

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

.accept:hover {
 background-color: green;
}

.decline:hover {
 background-color: red;
}

</style>
<div class="app-body-main-content">
    <section class="service-section">
        <h2>Add Friends</h2>
        <form action="<?=$url?>" method="post" id="add-friends">
            <div class="group">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="search-icon">
                <g>
                <path
                    d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"
                ></path>
                </g>
            </svg>
            <input id="query" class="input" type="search" placeholder="Search..." name="username" />
            <input class="search_btn" name="search" id="choose2" type="submit" />
            <div id="searchBtn">
                <label for="choose2">
                    <li class="li">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        height="24"
                        width="24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                        class="svg w-6 h-6 text-gray-800 dark:text-white"
                    >
                        <path
                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke="currentColor"
                        ></path>
                    </svg>
                    </li>
                </label>
            </div>
            </div>
        </form>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        if(empty($_POST['username'])) {
            echo 'Please input username!';
        }else{
            $search = $_POST['username'];
            $query = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$search'");

            if(mysqli_num_rows($query) == 0) {
                echo 'User not Found!';

            }else{
                $row = mysqli_fetch_assoc($query);
                $friend_id = $row['id'];
                $check = mysqli_query($conn, "SELECT * FROM `requests` WHERE (user_id = '$user_id' AND friend_id = '$friend_id') OR (user_id = '$friend_id' AND friend_id = '$user_id')");
                if(mysqli_num_rows($check) > 0) {
                    if(mysqli_fetch_assoc($check)['is_friends'] == '1') echo 'Already Friends!';
                    else echo 'Already Sent Request!';
                    
                }else{
                    $row = mysqli_fetch_assoc($query);
                    $friend_id = $row['id'];
                    $query = mysqli_query($conn, "INSERT INTO `requests` (`user_id`, `friend_id`) VALUES ('$user_id', '$friend_id')");
                    if($query) {
                        echo 'Friend Request Sent!';
                    }
                }
                
            }
        }

        

    }
?>
    </section>
    <section class="transfer-section">
        <div class="transfer-section-header">
            <h2>Friend Requests</h2>
        </div>
        <div class="transfers">
            <?php
                $que = mysqli_query($conn, "SELECT * FROM `requests` WHERE friend_id = '$user_id' && is_friends = '0'");
                if(mysqli_num_rows($que) == 0) {
                    ?><h3>No Friend Requests</h3><?php
                }
                
                while($row = mysqli_fetch_assoc($que)) {
                    $friend_id = $row['user_id'];
                    $friend = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$friend_id'");
                    $fren = mysqli_fetch_assoc($friend);
                    $friend_username = $fren['username'];
                    $friend_email = $fren['email'];
                    $friend_pic = $fren['pic'];
                    $friend_status = $fren['online'];
                    ?>
                    <div class="transfer">
                    <div class="transfer-logo">
                        <img src="<?=$friend_pic?>" alt="">
                    </div>
                    <dl class="transfer-details">
                        <div style="font-size: large;">
                            <?=$friend_username?>
                        </div>
                    </dl>
                    <div>
                        <form action="<?=$url?>" method="POST">
                            <input type="number" name="id" value="<?=$friend_id?>" hidden>
                            <input type="text" name="username" value="<?=$friend_username?>" hidden>
                            <input type="submit" value="Accept" class="btn accept" name="accept">
                            <input type="submit" value="Decline" class="btn decline" name="decline">
                        </form>
                    </div>
                </div>

                <?php
                }


                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept'])) {
                    $id = $_POST['id'];
                    $username = $_POST['username'];
                    $accept = mysqli_query($conn, "UPDATE `requests` SET is_friends = '1' WHERE user_id = '$id' && friend_id = '$user_id'");
                    if($accept) {
                        echo 'Friend Request Accepted!';
                    }
                }
                if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['decline'])) {
                    $id = $_POST['id'];
                    $decline = mysqli_query($conn, "DELETE FROM `requests` WHERE user_id = '$id' && friend_id = '$user_id'");
                    if($decline) {
                        echo 'Friend Request Declined!';
                        echo '<script>
                                setTimeout(function() {
                                    window.location.reload();
                                }, 10000); // 10000 milliseconds = 10 seconds
                            </script>';
                    }
                }

            ?>
        </div>
    </section>
    

    <section class="transfer-section">
        <div class="transfer-section-header">
            <h2>Your Friends</h2>
        </div>
        <div class="transfers">
            <?php
                $sql = mysqli_query($conn, "SELECT * FROM `requests` WHERE user_id = '$user_id' || friend_id = '$user_id' && is_friends = '1'");

                if(mysqli_num_rows($sql) == 0) {
                    ?><h3>No Friends</h3><?php
                }
                
                while($row = mysqli_fetch_assoc($sql)) {
                    if($row['user_id'] == $user_id) {
                        $friend_id = $row['friend_id'];
                    }else{
                        $friend_id = $row['user_id'];
                    }
                    if($row['is_friends'] == '1') {
                        $friend_request = 'Friends';
                    }else{
                        $friend_request = 'Pending';
                    }
                    $friend = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$friend_id'");
                    $fren = mysqli_fetch_assoc($friend);
                    $friend_username = $fren['username'];
                    $friend_email = $fren['email'];
                    $friend_pic = $fren['pic'];
                    $friend_status = $fren['online'];
                    ?>
                    <div class="transfer">
                    <div class="transfer-logo">
                        <img src="<?=$friend_pic?>" alt="">
                    </div>
                    <dl class="transfer-details">
                        <div>
                            <dd>Username</dd>
                            <dt><?=$friend_username?></dt>
                        </div>
                        <div>
                            <dd>Email</dd>
                            <dt><?=$friend_email?></dt>
                        </div>
                        <div>
                            <dd>Status</dd>
                            <dt><?=$friend_request?></dt>
                        </div>
                    </dl>
                    <div class="transfer-number">
                        <?php 
                            if($friend_status == '1') {
                                echo "Online";
                            }else{
                                echo "Offline";
                            }
                        ?>
                    </div>
                </div>

                <?php
                }
            ?>

        </div>
    </section>
</div>