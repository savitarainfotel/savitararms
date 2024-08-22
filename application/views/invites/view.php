<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <?= $this->breadcrumb->output(); ?>
        <?php $this->load->view($this->redirect.'/tabs'); ?>
        <div class="statbox widget box box-shadow layout-top-spacing">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                        <h4> <?php echo $title; ?> </h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area animated-underline-content p-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>Name</b></td>
                            <td><?= $data['name']; ?></td>

                            <td><b>Email</b></td>
                            <td><?= $data['email']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Mobile</b></td>
                            <td><?= $data['phone']; ?></td>

                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>