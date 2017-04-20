<?php $path = $this->input->server('REQUEST_URI'); ?>
<ul class="nav nav-tabs" id="myTab">
    <li class="<?= strstr($path, 'setup/categories') ? 'active' : '' ?>">
        <a href="<?= site_url('setup/categories') ?>">Categories</a>
    </li>
<!--    <li class="<?= strstr($path, 'setup/sub_categories') ? 'active' : '' ?>">
        <a href="<?= site_url('setup/sub_categories') ?>" >Sub Categories</a>
    </li>-->
    <li class="<?= strstr($path, 'setup/sources') ? 'active' : '' ?>">
        <a href="<?= site_url('setup/sources') ?>" >Sources</a>
    </li>
    <li class="<?= strstr($path, 'setup/varieties') ? 'active' : '' ?>">
        <a href="<?= site_url('setup/varieties') ?>" >Varieties</a>
    </li>
    <li class="<?= strstr($path, 'setup/wholesale_metric') ? 'active' : '' ?>">
        <a href="<?= site_url('setup/wholesale_metric') ?>" >Wholesale Metric</a>
    </li>
    <li class="<?= strstr($path, 'setup/retail_metric') ? 'active' : '' ?>">
        <a href="<?= site_url('setup/retail_metric') ?>" >Retail Metric</a>
    </li>
    <li class="<?= strstr($path, 'setup/markets') ? 'active' : '' ?>">
        <a href="<?= site_url('setup/markets') ?>" >Markets</a>
    </li>
    <li class="<?= strstr($path, 'setup/products') ? 'active' : '' ?>">
        <a href="<?= site_url('setup/products') ?>" >Products</a>
    </li>
    <li class="<?= strstr($path, 'setup/remarks') ? 'active' : '' ?>">
        <a href="<?= site_url('/setup/remarks') ?>" >Remarks</a>
    </li>
</ul>
