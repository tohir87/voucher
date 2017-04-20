<style>
    .control-group {
        padding:15px !important;
    }
    h4, h5 {
        padding-left:15px;
    }
</style>
<div class="box">
    <div class="page-header">
        <div class="pull-left">
            <a href="<?= $this->input->server('HTTP_REFERER'); ?>" class="btn btn-warning"> <i class="icons icon-chevron-left"></i> Back</a>
            <h1>Edit Product Image [<?= ucfirst($product_name); ?>]</h1>
        </div>
    </div>
    
    <?= show_notification(); ?>
    <?php 
    if (!empty($product_image)) {
        $existing_pic = $product_image->image_url;
    } else {
        $existing_pic = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';
    }
    ?>
    <div class="box-content-padless">
        <form action="" method="POST" class="form-horizontal form-wizard form-wysiwyg form-striped" id="edit_profile" enctype="multipart/form-data" style="border:1px solid #DDDDDD">
            <div class="control-group">
                <label class="control-label" for="">Product picture:</label>
                <div class="controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="<?= $existing_pic; ?>" />
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-file">
                                <span class="fileupload-new">Select file</span>
                                <span class="fileupload-exists">Change</span>
                                <input type="file" name="userfile" data-rule-required="true" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="managers" class="control-label"></label>
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>	
</div>

<script type="text/javascript">

    $(document).ready(function () {

        $('#edit_profile').validate({
            rules: {
                profile_picture: {
                    required: true
                }
            },
            messages: {
                profile_picture: {
                    required: "Include picture"
                }
            }
        });

    });

</script>