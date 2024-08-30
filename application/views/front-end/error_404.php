<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Banner Start -->
<section class="banner">
    <div class="container ">
        <div class="row gy-4 gy-sm-0 align-items-center">
            <div class="col-12 col-sm-6">
                <div class="banner__content">
                    <h1 class="banner__title display-4 wow fadeInLeft" data-wow-duration="0.8s">404 Error Page</h1> 
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb wow fadeInRight" data-wow-duration="0.8s">
                            <li class="breadcrumb-item"><?= anchor('', 'Home'); ?></li>
                            <li class="breadcrumb-item active" aria-current="page">404 Error Page</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="banner__thumb text-end">
                    <?= img("assets/images/error_banner.png"); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner End -->

<!-- error page start -->
<section class="error-page text-center section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 col-xxl-8">
                <div class="error-page__thumb wow fadeInDown" data-wow-duration="0.8s">
                    <?= img("assets/images/error_page.png"); ?>
                </div>
            </div>
            <div class="col-12 col-md-8 col-xxl-6">
                <div class="section__content mt-5">
                    <h2 class="section__content-title wow fadeInUp" data-wow-duration="0.8s">Oops! Page Not Found</h2> 
                    <p class=" wow fadeInDown" data-wow-duration="0.8s">No webpage was found for the web address: <?= current_url(); ?></p>
                    <?= anchor('', 'Back To Home<i class="bi bi-arrow-up-right"></i><span></span>', 'class="btn_theme btn_theme_active mt_40  wow fadeInUp"'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- error page end -->