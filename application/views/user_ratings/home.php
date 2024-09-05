<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- loan-reviews page start -->
<section class="loan-reviews loan-reviews--tertiary section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="d-flex flex-column gap-4">
                <?php foreach ($rating_platforms as $platform): if(empty($platform['setting'])) continue; ?>
                <div class="loan-reviews_card card wow fadeInUp" data-wow-duration="0.8s">
                    <div class="loan-reviews__part-one">
                        <div class="loan-reviews__thumb">
                            <?= img($this->config->item('platforms-logos').$platform['logo'], '', 'width="100"') ?>
                        </div>
                        <div class="loan-reviews__review">
                            <p class="rating"><?= $platform['setting']['average_review']; ?></p>
                            <div class="d-flex gap-2 flex-column">
                                <div class="star_review">
                                    <?php for ($i=1; $i <= 5; $i++) {
                                        echo '<i class="bi bi-star'.($i <= $platform['setting']['average_review'] ? '-fill' :  ($i <= ceil($platform['setting']['average_review']) ? '-half' : '')).' star-active"></i>';
                                    } ?>
                                </div>
                                <p class="fs-small">Average Review</p>
                            </div>
                        </div>
                    </div>
                    <div class="loan-reviews__part-two">
                        <div class="reviews-heading">
                            <h4 class="reviews-heading__title"><?= $platform['platform'] ?></h4>
                        </div>
                        <div class="reviews-inner">
                            <ul>
                                <li><i class="bi bi-check2-circle"></i> Certified pre-approval Process</li>
                                <li><i class="bi bi-check2-circle"></i> Online Application Available 24/7</li>
                                <li><i class="bi bi-check2-circle"></i>Find a Quote Easily</li>
                                <li><i class="bi bi-check2-circle"></i>100% Online Refinance</li>
                            </ul>
                        </div>
                    </div>
                    <div class="loan-reviews__part-three">
                        <div class="btn-group">
                            <?= anchor('user-ratings/'.$this->uri->segment(2).'/'.e_id($platform['id']), 'Make Review<i class="bi bi-arrow-up-right"></i><span></span>', 'class="btn_theme btn_theme_active"'); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- loan-reviews end -->
<!-- <style>
    .auth-container {
        background-image: url(<?= base_url('assets/images/email-pattern.png') ?>);
        background-repeat: repeat;
        background-size: auto;
    }
</style>
<div class="auth-container d-flex">
    <div class="container mx-auto align-self-center">
        <div class="row">
            
        </div>
    </div>
</div> -->