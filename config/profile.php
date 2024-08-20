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
    $query = mysqli_query($conn, "SELECT * FROM `profile` WHERE id = '$user_id'");
    $games = mysqli_num_rows($query);
    $win = 0;
    $draw = 0;

    if($games != NULL){
        while($row = mysqli_fetch_assoc($query)) {
            if($row['status'] == 'win') {
                $win++;
            }
            if($row['status'] == 'draw') {
                $draw++;
            }
        }
    }

    $friends = 0;
    $request_sent = 0;
    $fren = mysqli_query($conn, "SELECT * FROM `requests` WHERE user_id = '$user_id' || friend_id = '$user_id' && is_friends = '1'");
    if(mysqli_num_rows($fren) > 0) {
        while($row = mysqli_fetch_assoc($fren)) {
            if($row['is_friends'] == '1') {
                $friends++;
            }else{
                $req++;
            }
        }
    }

    $request = mysqli_query($conn, "SELECT * FROM `requests` WHERE friend_id = '$user_id' && is_friends = '0'");
    $request_received = mysqli_num_rows($request);
    
?>

<div class="app-body-main-content">
    <section class="profile-section">
        <h2>Your Account's Overview <a href="profile-edit.php"><i class="ph ph-note-pencil"></i></a></h2>
        <div class="account">
            <div class="account-details">
                <div class="account-details-header">
                    
                    <div class="account-details-logo">
                        <img src="<?=$pic?>" />
                    </div>
                    <div class="account-details-info">
                        <h3>Username: <?=$username?></h3><br>
                        <p>Email: <?=$email?></p><br>
                        <p>Verification: <?php if($is_verified == 1) echo('Verified <i class="ph ph-checks"></i>'); else echo('Not Verified <i class="ph ph-prohibit"></i>'); ?></p><br>
                        <p>Creation Date: <?=$created_at?></p><br>
                        <p>Total Games Played: <?=$games?></p><br>
                        <p>Games Won: <?=$win?></p><br>
                        <p>Games Lost: <?=$games-$win-$draw?></p><br>
                        <p>Games Draw: <?=$draw?></p><br>
                        <p>Friends: <?=$friends?></p><br>
                        <p>Requests sent: <?=$request_sent?></p><br>
                        <p>Requests received: <?=$request_received?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</div>