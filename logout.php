<?php

include "dbconfig.php";

if (isset($_SESSION['username'])) {
    // Delete token 
    $userName =  $_SESSION['username'];
    $sqll = $pdo->prepare('DELETE * FROM user_token WHERE username = :userName');
    $sqll->execute(array('userName' => $userName));

    // Destroy session
    session_destroy();
    header('Location: index.php');
} else {
    header('Location: index.php');
}
