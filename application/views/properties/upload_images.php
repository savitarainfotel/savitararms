<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="layout-top-spacing">
    <div class="row">
        <div class="col-lg-12 col-12">
            <?= $this->breadcrumb->output(); ?>
        </div>
    </div>
    <?php $this->load->view($this->redirect.'/tabs'); ?>
    <div class="row layout-top-spacing">
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4> Property Images </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <?php $images = !empty($data['images']) ? json_decode($data['images'], true) : []; for ($i=1; $i <= 3; $i++) { ?>
                            <div class="col-xl-4">
                                <?= form_open('', 'class="ajax-form"', ['image' => $i]) ?>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="form-group mb-4">
                                                <label for="image_<?= $i ?>">Property image <?= $i ?></label> <span class="text-danger">*</span>
                                                <input class="form-control file-upload-input f-required" type="file" id="image_<?= $i ?>" name="image_<?= $i ?>" accept="image/png, image/jpg, image/jpeg" />
                                            </div>
                                        </div>
                                        <?php if(!empty($images[$i]) && is_file($this->path.$images[$i])): ?>
                                            <div class="col-xl-4 mb-4">
                                                <?= img($this->path.$images[$i], '', 'class="col-xl-12" height="100"') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <button type="submit" class="btn btn-primary w-100">Save</button>
                                        </div>
                                    </div>
                                <?= form_close() ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>