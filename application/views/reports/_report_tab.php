<?php $path = $this->input->server('REQUEST_URI'); ?>
<ul class="nav nav-tabs" id="myTab">
    <li class="<?= strstr($path, '/report') ? 'active' : '' ?>">
        <a href="<?= site_url('/report') ?>">Reports</a>
    </li>
    <li class="<?= strstr($path, '/analytics') ? 'active' : '' ?>">
        <a href="<?= site_url('/analytics') ?>" >Analytics - Wholesale</a>
    </li>
    <li class="<?= strstr($path, '/retail-analytics') ? 'active' : '' ?>">
        <a href="<?= site_url('/retail-analytics') ?>" >Analytics - Retail</a>
    </li>
    <li class="<?= strstr($path, '/source-products') ? 'active' : '' ?>">
        <a href="<?= site_url('/source-products') ?>" >Analytics - Source/State Activity Per Market</a>
    </li>
</ul>
