<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Subscription Configuration</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="box">
    <div class="box-content nopadding">
        <?php include '_sub_tab.php'; ?>

        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Price Setup
                                </h3>
                            </div>
                            <div class="box-content-padless">

                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td>Price per Product per Market</td>
                                        <td>NGN <?= number_format($product_price->product_price, 2); ?></td>
                                        <td>
                                            <a title="Click here to edit product price" href="#modal_edit_price" data-toggle="modal">
                                                <i class="icons icon-edit"></i> edit
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal hide fade" id="modal_edit_price" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <form method="post" class="form-horizontal" action="<?= site_url('subscription/edit_product_price/' . $product_price->product_price_id );?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">Edit Product Price</h4>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label">Price</label>
                <div class="controls">
                    <input required type="text" name="product_price" id="product_price" value="<?= $product_price->product_price ?>" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>

</div>

