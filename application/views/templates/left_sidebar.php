<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div id="left">
    <!--    <div class="subnav">
            <div class="subnav-title" style="white-space: normal;">
                <span style="white-space: initial; width: 100%; display: block "><?php echo $company_name; ?></span>
            </div>
        </div>-->
    <?php
    $module = $this->uri->segment(1);
    if ($module === 'admin' || $module === 'user' && $this->user_auth_lib->get('access_level') != USER_TYPE_SUBSCRIBER) :
        ?>
        <div class="subnav">
            <div class="subnav-title">
                <a href="#" class="toggle-subnav"><i class="icon-angle-down"></i><span>Administration</span></a>
            </div>
            <ul class="subnav-menu" style="display: block;">
                <?php if ($this->user_auth_lib->is_super_admin()): ?>
                    <li><a href="<?= site_url('admin/users') ?>">Users</a></li>
                    <li><a href="<?= site_url('admin/user_types') ?>">User Types</a></li>
                    <li><a href="<?= site_url('/subscription/subscribers') ?>">Subscribers</a></li>
                    <li><a href="<?= site_url('/access_control') ?>">Access Control</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php elseif ($module === 'setup' && $this->user_auth_lib->have_perm(PERM_SETUP)): ?>
        <div class="subnav">
            <div class="subnav-title">
                <a href="#" class="toggle-subnav"><i class="icon-angle-down"></i><span>Setup</span></a>
            </div>
            <ul class="subnav-menu" style="display: block;">
                <li><a href="<?= site_url('setup/categories') ?>">Categories</a></li>
                <li><a href="<?= site_url('setup/sources') ?>">Sources</a></li>
                <li><a href="<?= site_url('setup/varieties') ?>">Varieties</a></li>
                <li><a href="<?= site_url('setup/wholesale_metric') ?>">Wholesale Metric</a> </li>
                <li> <a href="<?= site_url('setup/retail_metric') ?>">Retail Metric</a> </li>
                <li> <a href="<?= site_url('setup/markets') ?>">Markets</a> </li>
                <li> <a href="<?= site_url('setup/products') ?>">Products</a> </li>
                <li> <a href="<?= site_url('setup/remarks') ?>">Remarks</a> </li>
                 <?php if ($this->user_auth_lib->have_perm('admin:traders')): ?>
                    <li><a href="<?= site_url('admin/traders') ?>">Traders</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php elseif ($module === 'market' && $this->user_auth_lib->get('access_level') != USER_TYPE_SUBSCRIBER): ?>
        <div class="subnav">
            <div class="subnav-title">
                <a href="#" class="toggle-subnav"><i class="icon-angle-down"></i><span>Market</span></a>
            </div>
            <ul class="subnav-menu" style="display: block;">
                <li><a href="<?= site_url('/setup/products') ?>">Prices</a></li>
                <?php if ($this->user_auth_lib->have_perm('market:pending_approval')): ?>
                    <li><a href="<?= site_url('/market/pending_approval') ?>">Pending Approvals</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php elseif (($module === 'report' || $module == 'analytics') && $this->user_auth_lib->get('access_level') != USER_TYPE_SUBSCRIBER): ?>
        <div class="subnav">
            <div class="subnav-title">
                <a href="#" class="toggle-subnav"><i class="icon-angle-down"></i><span>Market</span></a>
            </div>
            <ul class="subnav-menu" style="display: block;">
                <?php if ($this->user_auth_lib->have_perm('report:analytics')): ?>
                    <li><a href="<?= site_url('/report') ?>">Reports</a></li>
                    <li><a href="<?= site_url('/analytics') ?>">Analytics</a></li>
                <?php endif; ?>
                <?php if ($this->user_auth_lib->is_super_admin()): ?>
                    <li><a href="<?= site_url('/report/exemption') ?>">Exemption</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if ($this->user_auth_lib->get('access_level') == USER_TYPE_SUBSCRIBER): ?>
        <div class="subnav">
            <div class="subnav-title">
                <a href="#" class="toggle-subnav"><i class="icon-angle-down"></i><span>Quick Links</span></a>
            </div>
            <ul class="subnav-menu" style="display: block;">
                <li><a href="<?= site_url('/subscriber/account') ?>">My Account</a></li>
                <li><a href="<?= site_url('/report') ?>">Reports</a></li>
                <li><a href="<?= site_url('/analytics') ?>">Wholesale Analytics</a></li>
                <li><a href="<?= site_url('/retail-analytics') ?>">Retail Analytics</a></li>
                <li><a href="<?= site_url('/source-products') ?>">Products per source</a></li>
            </ul>
        </div>
    <?php endif; ?>
</div>