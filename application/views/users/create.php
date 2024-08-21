<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="layout-top-spacing">
    <div class="row layout-top-spacing layout-spacing">
        <div class="col-lg-12 col-12 layout-spacing">
            <?= $this->breadcrumb->output(); ?>
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4> <?= $title; ?> </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <?= form_open('', 'class="ajax-form"') ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-4">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control f-required" id="first_name" name="first_name" value="<?= !empty($data['first_name']) ? $data['first_name'] : ''; ?>" required="" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-4">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control f-required" id="last_name" name="last_name" value="<?= !empty($data['last_name']) ? $data['last_name'] : ''; ?>" required="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control f-required callback-check" id="email" name="email" value="<?= !empty($data['email']) ? $data['email'] : ''; ?>" required="" data-href="users/verify-email" data-existing="<?= !empty($data['id']) ? e_id($data['id']) : ''; ?>" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-4">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control f-required callback-check" id="mobile" name="mobile" value="<?= !empty($data['mobile']) ? $data['mobile'] : ''; ?>" required="" maxlength="10" data-href="users/verify-mobile" data-existing="<?= !empty($data['id']) ? e_id($data['id']) : ''; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-4">
                                    <label for="type">User type</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">Select User Type</option>
                                        <?php
                                        if(!empty($userTypeList)){
                                            foreach($userTypeList as $type){
                                        ?>
                                            <option value="<?= e_id($type['id']) ?>" <?= !empty($data['type']) && $type['id'] == $data['type'] ? 'selected' : ''; ?>><?= $type['type_name']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" <?= $this->uri->segment(2) === 'create' ? 'required=""' : ''; ?> />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group mb-4">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" <?= $this->uri->segment(2) === 'create' ? 'required=""' : ''; ?> />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2">
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>