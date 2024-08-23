<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    $currentController = strtolower($this->router->fetch_class());
?>
<!doctype html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= !empty($title) ? $title .' | '. APP_NAME : APP_NAME ?></title>
        <!-- Favicon -->
        <?= link_tag('assets/images/favicon.png'.ASSET_VERSION, 'icon', 'image/png') ?>
        <?= link_tag('assets/images/favicon.png'.ASSET_VERSION, 'apple-touch-icon', 'image/png') ?>

        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" />

        <?= link_tag('assets/layouts/vertical-light-menu/css/light/loader.css'); ?>
        <?= link_tag('assets/layouts/vertical-light-menu/css/dark/loader.css'); ?>

        <!-- snackbar -->
        <?= link_tag('assets/src/plugins/src/notification/snackbar/snackbar.min.css'.ASSET_VERSION); ?>
        <?= link_tag('assets/src/plugins/css/light/notification/snackbar/custom-snackbar.css'.ASSET_VERSION); ?>
        <?= link_tag('assets/src/plugins/css/dark/notification/snackbar/custom-snackbar.css'.ASSET_VERSION); ?>
        <!-- font awesome -->
        <?= link_tag('assets/src/plugins/font-icons/fontawesome/css/regular.css'); ?>
        <?= link_tag('assets/src/plugins/font-icons/fontawesome/css/fontawesome.css'); ?>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <?= link_tag('assets/src/bootstrap/css/bootstrap.min.css'); ?>
        
        <?= link_tag('assets/layouts/vertical-light-menu/css/light/plugins.css'); ?>
        <?= link_tag('assets/layouts/vertical-light-menu/css/dark/plugins.css'); ?>
        <?= link_tag('assets/src/assets/css/light/pages/error/error.css'.ASSET_VERSION); ?>
        <?= link_tag('assets/src/assets/css/dark/pages/error/error.css'.ASSET_VERSION); ?>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <?php if(in_array($currentController, ['login', 'forgot_password', 'user_ratings'])) {
            echo link_tag('assets/src/assets/css/light/authentication/auth-boxed.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/dark/authentication/auth-boxed.css'.ASSET_VERSION);
        } else {
            echo link_tag('assets/src/plugins/src/sweetalerts2/sweetalerts2.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/light/scrollspyNav.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/css/light/sweetalerts2/custom-sweetalert.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/dark/scrollspyNav.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/css/dark/sweetalerts2/custom-sweetalert.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/src/tomSelect/tom-select.default.min.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/css/light/tomSelect/custom-tomSelect.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/css/dark/tomSelect/custom-tomSelect.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/src/flatpickr/flatpickr.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/css/light/flatpickr/custom-flatpickr.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/css/dark/flatpickr/custom-flatpickr.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/light/forms/switches.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/dark/forms/switches.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/light/components/modal.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/dark/components/modal.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/light/components/accordions.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/dark/components/accordions.css'.ASSET_VERSION);
            echo link_tag('assets/src/plugins/src/animate/animate.css'.ASSET_VERSION);

            echo link_tag('assets/src/assets/css/light/components/tabs.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/dark/components/tabs.css'.ASSET_VERSION);
            echo link_tag('assets/src/assets/css/multi-form.css'.ASSET_VERSION);
        } ?>

        <?php if(!empty($datatables)) { ?>
            <?= link_tag('assets/src/plugins/src/table/datatable/datatables.css'.ASSET_VERSION); ?>
            <?= link_tag('assets/src/plugins/css/light/table/datatable/dt-global_style.css'.ASSET_VERSION); ?>
            <?= link_tag('assets/src/plugins/css/light/table/datatable/custom_dt_custom.css'.ASSET_VERSION); ?>
            <?= link_tag('assets/src/plugins/css/dark/table/datatable/dt-global_style.css'.ASSET_VERSION); ?>
            <?= link_tag('assets/src/plugins/css/dark/table/datatable/custom_dt_custom.css'.ASSET_VERSION); ?>
        <?php } ?>
    </head>
    <body <?= !empty($errorPage) ? 'class="error text-center"' : ''; ?> <?= !empty($authPage) ? 'class="form"' : ''; ?> <?= empty($errorPage) && empty($authPage) ? 'class="layout-boxed"' : ''; ?>>
        <!-- BEGIN LOADER -->
        <div id="load_screen"> 
            <div class="loader">
                <div class="loader-content">
                    <div class="spinner-grow align-self-center"></div>
                </div>
            </div>
        </div>
        <!--  END LOADER -->

        <?php if(!in_array($currentController, ['login', 'forgot_password', 'user_ratings'])) {
            $this->load->view('includes/header');
            echo '<div class="main-container" id="container">
                    <div class="overlay"></div>
                    <div class="cs-overlay"></div>
                    <div class="search-overlay"></div>';
                        
            $this->load->view('includes/sidebar');

            echo '<div id="content" class="main-content"><div class="layout-px-spacing"><div class="middle-content container-xxl p-0">';
        } 
        
        echo $contents;
        
        if(!in_array($currentController, ['login', 'forgot_password', 'user_ratings'])) { ?>
                            <div class="footer-wrapper">
                                <div class="footer-section f-section-1">
                                    <p class="">Copyright © <?php echo date('Y'); ?> <a target="_blank" href="<?= site_url(); ?>"><?= APP_NAME; ?></a>, All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="generalModalLabel"  id="generalModal" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-lg-max modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-dark"></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <?= show_svg('delete'); ?>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn btn-danger" data-bs-dismiss="modal"><i class="far fa-times"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?= script("assets/src/plugins/src/global/vendors.min.js".ASSET_VERSION); ?>
        <?= script("assets/layouts/vertical-light-menu/loader.js".ASSET_VERSION); ?>
        <?= script("assets/src/bootstrap/js/bootstrap.bundle.min.js".ASSET_VERSION); ?>
        <?= script("assets/src/plugins/src/notification/snackbar/snackbar.min.js".ASSET_VERSION); ?>

        <?php if(!in_array($currentController, ['login', 'forgot_password', 'user_ratings'])) {
            echo script("assets/src/plugins/src/global/vendors.min.js".ASSET_VERSION);
            echo script("assets/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js".ASSET_VERSION);
            echo script("assets/src/plugins/src/mousetrap/mousetrap.min.js".ASSET_VERSION);
            echo script("assets/src/plugins/src/waves/waves.min.js".ASSET_VERSION);
            echo script("assets/layouts/vertical-light-menu/app.js".ASSET_VERSION);
            echo script("assets/src/plugins/src/highlight/highlight.pack.js".ASSET_VERSION);
            echo script("assets/src/assets/js/scrollspyNav.js".ASSET_VERSION);
            echo script("assets/src/plugins/src/sweetalerts2/sweetalerts2.min.js".ASSET_VERSION);
            echo script("assets/src/assets/js/custom.js".ASSET_VERSION);
            echo script('assets/src/plugins/src/tomSelect/tom-select.base.js'.ASSET_VERSION);
            echo script('assets/src/plugins/src/flatpickr/flatpickr.js'.ASSET_VERSION);
            echo script('assets/src/assets/js/apps/notes.js'.ASSET_VERSION);
            echo script('assets/src/plugins/src/ckeditor/ckeditor.js'.ASSET_VERSION);
        } ?>

        <?php if(!empty($validate)): ?>
            <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
        <?php endif; ?>

        <?= form_hidden('showMessage', $this->session->showMessage); ?>
        <?= form_hidden('base_url', site_url()); ?>
        <?= form_hidden('csrf_hash', $this->security->get_csrf_hash()); ?>

        <?php if(!empty($datatables)) {
            echo script("assets/src/plugins/src/table/datatable/datatables.js".ASSET_VERSION);
            echo form_hidden('dataTableUrl', site_url($datatable));
            echo form_hidden('data-export', 0);
            echo form_hidden('status', isset($status) ? $status : 0);
        } ?>
        
        <?= script("assets/js/script.js".ASSET_VERSION); ?>
    </body>
</html>