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
                                    <label for="type_name">Name</label>
                                    <input type="text" class="form-control f-required" id="type_name" name="type_name" value="<?= !empty($data['type_name']) ? $data['type_name'] : ''; ?>" />
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