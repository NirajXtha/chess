<?php
session_start();
include('config/db.php');

if (empty($_SESSION['token']) || empty($_SESSION['email']) || empty($_SESSION['username']) || empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$token = $_SESSION['token'];

$profile_pic = "./img/user.png";

$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
if (mysqli_num_rows($query) == 0) {
    header('Location: index.php');
    exit();
}

if ($row = mysqli_fetch_assoc($query)) {
    if ($row['pic'] != NULL) {
        $profile_pic = $row['pic'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Chess</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
        crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">

    <!-- Google Icons (Material Design) -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/icon?family=Material+Icons"
        crossorigin="anonymous">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/5b14db5f0b.js" crossorigin="anonymous"></script>

    <!-- SweetAlert -->
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>

    <!-- Chessboard JS -->
    <link rel="stylesheet"
        href="https://unpkg.com/@chrisoakman/chessboardjs@1.0.0/dist/chessboard-1.0.0.min.css"
        integrity="sha384-q94+BZtLrkL1/ohfjR8c6L+A6qzNH9R2hBLwyoAfu3i/WCvQjzL2RQJ3uNHDISdU"
        crossorigin="anonymous">
    <script defer src="https://unpkg.com/@chrisoakman/chessboardjs@1.0.0/dist/chessboard-1.0.0.min.js"
        integrity="sha384-8Vi8VHwn3vjQ9eUHUxex3JSN/NFqUg3QbPyX8kWyb93+8AC/pPWTzj+nHtbC5bxD"
        crossorigin="anonymous"></script>

    <!-- Chess JS (slightly modified) -->
    <script defer src="js/chess.js"></script>
    </script>

    <!-- Bootstrap JS -->
    <script defer
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
        integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
        crossorigin="anonymous">
    </script>

    <!-- Custom JS -->
    <script defer src="js/main.js"></script>
</head>

<body>
    <div class="app">
        <header class="app-header">
            <div class="app-header-logo">
            </div>
            <div class="app-header-navigation">
                <div class="tabs">
                    <a href="./dashboard.php">
                        Overview
                    </a>
                    <a href="./play.php" class="active">
                        Play
                    </a>
                    <a href="./profile.php">
                        Account
                    </a>
                    <a href="./friends.php">
                        Friends
                    </a>
                    <a href="./games.php">
                        Match History
                    </a>
                </div>
            </div>
            <div class="app-header-actions">
                <button class="user-profile">
                    <span><?= $username ?></span>
                    <span>
                        <img src="<?= $profile_pic ?>" />
                    </span>
                </button>
            </div>
            <div class="app-header-mobile">
                <button class="icon-button large">
                    <i class="ph-list"></i>
                </button>
            </div>

        </header>
        <main>
            <div class="container my-3">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <h1 class="text-align-center">Play Chess</h1>
                        <br>
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="compVsCompHeading">
                                    <h2 class="text-align-center">
                                        <button class="btn btn-header no-outline" onclick="window.location.href='dashboard.php'">
                                            Back To Dashboard
                                        </button>
                                    </h2>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="settingsHeading">
                                    <h2 class="text-align-center">
                                        <button class="btn btn-header no-outline" data-toggle="collapse" data-target="#settings" aria-expanded="true" aria-controls="settings">
                                            Settings
                                        </button>
                                    </h2>
                                </div>
                            </div>
                            <div id="settings" class="collapse" aria-labelledby="settingsHeading" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="form-group">
                                            <label for="search-depth">Level (Black):</label>
                                            <select id="search-depth">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3" selected>3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center justify-content-center">
                                        <div class="form-group">
                                            <input type="checkbox" id="showHint" name="showHint" value="showHint">
                                            <label for="showHint">Show Suggested Move</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="compVsCompHeading">
                                    <h2 class="text-align-center">
                                        <button class="btn btn-header no-outline" data-toggle="collapse" data-target="#compVsComp" aria-expanded="true" aria-controls="compVsComp">
                                            Computer vs. Computer
                                        </button>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div id="compVsComp" class="collapse" aria-labelledby="compVsCompHeading" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row text-align-center">
                                    <div class="col-md-6 my-2">
                                        <button class="btn btn-success" id="compVsCompBtn">Start Game</button>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <button class="btn btn-danger" id="resetBtn">Stop and Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 text-align-center">
                            <div class="col-md-12">
                                <h2>Advantage</h2>
                                <p><span id="advantageColor">Neither side</span> has the advantage
                                    (+<span id="advantageNumber">0</span>).</p>
                                <div class="progress">
                                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="0" style="width: 50%"
                                        aria-valuemin="-2000" aria-valuemax="4000" id='advantageBar'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 text-align-center">
                            <div class="col-md-12">
                                <h2>Status</h2>
                                <p><span id="status"><b>White's</b> turn to move.</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="myBoard"></div>
                        <div class="row my-3 text-align-center">
                            <div class="col-md-6 my-2">
                                <button class="btn btn-danger" id="undoBtn">Undo</button>
                            </div>
                            <div class="col-md-6 my-2">
                                <button class="btn btn-success" id="redoBtn">Redo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src='https://unpkg.com/phosphor-icons'></script>
    <script>
        document.querySelector('.user-profile').addEventListener('click', () => {
            window.location.href = 'profile.php';
        });

        var hasRun = false;

        function gameEndWinningStatus(whatHappened, color, status, comp, depth) {
            if (color = "Black") {
                showColor = "White";
            } else {
                showColor = "Black";
            }
            if (comp) {
                type = "Computer";
            } else {
                type = "Solo";
            }
            if (!hasRun) {
                hasRun = true;
                $.ajax({
                    url: 'save_game.php',
                    method: 'POST',
                    data: {
                        id: '<?= $user_id ?>',
                        type: type,
                        status: status,
                        level: depth
                    },
                    success: function(response) {
                        console.log('Status saved successfully:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving status:', error);
                    }
                });
            }


            $(document).ready(function() {
                Swal.fire({
                    icon: "info",
                    title: whatHappened,
                    text: showColor + " " + status,
                    showDenyButton: true,
                    confirmButtonText: "Play Again",
                    denyButtonText: `Back to Dashboard`
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    } else if (result.isDenied) {
                        window.location.href = "dashboard.php";
                    }
                });
            });
        }
    </script>
</body>

</html>