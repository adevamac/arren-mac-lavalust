<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
?>


<!-- sidebar.php -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Barangay Portal</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= isActive('dashboard', $current_page); ?>">
        <a class="nav-link" href="<?= site_url('dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item <?= isActive('profiling', $current_page); ?>">
        <a class="nav-link" href="<?= site_url('profiling'); ?>">
            <i class="fas fa-users"></i>
            <span>Profiling</span>
        </a>
    </li>
    <li class="nav-item <?= isActive('barangay_info', $current_page); ?>">
        <a class="nav-link" href="<?= site_url('barangay_info'); ?>">
            <i class="fas fa-cogs"></i>
            <span>Barangay Info</span>
        </a>
    </li>
    <li class="nav-item <?= isActive('officials', $current_page); ?>">
        <a class="nav-link" href="<?= site_url('officials'); ?>">
            <i class="fas fa-users-cog"></i>
            <span>Officials</span>
        </a>
    </li>
    <li class="nav-item <?= isActive('requests', $current_page); ?>">
        <a class="nav-link" href="<?= site_url('all_requests'); ?>">
            <i class="far fa-file-alt"></i>
            <span>Requests</span>
        </a>
    </li>
</ul>