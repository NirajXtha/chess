<?php
    $games = 0;
    $win = 0;
    $friends = 0;
    $sql = mysqli_query($conn, "SELECT * FROM `profile` WHERE id = '$user_id' ORDER BY `played_at` DESC");
    if(mysqli_num_rows($sql) > 0) {
        $games = mysqli_num_rows($sql);
        $que = mysqli_query($conn, "SELECT * FROM `requests` WHERE user_id = '$user_id' && is_friends = '1'");
        $friends = mysqli_num_rows($que);

        while($row = mysqli_fetch_assoc($sql)) {
            $status = $row['status'];
            $level = $row['level'];
            $played_at = $row['played_at'];
            if($status == 'win') {
                $win++;
            }
        }
    }
?>
<div class="app-body-main-content">
    <section class="service-section">
        <h2>Your Game's Overview</h2>
        <div class="tiles">
            <article class="tile">
                <div class="tile-header">
                    <i class="ph-horse"></i>
                    <h3>
                        <span>Games Played</span>
                        <span></span>
                    </h3>
                </div>
                <a href="#">
                    <span><?=$games?></span>

                </a>
            </article>
            <article class="tile">
                <div class="tile-header">
                    <i class="ph-check-circle"></i>
                    <h3>
                        <span>Games Won</span>
                        <span></span>
                    </h3>
                </div>
                <a href="#">
                    <span><?=$win?></span>

                </a>
            </article>
            <article class="tile">
                <div class="tile-header">
                    <i class="ph-users"></i>
                    <h3>
                        <span>Friends</span>
                        <span></span>
                    </h3>
                </div>
                <a href="#">
                    <span><?=$friends?></span>

                </a>
            </article>
        </div>
        <div class="service-section-footer">
            <p>Stay focused and strategic! Each move brings you closer to victory!</p>
        </div>
    </section>
    <section class="transfer-section">
        <div class="transfer-section-header">
            <h2>Latest Games</h2>
            <div class="filter-options">
                <p>Only shown the last 3 games</p>

            </div>
        </div>
        <div class="transfers">
            <?php
                $sql = mysqli_query($conn, "SELECT * FROM `profile` WHERE id = '$user_id' ORDER BY `played_at` DESC LIMIT 3");
                if(mysqli_num_rows($sql) == 0) {
                    ?><h3>No Games Played</h3><?php
                }
                for($i = 0; $i < mysqli_num_rows($sql); $i++) {
                    $row = mysqli_fetch_assoc($sql);
                    $status = $row['status'];
                    $level = $row['level'];
                    $played_at = $row['played_at'];
                    $type = $row['type'];
                    ?>
                    <div class="transfer">
                <div class="transfer-logo">
                    <img src="./img/<?=$i+1?>.jpg" />
                </div>
                <dl class="transfer-details">
                    <div>
                        <dt><?=$type?></dt>
                        <dd>level <?=$level?></dd>
                    </div>
                    <div>
                        <dt><?php if($status == 'win') {echo "Checkmate";} elseif($status == 'lose') {echo "Checkmate";} else {echo "Stalemate";}?></dt>
                        <dd><?php if($status == 'win') {echo "White";} elseif($status == 'lose') {echo "Black";} else {echo "White";}?></dd>
                    </div>
                    <div>
                        <dt>Date Played</dt>
                        <dd><?=$played_at?></dd>
                    </div>
                </dl>
                <div class="transfer-number">
                    <?php if($status == 'win') {echo "Won";} elseif($status == 'lose') {echo "Lost";} else {echo "Draw";}?>
                </div>
            </div>
                <?php 
                }
            ?>
        </div>
    </section>
</div>