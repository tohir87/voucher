<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="row-fluid" style="margin-bottom: 20px;">
    <div class="span12">

        <div class="row-fluid">
            <div class="span3">
                <div class="row-fluid">
                    <ul class="tiles">
                        <li class="lime high long dashboard_icon img-circle">
                            <a href="<?= site_url('/upload') ?>">
                                <span class="nopadding">
                                    <h5>Upload <br>
                                        <span style="font-size: 10px; padding-top: 10px;">
                                            <i>Upload new batch of PIN</i>
                                        </span>                                 
                                    </h5>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="span3">
                    <div class="row-fluid">
                        <ul class="tiles">
                            <li class="orange high long dashboard_icon img-circle">

                                <a href="<?= site_url('/batches') ?>">
                                    <span class="nopadding">
                                        <h5>Print Voucher</h5>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <?php
        $market_str = '';
        if (!empty($markets)):
            foreach ($markets as $market):
                $market_str .= "{$market->provider_name}, ";
            endforeach;
        endif;
        ?>
        <h3 class="lead" style="text-align: center; margin-bottom: 0px">Available Network Providers</h3>
        <div style="font-size: 1.0em; font-weight: bold; text-align: center">
            <?php echo rtrim($market_str, ', '); ?>
        </div>
    </div>
</div>
