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
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <table class="table dt-table-hover datatable style-3" style="width:100%">
                    <thead>
                        <tr>
                            <th class="no-content">#</th>
                            <th class="no-content">Invite</th>
                            <th>Property</th>
                            <th>Status</th>
                            <th>Platform</th>
                            <th>Rating</th>
                            <th>Comments</th>
                            <th>Created on</th>
                            <?= $this->user->is_admin || $this->user->is_super_admin ? '<th class="no-content">Client</th>' : ''; ?>
                            <?= $this->user->is_admin || $this->user->is_super_admin ? '<th class="no-content">Agent</th>' : ''; ?>
                            <th class="no-content">Resend</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Invite</th>
                            <th>Property</th>
                            <th>Status</th>
                            <th>Platform</th>
                            <th>Rating</th>
                            <th>Comments</th>
                            <th>Created on</th>
                            <?= $this->user->is_admin || $this->user->is_super_admin ? '<th>Client</th>' : ''; ?>
                            <?= $this->user->is_admin || $this->user->is_super_admin ? '<th>Agent</th>' : ''; ?>
                            <th class="no-content">Resend</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>