<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<body style="background: url(<?= $bgColor; ?>) no-repeat;
    background-color: #000;">
    <div class="container" style="background-color: #FFF; padding: 20px">
        <div class="masthead">
            <div class="row-fluid">
                <div class="span6">
                    <h3 class="muted" style=" vertical-align: bottom">
                        <img src="/img/ctm_logo.png">
                    </h3>
                </div>
                <div class="span6">
                </div>
            </div>
            <hr style=" margin-top: 0">
        </div>


        <div class="alert alert-info" style="margin-top:20px;">
            Please fill the entries below to set your password.
        </div>
        <?= show_notification(); ?>
        <div class="row-fluid">
            <div class="span6">
                <div class="box box-bordered">
                    <div class="box-title">
                        <h3>Re/Set Password</h3>
                    </div>
                    <div class="box-content nopadding">
                        <form id="applicant_login_frm" class="form-horizontal form-bordered" method="post">
                            <div class="control-group">
                                <label for="textfield" class="control-label">Email</label>
                                <div class="controls">
                                    <input type="email" id="email" placeholder="E-mail address" class="input-xlarge" name="email" value="<?= $subscriber->email ?>" readonly />
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Password</label>
                                <div class="controls">
                                    <input type="password" id="password" placeholder="Password" class="input-xlarge" name="password" required minlength="6" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Confirm Password</label>
                                <div class="controls">
                                    <input type="password" id="password2" placeholder="Password" class="input-xlarge" name="password2" required minlength="6" />
                                </div>
                            </div>
                            <input type="hidden" name="subscriber_id" value="<?= $subscriber->subscriber_id; ?>" />
                            <input type="submit" id="login_button" class="btn btn-warning btn-large pull-right" value="Reset" name="login_button" />
                        </form>
                    </div>
                </div>
            </div>

            
        </div>
        <hr style=" margin-top: 50px;">
        <div class="footer">
            <p>Powered by <a href="http://zendsolutions.com/" target="_blank">ZendSoft Solutions</a> &copy; <?php echo date('Y'); ?></p>
        </div>
</body>