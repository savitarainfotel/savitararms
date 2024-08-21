<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<a data-bs-toggle="offcanvas" href="#bs-canvas-right" aria-controls="bs-canvas-right"
    class="bs-tooltip float-end m-2 mt-3" data-original-title="Custom Filter">
    <?= show_svg('filter'); ?>
</a>
<div class="offcanvas offcanvas-end" tabindex="-1" id="bs-canvas-right" aria-labelledby="bs-canvas-rightLabel">
    <header class="offcanvas-header p-3 bg-success overflow-auto">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <h4 class="d-inline-block text-light mt-1 mb-0 float-right">Filters</h4>
    </header>
    <div class="offcanvas-body custom-filter-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group">
                    <label for="client_id">Client</label>
                    <select name="client_id" id="client_id" class="client-list form-control f-required" multiple></select>
                </div>
            </div>
            <?php if(!empty($userList)){ ?>
            <div class="col-xl-12 mb-4">
                <div class="form-group">
                    <label for="user_id">User</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="">Select User</option>
                        <?php foreach($userList as $user){ ?>
                        <option value="<?= e_id($user->id); ?>">
                            <?= $user->first_name.' '.$user->last_name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php } ?>
            <div class="col-xl-12 mb-4">
                <div class="form-group">
                    <label for="from_date">Date From</label>
                    <input type="text" class="form-control flatpickr flatpickr-input active" id="from_date" name="from_date" readonly="readonly" />
                </div>
            </div>
            <div class="col-xl-12 mb-4">
                <div class="form-group">
                    <label for="to_date">Date To</label>
                    <input type="text" class="form-control flatpickr flatpickr-input active" id="to_date" name="to_date" readonly="readonly" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-custom-filter">Search</button>
                    <button type="button" class="btn btn-danger btn-reset-custom-filter">Reset Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>