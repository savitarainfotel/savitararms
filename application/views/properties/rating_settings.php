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
                        <?php if(!empty($rating_platforms)): foreach($rating_platforms as $platform): $setting = $platform['setting']; ?>
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="form-group mb-4">
                                    <label for="platform_<?= e_id($platform['id']) ?>">Platform</label>
                                    <input type="text" class="form-control text-dark" id="platform_<?= e_id($platform['id']) ?>" name="settings[<?= e_id($platform['id']) ?>][platform]" value="<?= $platform['platform']; ?>" readonly="" />
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group mb-4">
                                    <label for="status_<?= e_id($platform['id']) ?>">Status</label><br>
                                    <div class="form-check form-check-success form-check-inline mt-2">
                                        <input class="form-check-input quote-input" type="radio" name="settings[<?= e_id($platform['id']) ?>][status]" id="enabled_<?= e_id($platform['id']) ?>" checked="" value="1" />
                                        <label class="form-check-label text-success" for="enabled_<?= e_id($platform['id']) ?>">
                                            Enabled
                                        </label>
                                    </div>
                                    <div class="form-check form-check-danger form-check-inline">
                                        <input class="form-check-input quote-input" type="radio" name="settings[<?= e_id($platform['id']) ?>][status]" id="disabled_<?= e_id($platform['id']) ?>" value="0" <?= empty($setting['status']) ? 'checked' : ''; ?> />
                                        <label class="form-check-label text-danger" for="disabled_<?= e_id($platform['id']) ?>">
                                            Disabled
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group mb-4">
                                    <label for="min_rating_<?= e_id($platform['id']) ?>">Min Rating</label>
                                    <select name="settings[<?= e_id($platform['id']) ?>][min_rating]" id="min_rating_<?= e_id($platform['id']) ?>" class="form-control">
                                        <option value="1" <?= !empty($setting['min_rating']) && $setting['min_rating'] == 1 ? 'selected' : ''; ?>>1</option>
                                        <option value="2" <?= !empty($setting['min_rating']) && $setting['min_rating'] == 2 ? 'selected' : ''; ?>>2</option>
                                        <option value="3" <?= !empty($setting['min_rating']) && $setting['min_rating'] == 3 ? 'selected' : ''; ?>>3</option>
                                        <option value="4" <?= !empty($setting['min_rating']) && $setting['min_rating'] == 4 ? 'selected' : ''; ?>>4</option>
                                        <option value="5" <?= !empty($setting['min_rating']) && $setting['min_rating'] == 5 ? 'selected' : ''; ?>>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group mb-4">
                                    <label for="rating_url_<?= e_id($platform['id']) ?>">Rating URL</label>
                                    <input type="text" class="form-control" id="rating_url_<?= e_id($platform['id']) ?>" name="settings[<?= e_id($platform['id']) ?>][rating_url]" value="<?= !empty($setting['rating_url']) ? $setting['rating_url'] : ''; ?>" />
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="row">
                            <div class="col-xl-2">
                                <button type="submit" class="btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="alert alert-danger">No rating platform available.</div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    <?= form_close() ?>
</div>