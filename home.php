<?php
include "dbconfig.php";
include "check_token.php";  // Check user token

// Check user login or not
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
}

?>
<!doctype html>
<html>

<head></head>

<body>
    <h1>Homepage</h1>
    <br>
    <a href="logout.php">Logout</a>
</body>

</html>