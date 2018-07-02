<?php
session_start();
require '../config/config.php';
// IF THERE IS A POST OF THE FORM, IF NOT RETURN TO THE REGISTRATION PAGE
if ($_POST) {
    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";
    $stayLogged = isset($_POST['formStayLogged']) ? true : false;

    // Retrieving the user and his hash pass
    $que = $dbManager->prepare('SELECT id, username, password FROM member WHERE username = :username');
    $que->bindParam(':username', $username, \PDO::PARAM_STR);
    $que->execute();
    $result = $que->fetch();

    // Comparison of the pass sent via the form with the base
    $isPasswordCorrect = password_verify($password, $result['password']);

    if (!$result) {
        $_SESSION['post'] = $_POST;
        $_SESSION['errors']['signin'] = "Wrong username or password !";
        header("location: /signin.php");
        exit();
    } else {
        if ($isPasswordCorrect) {
            $_SESSION['auth'] = [
                "isAuth" => true,
                "id" => $result['id'],
                "username" => $result['username']
            ];
            $_SESSION['alert'] = ['type' => "success",
                'title' => "Logged !",
                'message' => "Hello $username, you signed in succeffuly ;D"];
            if ($stayLogged === true) {
                setcookie("auth[id]", $result['id'], time() + 3600, '/');
                setcookie("auth[username]", $result['username'], time() + 3600, '/');
                setcookie("auth[password]", $result['password'], time() + 3600, '/');
            }

            header('location: /index.php');
            exit();
        } else {
            $_SESSION['post'] = $_POST;
            $_SESSION['errors']['signin'] = "Wrong username or password !";
            header("location: /signin.php");
            exit();
        }
    }
} else {
    header('location: /signin.php');
    exit();
}