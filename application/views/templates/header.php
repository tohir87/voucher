<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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

        <title><?php echo $page_title; ?></title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <!-- Bootstrap responsive -->
        <link rel="stylesheet" href="/css/bootstrap-responsive.min.css">
        <!-- jQuery UI -->
        <link rel="stylesheet" href="/css/plugins/jquery-ui/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
        <!-- PageGuide -->
        <link rel="stylesheet" href="/css/plugins/pageguide/pageguide.css">
        <!-- Fullcalendar -->
        <link rel="stylesheet" href="/css/plugins/fullcalendar/fullcalendar.css">
        <link rel="stylesheet" href="/css/plugins/fullcalendar/fullcalendar.print.css" media="print">
        <!-- Fullcalendar -->
        <link rel="stylesheet" href="/css/plugins/datepicker/datepicker.css">
        <!-- chosen -->
        <link rel="stylesheet" href="/css/plugins/chosen/chosen.css">
        <!-- Easy pie  -->
        <link rel="stylesheet" href="/css/plugins/easy-pie-chart/jquery.easy-pie-chart.css">
        <!-- dataTables -->
        <link rel="stylesheet" href="/css/plugins/datatable/TableTools.css">
        <!-- select2 -->
        <link rel="stylesheet" href="/css/plugins/select2/select2.css">
        <!-- icheck -->
        <link rel="stylesheet" href="/css/plugins/icheck/all.css">
        <!-- Intro JS CSS -->
        <link rel="stylesheet" href="/css/introjs.min.css">
        <!-- Theme CSS -->
        <link rel="stylesheet" href="/css/style.css">
        <!-- Color CSS -->
        <link rel="stylesheet" href="/css/themes.css">
        <!-- CTM CSS -->
        <link rel="stylesheet" href="/css/ctm.css">

        <!-- Datetime picker -->
        <link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
        <!-- timepicker -->
        <link rel="stylesheet" href="/css/plugins/timepicker/bootstrap-timepicker.min.css">

        <!-- Rate (stars) -->
        <link rel="stylesheet" href="/css/rateit.css">

        <!-- jQuery -->
        <script src="/js/jquery.min.js"></script>

        <script src="/js/angular.min.js"></script>

        <!-- Nice Scroll -->
        <script src="/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
        <!-- jQuery UI -->
        <script src="/js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
        <script src="/js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
        <script src="/js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
        <script src="/js/plugins/jquery-ui/jquery.ui.draggable.min.js"></script>
        <script src="/js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
        <script src="/js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
        <script src="/js/plugins/jquery-ui/jquery.ui.spinner.js"></script>
        <!-- Touch enable for jquery UI -->
        <script src="/js/plugins/touch-punch/jquery.touch-punch.min.js"></script>
        <!-- slimScroll -->
        <script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- Bootstrap -->
        <script src="/js/bootstrap.min.js"></script>
        <!-- vmap -->
        <script src="/js/plugins/vmap/jquery.vmap.min.js"></script>
        <script src="/js/plugins/vmap/jquery.vmap.world.js"></script>
        <script src="/js/plugins/vmap/jquery.vmap.sampledata.js"></script>
        <!-- Bootbox -->
        <script src="/js/plugins/bootbox/jquery.bootbox.js"></script>
        <!-- Easy pie -->
        <script src="/js/plugins/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
        <!-- Flot -->
        <script src="/js/plugins/flot/jquery.flot.min.js"></script>
        <script src="/js/plugins/flot/jquery.flot.bar.order.min.js"></script>
        <script src="/js/plugins/flot/jquery.flot.pie.min.js"></script>
        <script src="/js/plugins/flot/jquery.flot.resize.min.js"></script>
        <!-- imagesLoaded -->
        <script src="/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
        <!-- PageGuide -->
        <script src="/js/plugins/pageguide/jquery.pageguide.js"></script>
        <!-- FullCalendar -->
        <script src="/js/plugins/fullcalendar/fullcalendar.min.js"></script>
        <!-- Timepicker -->
        <script src="/js/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- DatePicker -->
        <script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- Timepicker -->
        <script src="/js/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- Chosen -->
        <script src="/js/plugins/chosen/chosen.jquery.min.js"></script>
        <!-- dataTables -->
        <script src="/js/plugins/datatable/jquery.dataTables.min.js"></script>
        <script src="/js/plugins/datatable/TableTools.min.js"></script>
        <script src="/js/plugins/datatable/ColReorder.min.js"></script>
        <script src="/js/plugins/datatable/ColVis.min.js"></script>
        <script src="/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
        <script src="/js/plugins/datatable/dataTables.scroller.min.js"></script>
        <!-- select2 -->
        <script src="/js/plugins/select2/select2.min.js"></script>
        <!-- icheck -->
        <script src="/js/plugins/icheck/jquery.icheck.min.js"></script>
        <!-- Intro JS  -->
        <script src="/js/intro.min.js"></script>
        <script src="/js/jquery.bpopup.min.js"></script>
        <!-- Theme framework -->
        <script src="/js/eakroko.js"></script>

        <!-- JQuery Validation Plugin -->
        <script src="/js/jquery.validate.js"></script>
        <script src="/js/jquery.form.js"></script>


        <script src="/js/plugins/wizard/jquery.form.wizard.min.js"></script>
        <script src="/js/plugins/mockjax/jquery.mockjax.js"></script>
        <!-- CKEditor -->
        <script src="/js/plugins/ckeditor/ckeditor.js"></script>

        <!-- Angularjs -->

        <!-- Theme scripts -->
        <script src="/js/application.min.js"></script>
        <!-- Just for demonstration -->
        <script src="/js/demonstration.min.js"></script>

        <!-- Special for CTM functionality -->
        <script src="/js/ctm.js"></script>

        <!-- File upload -->
        <script src="/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
        <script src="/js/plugins/mockjax/jquery.mockjax.js"></script>

        <!-- Favicon -->
        <link rel="shortcut icon" href="/img/fav_png.png" />
        <!-- Apple devices Homescreen icon -->
        <link rel="apple-touch-icon-precomposed" href="/img/apple-touch-icon-precomposed.png" />

        <!-- JQuery maxlength -->
        <script language="javascript" src="/js/jquery.maxlength.js"></script>
        <!-- timepicker -->
        <link rel="stylesheet" href="/css/plugins/timepicker/bootstrap-timepicker.min.css">

        <!-- Datetime picker -->
        <script src="/js/bootstrap-datetimepicker.min.js"></script>


        <!-- Toastr-->
        <link href="/css/toastr.min.css" rel="stylesheet" type="text/css"/>
        <script src="/js/toastr.min.js" type="text/javascript"></script>

        <!--Boostrp switch-->
        <link href="/css/bootstrap-switch.css" rel="stylesheet" type="text/css"/>
        <script src="/js/bootstrap-switch.js" type="text/javascript"></script>


        <script>
            window.SITE_URL = '<?= site_url(''); ?>';
        </script>

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
    </head>