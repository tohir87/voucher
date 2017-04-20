<?php $path = $this->input->server('REQUEST_URI'); ?>
<ul class="nav nav-tabs" id="myTab">
    <li class="<?= strstr($path, 'subscription/subscribers') ? 'active' : '' ?>">
        <a href="<?= site_url('/subscription/subscribers') ?>">Products</a>
    </li>
    <li class="<?= strstr($path, 'subscription/types') ? 'active' : '' ?>">
        <a href="<?= site_url('/subscription/types') ?>" >Markets</a>
    </li>
</ul>
