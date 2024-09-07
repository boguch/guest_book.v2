<?php
    session_start();
    require_once ("functions.php");
    require_once ("connect_db.php");

    $checkInputUsername = new CheckPostInput("username",20);
    $checkInputEmail = new CheckPostInput("email",50);
    $checkInputCaptcha = new CheckPostInput("captcha",10);
    $checkInputComment = new CheckPostInput("comment",1000);

    $checkInputUsername->get();
    $checkInputUsername->checkAdminUsername();

    $checkInputEmail->get();
    $checkInputEmail->checkAdminEmail();

    $checkInputCaptcha->get();
    $checkInputCaptcha->check();
    $checkInputCaptcha->checkCaptcha();

    $checkInputComment->get();
    $checkInputComment->check();
    $checkInputComment->checkArea();

    $setDb = new DB($mysql,$_SESSION["comment"],$_SESSION["username"],$_SESSION["email"],$_POST['button_click_time'],$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT']);
    
    $setDb->connect();
    $mysql->close();

?>