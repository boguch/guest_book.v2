<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
    <header>
            <?php
            session_start();
            ?>
            <div>
                <a href=<?php echo $exile;?>><?php echo $exileTitle;?></a>
            </div>
    </header>
        <body>