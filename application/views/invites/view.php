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

                            <td><b>Mobile</b></td>
                            <td><?= !empty($data['phone']) ? $data['phone'] : '-'; ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php if(user_privilege_register(INVITES, 'send_invites')): ?>
                <?= form_open($this->redirect.'/send-invites', 'class="ajax-form"', ['invite_id' => e_id($data['id'])]) ?>
                    <div class="widget-content widget-content-area animated-underline-content p-4">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h5 class="text-dark">Send Invite</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group mb-4">
                                    <label for="property_ids">Properties</label> <span class="text-danger">*</span>
                                    <select name="property_ids[]" id="property_ids" class="form-control tom-select" required="" multiple="">
                                        <?php
                                        if(!empty($properties)){
                                            foreach($properties as $property){
                                        ?>
                                            <option value="<?= e_id($property['id']) ?>"><?= $property['name'].' - '.$property['hosted_on']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2">
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                    </div>
                <?= form_close() ?>
                <div class="widget-content widget-content-area animated-underline-content mt-4 p-4">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h5 class="text-dark">Sent Invites</h5>
                        </div>
                    </div>
                    <table class="table dt-table-hover datatable style-3" style="width:100%">
                        <thead>
                            <tr>
                                <th class="no-content">#</th>
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
                                <th>Property</th>
                                <th>Status</th>
                                <th>Platform</th>
                                <th>Rating</th>
                                <th>Comments</th>
                                <th>Created on</th>
                                <?= $this->user->is_admin || $this->user->is_super_admin ? '<th>Client</th>' : ''; ?>
                                <?= $this->user->is_admin || $this->user->is_super_admin ? '<th>Agent</th>' : ''; ?>
                                <th>Resend</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>