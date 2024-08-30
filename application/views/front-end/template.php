<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$currentController = strtolower($this->router->fetch_class());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($title) ? $title .' | '. APP_NAME : APP_NAME ?></title>

    <!-- Favicon -->
    <?= link_tag('assets/images/favicon.png'.ASSET_VERSION, 'icon', 'image/png') ?>
    <?= link_tag('assets/images/favicon.png'.ASSET_VERSION, 'apple-touch-icon', 'image/png') ?>

    <!--  css dependencies start  -->
    <!-- bootstrap five css -->
    <?= link_tag('assets/vendor/bootstrap/css/bootstrap.min.css"'.ASSET_VERSION) ?>
    <!-- bootstrap-icons css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <!-- nice select css -->
    <?= link_tag('assets/vendor/nice-select/css/nice-select.css"'.ASSET_VERSION) ?>
    <!-- magnific popup css -->
    <?= link_tag('assets/vendor/magnific-popup/css/magnific-popup.css"'.ASSET_VERSION) ?>
    <!-- slick css -->
    <?= link_tag('assets/vendor/slick/css/slick.css"'.ASSET_VERSION) ?>
    <!-- odometer css -->
    <?= link_tag('assets/vendor/odometer/css/odometer.css"'.ASSET_VERSION) ?>
    <!-- animate css -->
    <?= link_tag('assets/vendor/animate/animate.css"'.ASSET_VERSION) ?>
    <!-- css dependencies end  -->

    <!-- main css -->
    <?= link_tag('assets/css/style.css"'.ASSET_VERSION) ?>
    
</head>

<body>
    <!--  Preloader  -->
    <div class="preloader">
        <span class="loader"></span>
    </div>

    <!--header-section start-->
    <header class="header-section index ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-xl nav-shadow" id="#navbar">
                        <?= anchor('', img('assets/images/logo2.png', '', 'class="logo" alt="logo"'), 'class="navbar-brand"'); ?>
                        <?php if(!in_array($currentController, ['user_ratings'])): ?>
                        <a class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="bi bi-list"></i>
                        </a>
                        <div class="collapse navbar-collapse ms-auto " id="navbar-content">
                            <div class="main-menu index-page">
                                <ul class="navbar-nav mb-lg-0 mx-auto"></ul>
                                <div class="nav-right d-none d-xl-block">
                                    <div class="nav-right__search">
                                        <?= anchor('auth/login', 'Sign In <i class="bi bi-arrow-up-right"></i><span></span>', 'class="btn_theme btn_theme_active"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Offcanvas More info-->
    <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasRight">
        <div class="offcanvas-body custom-nevbar">
            <div class="row">
                <div class="col-md-7 col-xl-8">
                    <div class="custom-nevbar__left">
                        <button type="button" class="close-icon d-md-none ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x"></i></button>
                        <ul class="custom-nevbar__nav mb-lg-0">
                            <li class="menu_item">
                                <?= anchor('', 'Home', 'class="menu_link"'); ?>
                            </li>
                            <li class="menu_item">
                                <?= anchor('auth/login', 'Sign In', 'class="menu_link"'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5 col-xl-4">
                    <div class="custom-nevbar__right">
                        <div class="custom-nevbar__top d-none d-md-block">
                            <button type="button" class="close-icon ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x"></i></button>
                            <div class="custom-nevbar__right-thumb mb-auto">
                                <img src="assets/images/logo.png" alt="logo">
                            </div>
                        </div>
                        <ul class="custom-nevbar__right-location">
                            <li>
                                <p class="mb-2">Phone: </p>
                                <a href="tel:+123456789" class="fs-4 contact">+123 456 789</a>
                            </li>
                            <li class="location">
                                <p class="mb-2">Email: </p>
                                <a href="https://pixner.net/cdn-cgi/l/email-protection#d59cbbb3ba95b2b8b4bcb9fbb6bab8" class="fs-4 contact"><span class="__cf_email__" data-cfemail="bcf5d2dad3fcdbd1ddd5d092dfd3d1">[email&#160;protected]</span></a>
                            </li>
                            <li class="location">
                                <p class="mb-2">Location: </p>
                                <p class="fs-4 contact">6391 Celina, Delaware 10299</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-section end -->

    <?= $contents; ?>
    <?php if(!in_array($currentController, ['user_ratings'])): ?>
    <!-- Footer Area Start -->
    <footer class="footer footer-secondary">
        <div class="container">
            <div class="row section">
                <div class="col-12">
                    <div class="footer-secondary__content">
                        <div class="footer__logo">
                            <?= anchor('', img('assets/images/logo.png', '', 'style="width: 200px; height: 80px;"')); ?>
                        </div>
                        <div class="social">
                            <a href="javascript:;" class="btn_theme social_box"><i class="bi bi-facebook"></i><span></span></a>
                            <a href="javascript:;" class="btn_theme social_box"><i class="bi bi-twitter"></i><span></span></a>
                            <a href="javascript:;" class="btn_theme social_box"><i class="bi bi-pinterest"></i><span></span></a>
                            <a href="javascript:;" class="btn_theme social_box"><i class="bi bi-twitch"></i><span></span></a>
                            <a href="javascript:;" class="btn_theme social_box"><i class="bi bi-skype"></i><span></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="footer__copyright">
                        <p class="copyright text-center">Copyright © <span id="copyYear"></span> <a href="<?= site_url(); ?>" class="secondary_color"><?= APP_NAME ?></a>. Designed By <a href="http://savitarainfotel.com" class="secondary_color" target="_blank">Savitara Infotel</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->
    <?php endif ?>

    <!-- scroll to top -->
    <a href="javascript:;" class="scrollToTop"><i class="bi bi-chevron-double-up"></i></a>

    <?= script("assets/vendor/jquery/jquery-3.6.3.min.js".ASSET_VERSION); ?>
    <!-- bootstrap five js -->
    <?= script("assets/vendor/bootstrap/js/bootstrap.bundle.min.js".ASSET_VERSION); ?>
    <!-- nice select js -->
    <?= script("assets/vendor/nice-select/js/jquery.nice-select.min.js".ASSET_VERSION); ?>
    <!-- magnific popup js -->
    <?= script("assets/vendor/magnific-popup/js/jquery.magnific-popup.min.js".ASSET_VERSION); ?>
    <!-- circular-progress-bar -->
    <script src="https://cdn.jsdelivr.net/gh/tomik23/circular-progress-bar@latest/docs/circularProgressBar.min.js"></script>
    <!-- slick js -->
    <?= script("assets/vendor/slick/js/slick.min.js".ASSET_VERSION); ?>
    <!-- odometer js -->
    <?= script("assets/vendor/odometer/js/odometer.min.js".ASSET_VERSION); ?>
    <!-- viewport js -->
    <?= script("assets/vendor/viewport/viewport.jquery.js".ASSET_VERSION); ?>
    <!-- jquery ui js -->
    <?= script("assets/vendor/jquery-ui/jquery-ui.min.js".ASSET_VERSION); ?>
    <!-- wow js -->
    <?= script("assets/vendor/wow/wow.min.js".ASSET_VERSION); ?>

    <?= script("assets/vendor/jquery-validate/jquery.validate.min.js".ASSET_VERSION); ?>

    <!--  / js dependencies end  -->

    <!-- plugins js -->
    <?= script("assets/js/plugins.js".ASSET_VERSION); ?>

    <?php if(!empty($validate)): ?>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <?php endif; ?>
    <!-- main js -->
    <?= script("assets/js/main.js".ASSET_VERSION); ?>
    <?= script("assets/js/script-f.js".ASSET_VERSION); ?>
</body>

</html>