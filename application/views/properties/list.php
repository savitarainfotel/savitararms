<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <?php echo $this->breadcrumb->output(); ?>
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                        <h4> <?php echo $title; ?> </h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                        <a href="<?php echo site_url($this->redirect.'/create'); ?>" class="btn btn-primary m-2 float-end"><i class="far fa-plus"></i> Add New Property</a>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <table class="table dt-table-hover datatable style-3" style="width:100%">
                    <thead>
                        <tr>
                            <th class="no-content">#</th>
                            <th>Name</th>
                            <th>Domain</th>
                            <?= $this->user->is_admin || $this->user->is_super_admin ? '<th>Client</th>' : ''; ?>
                            <th>Created on</th>
                            <th class="no-content">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Domain</th>
                            <?= $this->user->is_admin || $this->user->is_super_admin ? '<th>Client</th>' : ''; ?>
                            <th>Created on</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>