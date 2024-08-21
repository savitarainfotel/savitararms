<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<?= link_tag('assets/src/plugins/src/apex/apexcharts.css'); ?>
<?= link_tag('assets/src/assets/css/light/dashboard/dash_1.css'); ?>
<?= link_tag('assets/src/assets/css/dark/dashboard/dash_1.css'); ?>
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

<div class="row layout-top-spacing">
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <?php echo $this->breadcrumb->output(); ?>
        <div class="widget widget-card-five">
            <div class="widget-content">
                <div class="account-box">
                    <div class="info-box">
                        <div class="icon">
                            <span>
                                <?= img('assets/images/client.png'); ?>
                            </span>
                        </div>
                        <div class="balance-info">
                            <h6>Total Clients</h6>
                            <p><?= number_format($clients); ?></p>
                        </div>
                    </div>
                    <div class="card-bottom-section">
                        <div></div>
                        <?= anchor('users', 'View All'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>