<?php $path = $this->input->server('REQUEST_URI'); ?>
<ul class="nav nav-tabs" id="myTab">
    <li class="<?= strstr($path, 'admin/users') ? 'active' : '' ?>">
        <a href="<?= site_url('admin/users') ?>">Users</a>
    </li>
    <li class="<?= strstr($path, 'admin/user_types') ? 'active' : '' ?>">
        <a href="<?= site_url('admin/user_types') ?>" >User Types</a>
    </li>
</ul>
