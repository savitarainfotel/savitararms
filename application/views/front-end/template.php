<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($title) ? $title .' | '. APP_NAME : APP_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <?= link_tag('assets/images/favicon.png'.ASSET_VERSION, 'icon', 'image/png') ?>
    <?= link_tag('assets/images/favicon.png'.ASSET_VERSION, 'apple-touch-icon', 'image/png') ?>

    <?= link_tag('assets/css/style.css'.ASSET_VERSION) ?>
    
</head>

<body>
    <div class="navbar" id="navbar">
        <div class="logo">
            <?= anchor('', img('assets/images/logo.png', '', 'width="128"')); ?>
        </div>
        <div class="nav-links">
            <?= anchor('', 'Home'); ?>
            <?= anchor('', 'About'); ?>
            <?= anchor('', 'Services'); ?>
            <?= anchor('', 'Contact'); ?>
        </div>
    </div>

    <?= $contents; ?>

    <div class="particles"></div>
    <div class="star-background"></div>

    <?= script("assets/js/script-f.js".ASSET_VERSION); ?>
</body>

</html>