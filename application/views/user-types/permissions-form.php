<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<input type="hidden" name="u_type" value="<?= $u_type; ?>" />
<input type="hidden" name="u_team" value="<?= $u_team; ?>" />
<div id="iconsAccordion" class="accordion-icons accordion">
    <div class="row mb-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="col-md-12">
                <div class="form-group">
                    <table class="table mb-0" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>
                                    <div class="form-check form-check-primary form-check-inline">
                                        <input class="form-check-input checkall" type="checkbox" name="checkall" id="checkall">
                                    </div>
                                </th>
                                <th><label for="checkall"><strong>Module</strong></label></th>
                                <th><label for="checkall"><strong>Permissions</strong></label></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($accessList['mainMenus'] as $v): if(! $v->sub_menu && ! $v->accessList) continue; ?>
        <div class="card">
            <div class="card-header" id="accordion_<?= $v->id ?>">
                <section class="mb-0 mt-0">
                    <div role="menu" class="collapsed" data-bs-toggle="collapse"
                        data-bs-target="#iconAccordion-<?= $v->id ?>" aria-expanded="false"
                        aria-controls="iconAccordion-<?= $v->id ?>">
                        <div class="accordion-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4361ee" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <?= $v->s_name ?>
                        <div class="icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4361ee" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                    </div>
                </section>
            </div>
            <div id="iconAccordion-<?= $v->id ?>" class="collapse" aria-labelledby="accordion_<?= $v->id ?>" data-bs-parent="#iconsAccordion">
                <div class="card-body">
                    <?php if($v->sub_menu): ?>
                        
                    <?php endif ?>
                    <?php if ($v->accessList): ?>
                        <table class="table mb-0">
                            <tbody>
                                <?php foreach ($v->accessList as $v): $ops = explode(', ', $v->operations); ?>
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-primary form-check-inline">
                                                <input type="checkbox" class="form-check-input ischeck checkall" id="label_<?= $v->id ?>" data-id="<?= $v->id ?>">
                                            </div>
                                        </td>
                                        <td><label class="ischeck checkall" for="label_<?= $v->id ?>" data-id="<?= $v->id ?>"><?= $v->n_title ?></label></td>
                                        <td style="display: contents;">
                                            <?php foreach ($ops as $op): ?>
                                            <div class="form-check form-check-primary form-check-inline">
                                                &nbsp;
                                                <input class="form-check-input checkall isscheck_<?= $v->id ?>" id="permission_<?= $op.'_'.$v->id ?>" name="permissions[<?= $v->id ?>][]" type="checkbox" <?= check_current_permissions($v->n_name, $op, (d_id($u_type) ?? 0), (d_id($u_team) ?? 0)) ? 'checked=""' : ''; ?> value="<?= $op ?>" />
                                                &nbsp;
                                                <label for="permission_<?= $op.'_'.$v->id ?>" class="form-check-label"><?= ucfirst(str_replace('_', ' ', $op)) ?></label>
                                            </div>
                                            <?php endforeach ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>