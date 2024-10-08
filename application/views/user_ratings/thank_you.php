<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Banner Start -->
<!-- <section class="banner">
    <div class="container ">
        <div class="row gy-4 gy-sm-0 align-items-center">
            <div class="col-12 col-sm-6">
                <div class="banner__content">
                    <h1 class="banner__title display-4 wow fadeInLeft" data-wow-duration="0.8s">Thank you</h1> 
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb wow fadeInRight" data-wow-duration="0.8s">
                            <li class="breadcrumb-item"><?= anchor('', 'Home'); ?></li>
                            <li class="breadcrumb-item active" aria-current="page">Thank you</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="banner__thumb text-end">
                    <?= img("assets/images/reviews_banner.png"); ?>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- Banner End -->

<!-- thank you page start -->
<section class="error-page text-center section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 col-xxl-8">
                <div class="error-page__thumb wow fadeInDown" data-wow-duration="0.8s">
                    <?= img("assets/images/good-feedback.png", '', 'width="30%"'); ?>
                </div>
            </div>
            <div class="col-12 col-md-8 col-xxl-6">
                <div class="section__content mt-5">
                    <h2 class="section__content-title wow fadeInUp" data-wow-duration="0.8s">Thank you</h2> 
                    <p>Thank you for taking the time to rate your experience.</p>
                    <p>
                        Your feedback is valuable to us and helps us improve our services. Please share your thoughts by selecting the appropriate rating below. We appreciate your input!
                    </p>
                    <?= anchor('', 'Back To Home<i class="bi bi-arrow-up-right"></i><span></span>', 'class="btn_theme btn_theme_active mt_40"'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- thank you page end -->