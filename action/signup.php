<?php
session_start();
require '../config/config.php';
// IF THERE IS A POST OF THE FORM, IF NOT RETURN TO THE REGISTRATION PAGE
if ($_POST) {
    $_SESSION['post'] = $_POST;
    $_SESSION['errors'] = [];

    // -------------------- VERIFICATION OF CAPTCHA --------------------
    $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        ['secret' => $reCaptchaGoogle_Secret,
         'response' => $_POST['g-recaptcha-response']]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec ($ch);
    curl_close ($ch);

    if(!json_decode($response)->success) {
        $_SESSION['errors']['recaptcha'] = "Error checking reCAPTCHA! Please try again.";
    }
    // ----------------- END OF VERIFICATION OF CAPTCHA -----------------

    // -------------------- ERROR MANAGEMENT --------------------
    if (strlen($_POST['username']) < 3) {
        $_SESSION['errors']['username'] = "Your username must contain 3 characters minimum !";
    } else {
        // VERIFICATION IF PSEUDO EXISTS ON DATABASE
        $que = $dbManager->prepare('SELECT username FROM member WHERE username = ?');
        $que->execute([$_POST['username']]);
        while ($que->fetch()) {
            $_SESSION['errors']['username'] = "This username is already used, please choose another one !";
        }
    }

    if (!preg_match("#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#i", $_POST['email'])) {
        $_SESSION['errors']['email'] = "Your email address must be correct !";
    }

    if ($_POST['password1'] !== $_POST['password2']) {
        $_SESSION['errors']['password2'] = "Passwords don't match !";
    }
    if (strlen($_POST['password1']) < 5) {
        $_SESSION['errors']['password1'] = "The password must contain 5 characters minimum !";
    }
    // -------------------- END ERROR MANAGEMENT --------------------

    // IF THERE IS NO ERROR, THE RECORDING CAN BE CONTINUED, OR WE RETURN TO THE REGISTRATION PAGE
    if (count($_SESSION['errors']) <= 0) {
        $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
        try {
            $que = $dbManager->prepare('INSERT INTO member VALUE (null, :username, :password, :email, now())');
            $que->bindParam(':username', $_POST['username'], \PDO::PARAM_STR);
            $que->bindParam(':password', $password, \PDO::PARAM_STR);
            $que->bindParam(':email', $_POST['email'], \PDO::PARAM_STR);
            $que->execute();
            $que->closeCursor();

            // IF EVERYTHING GOES WELL, WE GENERATE A SESSION ALERT ['type', 'title', 'message'];
            $_SESSION['alert'] = ['type' => "success",
                'title' => "Sign up completed!",
                'message' => "Your registration ended successfully. You can send messages :D"];
            $_SESSION['auth'] = [
                "isAuth" => true,
                "id" => $dbManager->lastInsertId(),
                "username" => $_POST['username']
            ];
            header('location: /index.php');
            exit();

        } catch (\Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    } else {
        header('location: /signup.php');
    }

} else {
    header('location: /signup.php');
    exit();
}