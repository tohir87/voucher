<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if ($email_message != '') {
    $email_error_class = ' error';
} else {
    $email_error_class = '';
}

if ($password_message != '') {
    $password_error_class = ' error';
} else {
    $password_error_class = '';
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

        <title>CTM - login</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap.min.css">
        <!-- Bootstrap responsive -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap-responsive.min.css">
        <!-- icheck -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/icheck/all.css">
        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>css/style.css">
        <!-- Color CSS -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>css/themes.css">


        <!-- jQuery -->
        <script src="<?php echo site_url(); ?>js/jquery.min.js"></script>

        <!-- Nice Scroll -->
        <script src="<?php echo site_url(); ?>js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
        <!-- Validation -->
        <script src="<?php echo site_url(); ?>js/plugins/validation/jquery.validate.min.js"></script>
        <script src="<?php echo site_url(); ?>js/plugins/validation/additional-methods.min.js"></script>
        <!-- icheck -->
        <script src="<?php echo site_url(); ?>js/plugins/icheck/jquery.icheck.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo site_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo site_url(); ?>js/eakroko.js"></script>

        <!--[if lte IE 9]>
                <script src="<?php echo site_url(); ?>js/plugins/placeholder/jquery.placeholder.min.js"></script>
                <script>
                        $(document).ready(function() {
                                $('input, textarea').placeholder();
                        });
                </script>
        <![endif]-->


        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo site_url(); ?>img/fav_png.png" />
        <!-- Apple devices Homescreen icon -->
        <link rel="apple-touch-icon-precomposed" href="<?php echo site_url(); ?>img/apple-touch-icon-precomposed.png" />

    </head>

    <body class='login' >
        <div class="wrapper">

          <div style="padding: 20px 5px 0; text-align: center;" >
                    <img src="<?php echo site_url(); ?>img/ctm_logo_sm.png" style="max-height: 60px; max-width: 200px" alt="Compare the Market">
                    <div style="color: #fff; font-size: 18px;">
                        <b>PUTIN</b>
                        <span style="font-size: 12px; font-weight: bold; color: #ffdf00">beta</span>
                    </div>
                </div>
            <div class="login-body">
                <h2 style="text-align: center">LOGIN</h2>
                <form method='POST' class='form-validate' id="test" action="<?= site_url('/login');?>">
                    <div class="control-group <?php echo $email_error_class; ?>">
                        <div class="email controls">
                            <input type="text" name='email' placeholder="Email address" class='input-block-level' data-rule-required="true" data-rule-email="true">
                            <?php if ($email_message != '') { ?>
                                <span for="uemail" class="help-block error"><?php echo $email_message; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo $password_error_class; ?>">
                        <div class="pw controls">
                            <input type="password" name="password" placeholder="Password" class='input-block-level' data-rule-required="true">
                            <?php if ($password_message != '') { ?>
                                <span for="uemail" class="help-block error"><?php echo $password_message; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="submit">
                        <input type="submit" value="SIGN IN" class='btn btn-primary'>
                    </div>
                </form>
                
                <div class="forget" style="margin-top: 15px;">
                    <a href="<?= site_url("forgot_password"); ?>"><span>Forgot your password?</span></a>
                </div>

            </div>
        </div>
        <!-- start Mixpanel -->
        <script type="text/javascript">(function (e, b) {
                if (!b.__SV) {
                    var a, f, i, g;
                    window.mixpanel = b;
                    b._i = [];
                    b.init = function (a, e, d) {
                        function f(b, h) {
                            var a = h.split(".");
                            2 == a.length && (b = b[a[0]], h = a[1]);
                            b[h] = function () {
                                b.push([h].concat(Array.prototype.slice.call(arguments, 0)))
                            }
                        }
                        var c = b;
                        "undefined" !== typeof d ? c = b[d] = [] : d = "mixpanel";
                        c.people = c.people || [];
                        c.toString = function (b) {
                            var a = "mixpanel";
                            "mixpanel" !== d && (a += "." + d);
                            b || (a += " (stub)");
                            return a
                        };
                        c.people.toString = function () {
                            return c.toString(1) + ".people (stub)"
                        };
                        i = "disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
                        for (g = 0; g < i.length; g++)
                            f(c, i[g]);
                        b._i.push([a, e, d])
                    };
                    b.__SV = 1.2;
                    a = e.createElement("script");
                    a.type = "text/javascript";
                    a.async = !0;
                    a.src = "undefined" !== typeof MIXPANEL_CUSTOM_LIB_URL ? MIXPANEL_CUSTOM_LIB_URL : "file:" === e.location.protocol && "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//) ? "https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js" : "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";
                    f = e.getElementsByTagName("script")[0];
                    f.parentNode.insertBefore(a, f)
                }
            })(document, window.mixpanel || []);
            mixpanel.init("<?= MIXPANEL_PROJECT_TOKEN; ?>");</script><!-- end Mixpanel -->
        <script>
            
            mixpanel.track("Dashboard login page");
        </script>
    </body>
</html>
