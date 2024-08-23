<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .auth-container {
        background-image: url(<?= base_url('assets/images/email-pattern.png') ?>);
        background-repeat: repeat;
        background-size: auto;
    }
</style>
<div class="auth-container d-flex">
    <div class="container mx-auto align-self-center">
        <div class="row">
            <?php foreach ($rating_platforms as $platform): if(empty($platform['setting'])) continue; ?>
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <?= anchor('user-ratings/'.$this->uri->segment(2).'/'.e_id($platform['id']), img($this->config->item('platforms-logos').$platform['logo'], '', 'width="300"')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>