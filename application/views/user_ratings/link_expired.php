<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mr-auto mt-5 text-md-left text-center"></div>
    </div>
</div>
<div class="container-fluid error-content">
    <div class="">
        <p class="mini-text">Ooops!</p>
        <p class="error-text mb-5 mt-1">Link Expired!</p>
        <?= img(['src' => "assets/images/expired.png", 'alt' => "", 'class' => "error-img"]) ?>
        <p class="error-text mb-5 mt-1">We’re sorry, but the link you tried to access has expired. If you need assistance or would like to request a new link, please contact us, and we’ll be happy to help.</p>
        <?= anchor('', '<i class="far fa-arrow-left"></i> Go Back', 'class="btn btn-dark mt-5"'); ?>
    </div>
</div>