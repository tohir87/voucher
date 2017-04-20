<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<div id="navigation">
    <div class="container-fluid">
        <a href="<?php echo $dashboard_url; ?>" id="brand">PUTIN 1.0 <span style="font-size: 10px; font-weight: bold; color: #ffdf00">beta</span></a>
        <ul class='main-nav'>
            <li class=''>
                <a href="<?= site_url('/admin/dashboard') ?>">
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if ($this->user_auth_lib->have_perm('setup:categories')): ?>
                <li>
                    <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                        <span>Setup</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= site_url('setup/providers') ?>">Providers</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
           
            <li><a href="#">Reports &amp; Analytics</a></li>
            
            <li>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span><?= ucfirst($display_name); ?></span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?= site_url('/user/change_password') ?>">Change Password</a></li>
                    <?php if ($this->user_auth_lib->is_subscriber()): ?>
                        <li><a href="<?= site_url('/subscriber/account') ?>">My Account</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo $logout_url; ?>">Sign out</a></li>
                </ul>
            </li>

        </ul>
       


        <div class="user" style="float: right;">
            <?php
            if (ENVIRONMENT == 'development'):
                if (!$this->user_auth_lib->is_super_admin() && !$this->user_auth_lib->is_subscriber()):
                    ?>
                    <ul class="main-nav" style="float: right;">
                        <li style="background: #2c5e7b; max-height: 40px;">
                            <a href="#" class='dropdown-toggle' data-toggle="dropdown" style="max-height: 20px;"> 

                                <span title="<?= $this->user_auth_lib->get('last_name') ?>" style="max-width: 100px;
                                      white-space: nowrap; overflow: hidden; display: inline-block;">
                                    <i class="glyphicon-shopping_bag" style="display: inline-block;"></i> Switch Market
                                </span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <?php
                                if (!empty($user_markets)):
                                    foreach ($user_markets as $mkt):
                                        ?>
                                        <li>
                                            <a href="#">
                                                <?= $mkt->market_name ?>
                                            </a>
                                        </li>
                                        <?php
                                    endforeach;
                                endif;
                                ?>

                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>
        </div>


    </div>
</div>
