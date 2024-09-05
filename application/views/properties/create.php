<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="layout-top-spacing">
    <div class="row">
        <div class="col-lg-12 col-12">
            <?= $this->breadcrumb->output(); ?>
        </div>
    </div>
    <?php $this->load->view($this->redirect.'/tabs'); ?>
    <?= form_open('', 'class="ajax-form"') ?>
        <div class="row layout-top-spacing">
            <div class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4> Property Information </h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group mb-4">
                                    <label for="name">Name</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control f-required" id="name" name="name" value="<?= !empty($data['name']) ? $data['name'] : ''; ?>" required="" />
                                </div>
                            </div>
                            <?php if(!$this->user->is_admin && !$this->user->is_super_admin) {
                                echo form_hidden('client_id', e_id($this->user->id));
                            } else { ?>
                            <div class="col-xl-4">
                                <div class="form-group mb-4">
                                    <label for="client_id">Client</label> <span class="text-danger">*</span>
                                    <select name="client_id" id="client_id" class="form-control tom-select" required="">
                                        <option value="">Select Client</option>
                                        <?php
                                        if(!empty($this->clientList)){
                                            foreach($this->clientList as $client){
                                                $selected = !empty($data['client_id']) && $data['client_id'] === $client['id'] ? 'selected' : '';
                                        ?>
                                            <option value="<?= e_id($client['id']) ?>" <?= $selected; ?>><?= $client['first_name'].' '.$client['last_name']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-xl-4">
                                <div class="form-group mb-4">
                                    <label for="hosted_on">Property domain</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control f-required" id="hosted_on" name="hosted_on" value="<?= !empty($data['hosted_on']) ? $data['hosted_on'] : ''; ?>" required="" />
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group mb-4">
                                    <label for="short_description">Short Description</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control f-required" id="short_description" name="short_description" value="<?= !empty($data['short_description']) ? $data['short_description'] : ''; ?>" required="" />
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group mb-4">
                                    <label for="long_description">Long Description</label> <span class="text-danger">*</span>
                                    <textarea id="long_description" name="long_description" class="form-control ckeditor-areas f-required" required=""><?= !empty($data['long_description']) ? $data['long_description'] : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2">
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?= form_close() ?>
</div>