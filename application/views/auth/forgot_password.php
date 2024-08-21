<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="auth-container d-flex">
    <div class="container mx-auto align-self-center">
        <?= form_open('', 'class="ajax-form text-left"') ?>
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                <div class="card mt-3 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center">
                                <?= img('assets/images/logo.png', '', 'width="128"'); ?>
                                <h2 class="">Password Recovery</h2>
                                <p class="">Enter your email and instructions will sent to you!</p>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input id="email" name="email" type="text" class="form-control" placeholder="e.g john_doe@test.com" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary w-100">Request Reset</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-center">
                                    <p class="mb-0">For Login <?= anchor('auth/login', "Click here", 'class="text-warning"'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>