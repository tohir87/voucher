<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<body class='login' style="background-image: url('img/login_back.jpg')">
    <div class="wrapper">

        <div style="padding: 20px 5px 0; text-align: center;" >
            <img src="<?php echo site_url(); ?>img/ctm_logo_sm.png" style="max-height: 60px; max-width: 200px" alt="Compare the Market">
            <div style="color: #fff; font-size: 18px;">
                <b>COMPARE THE MARKETS</b>
                <span style="font-size: 12px; font-weight: bold; color: #ffdf00">beta</span>
            </div>
        </div>

        <div class="login-body">
            <div class="alert alert-info" style="margin-top:20px;">
                Please sign-in or register to access the dashboard.
            </div>
            <?= show_notification(); ?>
            <?php if ($error_message != '') { ?>
                <div class="alert alert-danger" style="margin-top:20px;">
                    <?php echo $error_message; ?>
                </div>
            <?php } ?>
            <?php if ($success_message != '') { ?>
                <div class="alert alert-success" style="margin-top:20px;">
                    <?php echo $success_message; ?>
                </div>
            <?php } ?>

            <h2 style="text-align: center">Returning Subscriber</h2>
            <form id="subscriber_login_frm" class='form-validate' method="post" action="<?= site_url("/subscription/login"); ?>">
                <div class="control-group">
                    <div class="email controls">
                        <input type="email" name='email' placeholder="Email address" class='input-block-level' data-rule-required="true" data-rule-email="true">
                    </div>
                </div>
                <div class="control-group">
                    <div class="pw controls">
                        <input type="password" name="password" placeholder="Password" class='input-block-level' data-rule-required="true">
                    </div>
                </div>
                <div class="submit">
                    <input type="submit" id="login_button" class="btn btn-warning btn-large pull-right" value="SIGN IN" name="login_button" />
                </div>

            </form>
            <div class="forget">
                <a href="#new_subscriber" data-toggle="modal"><span>New Subscriber? Click here to sign up.</span></a>
            </div>


        </div>
    </div>


    <div class="modal hide fade" id="new_subscriber" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">New Subscriber</h4>
        </div>
        <form id="register" class="form-horizontal form-bordered" method="post">
            <div class="modal-body">

                <div class="control-group">
                    <label for="textfield" class="control-label">First Name</label>
                    <div class="controls">
                        <input type="text" id="first_name" placeholder="First Name" class="input-xlarge" name="first_name" required />
                    </div>
                </div>
                <div class="control-group">
                    <label for="textfield" class="control-label">Last Name</label>
                    <div class="controls">
                        <input type="text" id="last_name" placeholder="Last Name" class="input-xlarge" name="last_name" required />
                    </div>
                </div>
                <div class="control-group">
                    <label for="textfield" class="control-label">Phone</label>
                    <div class="controls">
                        <input type="text" id="phone" placeholder="Phone Number" class="input-xlarge" name="phone" required />
                    </div>
                </div>
                <div class="control-group">
                    <label for="textfield" class="control-label">Email</label>
                    <div class="controls">
                        <input type="email" id="register_email" placeholder="E-mail address" class="input-xlarge" name="register_email" required />
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" id="register_button" class="btn btn-primary pull-right" value="Subscribe" name="register_button" />
                <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            </div>
        </form>
    </div>


    <script>
        mixpanel.track("Subscribers login page");
    </script>
<!--    <div class="footer">
        <p>Powered by <a href="http://zendsolutions.com/" target="_blank">ZendSoft Solutions</a> &copy; <?php echo date('Y'); ?></p>
    </div>-->
</body>