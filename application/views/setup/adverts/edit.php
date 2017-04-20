<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <a class="btn btn-warning" href="<?= site_url('/adverts'); ?>">
            <i class="icons icon-chevron-left"></i> Back
        </a>
        <h1>Edit Advert</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="box">
    <div class="box-content nopadding">

        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    ...
                                </h3>

                            </div>
                            <div class="box-content-padless">
                                <form name="frmads" id="frmads" method="post" enctype="multipart/form-data" action="" class="form-horizontal form-bordered">

                                    <div class="control-group">
                                        <label class="control-label">Ad Name</label>
                                        <div class="controls">
                                            <input required type="text" name="ad_name" id="ad_name" class="input-large" value="<?= $ad_info->ad_name; ?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Client Name</label>
                                        <div class="controls">
                                            <input required type="text" name="client_name" id="client_name" class="input-large" value="<?= $ad_info->client_name; ?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="group_id" class="control-label">Location</label>
                                        <div class="controls">
                                            <select required name="location_id" id="location_id" class="select2-me input-large">
                                                <option value="" selected>Select Location</option>
                                                <?php
                                                if (!empty($locations)):
                                                    $sel = '';
                                                    foreach ($locations as $value => $location):
                                                        if ($value == $ad_info->location_id):
                                                            $sel = 'selected';
                                                        else:
                                                            $sel = '';
                                                        endif;
                                                        ?>
                                                        <option value="<?= $value; ?>" <?= $sel; ?>><?= $location; ?></option>
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Duration</label>
                                        <div class="controls"> From:
                                            <input required type="text" name="start_date" id="start_date" class="datepick" value="<?= date('d-m-Y', strtotime($ad_info->start_date)); ?>" />
                                            To:
                                            <input required type="text" name="end_date" id="end_date" class="datepick" value="<?= date('d-m-Y', strtotime($ad_info->end_date)); ?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Ad Image</label>
                                        <div class="controls">
                                            <input type="file" name="userfile" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Ad Url</label>
                                        <div class="controls">
                                            <input type="text" name="ad_link" id="ad_link" class="input-xxlarge"  value="<?= $ad_info->ad_link; ?>" />
                                        </div>
                                    </div>


                                    <div class="modal-footer" id="footer_modal">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>