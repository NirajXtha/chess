<?php
    session_start();
    $username = $_SESSION['username'];
    $pdo = new PDO('mysql:host=localhost;dbname=chess', 'root', '');

    if (isset($_POST['query'])) {
        $query = $_POST['query'];
        
        // Search the 'users' table for matches in 'name' or 'username'
        $stmt = $pdo->prepare("SELECT username, name FROM users WHERE username LIKE ? OR name LIKE ? AND NOT username = ? LIMIT 10");
        $stmt->execute(['%' . $query . '%', '%' . $query . '%', $username]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($results) {
            foreach ($results as $user) {
                if($user['username'] != $username){
                    echo '<div class="search-option" onclick="selectUser(\''.htmlspecialchars($user['username']).'\')">';
                    echo '<strong>' . htmlspecialchars($user['username']) . '</strong> - ' . htmlspecialchars($user['name']);
                    echo '</div>';
                }
            }
        } else {
            echo '<div>No results found</div>';
        }
    }
?>
