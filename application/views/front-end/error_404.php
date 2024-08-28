<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <h1>Page Not Found!</h1>
    <p>No webpage was found for the web address: <?= current_url(); ?></p>
    <?= anchor('', '<i class="far fa-arrow-left"></i> Go Back', 'class="cta-button"'); ?>
</div>