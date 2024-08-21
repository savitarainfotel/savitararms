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
                    <div class="widget-content widget-content-area animated-underline-content mb-4">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td><?= $data['name']; ?></td>

                                    <td><b>Property domain</b></td>
                                    <td><?= $data['hosted_on']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-group mb-4">
                                    <label for="name">Name</label> <span class="text-danger">*</span>
                                    <input type="text" class="form-control f-required" id="name" name="name" value="<?= !empty($data['name']) ? $data['name'] : ''; ?>" required="" />
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