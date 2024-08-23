<div class="app-body-main-content">
    <section class="game-section">
        <div class="transfer-section-header">
            <h2>Your Game History</h2>
        </div>
        <div class="transfers">
            <?php
                $sql = mysqli_query($conn, "SELECT * FROM `profile` WHERE id = '$user_id' ORDER BY `played_at` DESC");
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
                    <h3 class="game_number"><?=$i+1?></h3>
                </div>
                <dl class="transfer-details">
                    <div>
                        <dt><?=$type?></dt>
                        <dd>level <?=$level?></dd>
                    </div>
                    <div>
                        <dt><?php if($status == 'win') {echo "Checkmate";} elseif($status == 'lose') {echo "Checkmate";} else {echo "Draw";}?></dt>
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