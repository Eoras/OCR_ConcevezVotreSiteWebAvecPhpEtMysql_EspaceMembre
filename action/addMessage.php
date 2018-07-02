<?php
session_start();
include '../config/config.php';

if (isset($_POST)) {
    $message = trim($_POST['message']);
    if(empty($message)) $_SESSION['errors']['message'] = "The message content can not be empty !";

    if(!isset($_SESSION['errors'])) {
        $que = $dbManager->prepare('INSERT INTO message (member_id, message, date) VALUES(:member_id, :message, now())');
        $que->bindParam(":member_id", $_SESSION['auth']['id'], \PDO::PARAM_STR);
        $que->bindParam(":message", $_POST['message'], \PDO::PARAM_STR);
        $que->execute();
        header('location: /index.php');
        exit();
    } else {
        $_SESSION['post'] = $_POST;
        header('location: /index.php');
    }
}