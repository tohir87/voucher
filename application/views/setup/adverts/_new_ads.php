<div class="modal hide fade modal-full" id="new_ads" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add New Advert</h4>
    </div>

    <form name="frmads" id="frmads" method="post" enctype="multipart/form-data" action="" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div class="control-group">
                <label class="control-label">Ad Name</label>
                <div class="controls">
                    <input required type="text" name="ad_name" id="ad_name" class="input-large" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Client Name</label>
                <div class="controls">
                    <input required type="text" name="client_name" id="client_name" class="input-large" />
                </div>
            </div>
            <div class="control-group">
                <label for="group_id" class="control-label">Location</label>
                <div class="controls">
                    <select required name="location_id" id="location_id" class="select2-me input-large">
                        <option value="" selected>Select Location</option>
                        <?php
                        if (!empty($locations)):
                            foreach ($locations as $value => $location):
                                ?>
                                <option value="<?= $value; ?>"><?= $location; ?></option>
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
                    <input required type="text" name="start_date" id="start_date" class="datepick" />
                    To:
                    <input required type="text" name="end_date" id="end_date" class="datepick" />
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
                    <input type="text" name="ad_link" id="ad_link" class="input-xxlarge" />
                </div>
            </div>
        </div>

        <div class="modal-footer" id="footer_modal">
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>