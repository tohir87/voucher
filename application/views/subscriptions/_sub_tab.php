<?php $path = $this->input->server('REQUEST_URI'); ?>
<ul class="nav nav-tabs" id="myTab">
    <li class="<?= strstr($path, 'subscription/subscribers') ? 'active' : '' ?>">
        <a href="<?= site_url('/subscription/subscribers') ?>">Subscribers</a>
    </li>
    <li class="<?= strstr($path, 'subscription/config') ? 'active' : '' ?>">
        <a href="<?= site_url('/subscription/config') ?>" >Configurations</a>
    </li>
</ul>
