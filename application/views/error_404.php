<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mr-auto mt-5 text-md-left text-center"></div>
    </div>
</div>
<div class="container-fluid error-content">
    <div class="">
        <p class="mini-text">Ooops!</p>
        <p class="error-text mb-5 mt-1">Page Not Found!</p>
        <?= img(['src' => "assets/images/error.svg", 'alt' => "", 'class' => "error-img"]) ?>
        <p class="error-text mb-5 mt-1">No webpage was found for the web address: <?= current_url(); ?></p>
        <?= anchor('', '<i class="far fa-arrow-left"></i> Go Back', 'class="btn btn-dark mt-5"'); ?>
    </div>
</div>