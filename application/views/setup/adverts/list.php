<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Manage Adverts</h1>
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
                                    Available Ads
                                </h3>
                                <a href="#new_ads" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                    <i class="icons icon-plus-sign"></i> Create New Ads
                                </a>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($adverts)): ?>
                                    <table class="table table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th>Ads Name</th>
                                                <th>Client Name</th>
                                                <th>Location</th>
                                                <th>Duration</th>
                                                <th>Image</th>
                                                <th>Ad Link</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($adverts as $ad):
                                                ?>
                                                <tr>
                                                    <td><?= ucfirst($ad->ad_name) ?> </td>
                                                    <td><?= ucfirst($ad->client_name); ?></td>
                                                    <td><?= $locations[$ad->location_id] ?></td>
                                                    <td><?= date('d-M-Y', strtotime($ad->start_date)) . ' to ' . date('d-M-Y', strtotime($ad->end_date)); ?></td>
                                                    <td>
                                                        <a title="<?= $ad->ad_name; ?>" target="_blank" href="<?= $ad->ad_image_url; ?>">View</a>
                                                    </td>
                                                    <td>
                                                        <a href="<?= $ad->ad_link; ?>" target="_blank">
                                                            <?= $ad->ad_link; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a title="Edit this advert" href="<?= site_url('/advert/edit_ads/' . $ad->advert_id); ?>"> 
                                                            <i class="icons icon-edit"></i>edit
                                                        </a> | 
                                                        <a title="Delete this advert" class="delete_ads" href="<?= site_url('/advert/delete_ads/' . $ad->advert_id); ?>"> 
                                                            <i class="icons icon-trash"></i>delete
                                                        </a> 
                                                    </td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data('No advert has been added');
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include '_new_ads.php'; ?>

<script>
    $(function () {
        $('body').delegate('.delete_ads', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to delete this advert ?';
            CTM.doConfirm({
                title: 'Confirm Delete',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });
</script>