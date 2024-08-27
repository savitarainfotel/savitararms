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
                                <h2 class="">Sign In</h2>
                                <p class="">Log in to your account to continue.</p>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input id="email" name="email" type="text" class="form-control" placeholder="e.g john_doe@test.com" />
                                </div>
                            </div>
                            <?php if(!$this->input->cookie('dev')) { ?>
                                <div class="col-12">
                                    <div class="mb-4 form-group">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="input-group">
                                            <input id="password" name="password" type="password" class="form-control" placeholder="xxxx" />
                                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 25 25" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="toggle-password feather feather-eye input-group-text"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-12">
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-center">
                                    <p class="mb-0">Forgot your password? <?= anchor('auth/forgot-password', "Click here", 'class="text-warning"'); ?></p>
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