<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mr-auto mt-5 text-md-left text-center"></div>
    </div>
</div>
<div class="container-fluid error-content">
    <div class="">
        <p class="mini-text">Thank you</p>
        <p class="error-text mb-5 mt-1">Thank you for taking the time to rate your experience.</p>
        <?= img(['src' => "assets/images/good-feedback.png", 'alt' => "", 'class' => "error-img"]) ?>
        <p class="error-text mb-5 mt-1">
            Your feedback is valuable to us and helps us improve our services. Please share your thoughts by selecting the appropriate rating below. We appreciate your input!
        </p>
        <?= anchor('', '<i class="far fa-arrow-left"></i> Go Back', 'class="btn btn-dark mt-5"'); ?>
    </div>
</div>