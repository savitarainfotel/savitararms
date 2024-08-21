<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-text">
                    <a href="<?= site_url('dashboard'); ?>" class="nav-link"> <?= APP_NAME; ?> </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu <?= activeNavigation('dashboard', '', 'menu_li'); ?>">
                <a href="<?= site_url(); ?>" aria-expanded="<?= activeNavigation('dashboard', '', 'expanded'); ?>" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <?php if(user_privilege_register(PROPERTIES)): ?>
            <li class="menu <?php echo activeNavigation(PROPERTIES, ['index', 'create', 'view', 'edit'], 'menu_li'); ?>">
                <a href="<?php echo site_url(PROPERTIES); ?>" aria-expanded="<?php echo activeNavigation(PROPERTIES, '', 'expanded'); ?>" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Properties</span>
                    </div>
                </a>
            </li>
            <?php endif ?>
            <?php if(user_privilege_register(CLIENTS)): ?>
            <li class="menu <?php echo activeNavigation(CLIENTS, ['index', 'create', 'view', 'edit'], 'menu_li'); ?>">
                <a href="<?php echo site_url(CLIENTS); ?>" aria-expanded="<?php echo activeNavigation(CLIENTS, '', 'expanded'); ?>" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Clients</span>
                    </div>
                </a>
            </li>
            <?php endif ?>
            <?php if(user_privilege_register(USER_TYPES)): ?>
            <li class="menu <?php echo activeNavigation(USER_TYPES, ['index', 'create', 'view', 'edit'], 'menu_li'); ?>">
                <a href="<?php echo site_url('user-types'); ?>" aria-expanded="<?php echo activeNavigation(USER_TYPES, '', 'expanded'); ?>" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>User Type</span>
                    </div>
                </a>
            </li>
            <?php endif ?>
        </ul>
    </nav>
</div>
<!--  END SIDEBAR  -->