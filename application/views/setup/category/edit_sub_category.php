<div class="page-header">
    <div class="pull-left">
        <a href="<?= $this->input->server('HTTP_REFERER'); ?>" class="btn btn-warning">
            <i class="icons icon-chevron-left"></i> Back
        </a>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3>Edit Sub Category</h3>
            </div>
            <div class="box-content">
                <form class="form-horizontal form-bordered" method="post" action="">
                    <div class="control-group">
                        <label for="category_id" class="control-label">Category</label>
                        <div class="controls">
                            <select name="category_id" id="category_id" class="select2-me input-large">
                                <?php
                                if (!empty($categories)):
                                    $sel = '';
                                    foreach ($categories as $category):
                                        if ($info->category_id == $category->category_id):
                                            $sel = 'selected';
                                        else:
                                            $sel = '';
                                        endif;
                                        ?>
                                        <option value="<?= $category->category_id; ?>" <?= $sel; ?>><?= $category->category_name; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="category_name" class="control-label">Sub Category Name</label>
                        <div class="controls">
                            <input required type="text" placeholder="" class='input' id="category_name" name="sub_category" value="<?= $info->sub_category ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="category_desc" class="control-label">Description</label>
                        <div class="controls">
                            <input type="text" placeholder="" class='input-xlarge' id="category_desc" name="description" value="<?= $info->description ?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" >Update</button>
                        <button type="reset"  class="btn btn-warning" >Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
