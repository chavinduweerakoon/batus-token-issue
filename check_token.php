<?php

if (isset($_SESSION['username'])) {
    $sqll = $pdo->prepare('SELECT token from user_token where username = : userName');
    $sqll->execute(array('userName' => $_SESSION['username']));
    $result = $sqll->fetch();
    if ($result) {

        $token = $result['token'];

        if ($_SESSION['token'] != $token) {
            session_destroy();
            header('Location: index.php');
        }
    }
}
