<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>token-issue-check</title>
    <style>
        /* Container */
        .container {
            width: 40%;
            margin: 0 auto;
        }

        /* Login */
        #div_login {
            border: 1px solid gray;
            border-radius: 3px;
            width: 470px;
            height: 270px;
            box-shadow: 0px 2px 2px 0px gray;
            margin: 0 auto;
        }

        #div_login h1 {
            margin-top: 0px;
            font-weight: normal;
            padding: 10px;
            background-color: cornflowerblue;
            color: white;
            font-family: sans-serif;
        }

        #div_login div {
            clear: both;
            margin-top: 10px;
            padding: 5px;
        }

        #div_login .textbox {
            width: 96%;
            padding: 7px;
        }

        #div_login input[type=submit] {
            padding: 7px;
            width: 100px;
            background-color: lightseagreen;
            border: 0px;
            color: white;
        }

        /* media */
        @media screen and (max-width:720px) {
            .container {
                width: 100%;
            }

            #div_login {
                width: 99%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Login</h1>
                <div>
                    <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" required />
                </div>
                <div>
                    <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password" required />
                </div>
                <div>
                    <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                </div>
            </div>
        </form>
    </div>
</body>

</html>
<?php
include "dbconfig.php";

// Generates unique token based on The IP address from which the user is viewing, and the browser 
function getToken($username)
{
    $token = '';
    $random_string = $username;
    $token = sha1('batu-user' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . $random_string . $_SERVER['HTTP_USER_AGENT'] . '2021');
    return $token;
}

if (isset($_POST['but_submit'])) {

    $userName = $_POST['txt_uname'];
    $password = $_POST['txt_pwd'];

    if ($userName != "" && $password != "") {

        $result = $pdo->prepare('SELECT count(*) as cntUser from users where username=:userName and password=:password');
        $result->execute(array('userName' => $userName, 'password' => $password));
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $count = $row['cntUser'];

        if ($count > 0) {
            $token = getToken($userName);
            $_SESSION['username'] = $userName;
            $_SESSION['token'] = $token;

            // Update user token 
            $row_token = $pdo->prepare('SELECT count(*) as allcount from user_token where username=:userName');
            $row_token->execute(array('userName' => $userName));
            $row_token = $row_token->fetch(PDO::FETCH_ASSOC);
            if ($row_token['allcount'] > 0) {
                $update = $pdo->prepare('UPDATE user_token set token =:token where username=:userName');
                $update->execute(array('token' => $token, 'userName' => $userName));
            } else {
                $insert = $pdo->prepare('INSERT into user_token(username,token) VALUES (:userName,:token)');
                $insert->execute(array('token' => $token, 'userName' => $userName));
            }
            header('Location: home.php');
        } else {
            echo "Invalid username and password";
        }
    }
}
