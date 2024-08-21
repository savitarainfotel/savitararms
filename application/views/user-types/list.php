<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row layout-top-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <?php echo $this->breadcrumb->output(); ?>
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                        <h4> <?php echo $title; ?> </h4>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                        <?php if(user_privilege_register(USER_TYPES, 'create')): ?>
                            <a href="<?php echo site_url($this->redirect.'/create'); ?>" class="btn btn-primary m-2 float-end"><i class="far fa-plus"></i> Add New User Type</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <table class="table dt-table-hover datatable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="target">#</th>
                            <th>Name</th>
                            <th class="target">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="target">#</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="permissionsModalLabel"  id="permissionsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-lg-max modal-dialog-centered" role="document">
        <div class="modal-content">
            <?= form_open($this->redirect.'/save-permissions', 'id="save-permissions-form"'); ?>
                <div class="modal-header">
                    <h4 class="modal-title text-dark">Assign permissions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <?= show_svg('delete'); ?>
                    </button>
                </div>
                <div class="modal-body" id="permissions-form"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn btn-danger" data-bs-dismiss="modal"><i class="far fa-times"></i> Discard</button>
                    <button type="submit" class="btn btn-primary" onclick="savePermissions();"><i class="far fa-save"></i> Save changes</button>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>