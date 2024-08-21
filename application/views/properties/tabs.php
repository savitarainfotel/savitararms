<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(!empty($data)): ?>
    <div class="row mb-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link <?= activeNavigation(PROPERTIES, ['view'], 'child_nav'); ?> tab-redirect" data-bs-toggle="tab" href="<?= site_url($this->redirect.'/view/'.e_id($data['id'])) ?>">
                    <?= show_svg('user'); ?> Overview</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link <?= activeNavigation(PROPERTIES, ['edit'], 'child_nav'); ?> tab-redirect" data-bs-toggle="tab" href="<?= site_url($this->redirect.'/edit/'.e_id($data['id'])) ?>">
                    <?= show_svg('edit', 'currentColor'); ?> Edit</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link <?= activeNavigation(PROPERTIES, ['rating_settings'], 'child_nav'); ?> tab-redirect" data-bs-toggle="tab" href="<?= site_url($this->redirect.'/rating-settings/'.e_id($data['id'])) ?>">
                    <?= show_svg('clipboard', 'currentColor'); ?> Rating settings</button>
                </li>
            </ul>
        </div>
    </div>
<?php endif; ?>