<?php
session_start();
include 'config/config.php';
if (isset($_COOKIE['auth']['id']) && isset($_COOKIE['auth']['username']) && isset($_COOKIE['auth']['password'])) {
    $que = $dbManager->prepare('SELECT id, username, password FROM member WHERE username = :username AND id = :id AND password = :password');
    $que->bindParam(':username', $_COOKIE['auth']['username'], \PDO::PARAM_STR);
    $que->bindParam(':id', $_COOKIE['auth']['id'], \PDO::PARAM_STR);
    $que->bindParam(':password', $_COOKIE['auth']['password'], \PDO::PARAM_STR);
    $que->execute();
    $result = $que->fetch();

    if ($result) {
        $_SESSION['auth'] = [
            "isAuth" => true,
            "id" => $_COOKIE['auth']['id'],
            "username" => $_COOKIE['auth']['username']
        ];
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <title>Eöras Mini-Chat</title>
</head>
<body>
<nav class="navbar navbar-expand navbar-light bg-light">
    <a class="navbar-brand" href="/"><i class="fas fa-home"></i> Eöras</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="mr-auto"></div>
        <div class="float-right d-flex align-items-center">
            <?php if ($_SESSION['auth']['isAuth'] ?? false) : ?>
                <p class="mb-0 p-2 d-inline">
                    <i class="fas fa-user fa-fw d-inline"></i> <?= $_SESSION['auth']['username'] ?>
                </p>
                <a href="action/signout.php" class="float-right btn btn-sm btn-warning float-right">
                    <i class="fas fa-sign-out-alt"></i></a>
            <?php elseif (!isset($_SESSION['auth']['isAuth'])) : ?>
                <a href="signup.php" class="btn btn-sm btn-info mr-2" title="Sign up">
                    Sign up <i class="fas fa-user-plus"></i>
                </a>
                <a href="signin.php" class="btn btn-sm btn-primary" title="Sign in">
                    Sign in <i class="fas fa-sign-in-alt"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container mt-3">