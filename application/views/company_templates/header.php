<?php
if ( ! defined('BASEPATH')){
    exit('No direct script access allowed');
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
	<title><?php echo $page_title; ?></title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/bootstrap-responsive.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
	<!-- PageGuide -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/pageguide/pageguide.css">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/fullcalendar/fullcalendar.print.css" media="print">
	<!-- chosen -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/chosen/chosen.css">
	<!-- select2 -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/select2/select2.css">
	<!-- icheck -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/icheck/all.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/style.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/themes.css">
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/ctm.css">
	
	<!-- jQuery -->
	<script src="<?php echo site_url(); ?>js/jquery.min.js"></script>
	
	
	<!-- Nice Scroll -->
	<script src="<?php echo site_url(); ?>js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?php echo site_url(); ?>js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/jquery-ui/jquery.ui.draggable.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
	<!-- Touch enable for jquery UI -->
	<script src="<?php echo site_url(); ?>js/plugins/touch-punch/jquery.touch-punch.min.js"></script>
	<!-- slimScroll -->
	<script src="<?php echo site_url(); ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo site_url(); ?>js/bootstrap.min.js"></script>
	<!-- vmap -->
	<script src="<?php echo site_url(); ?>js/plugins/vmap/jquery.vmap.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/vmap/jquery.vmap.world.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/vmap/jquery.vmap.sampledata.js"></script>
	<!-- Bootbox -->
	<script src="<?php echo site_url(); ?>js/plugins/bootbox/jquery.bootbox.js"></script>
	<!-- Flot -->
	<script src="<?php echo site_url(); ?>js/plugins/flot/jquery.flot.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/flot/jquery.flot.bar.order.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/flot/jquery.flot.resize.min.js"></script>
	<!-- imagesLoaded -->
	<script src="<?php echo site_url(); ?>js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
	<!-- PageGuide -->
	<script src="<?php echo site_url(); ?>js/plugins/pageguide/jquery.pageguide.js"></script>
	<!-- FullCalendar -->
	<script src="<?php echo site_url(); ?>js/plugins/fullcalendar/fullcalendar.min.js"></script>
	<!-- Chosen -->
	<script src="<?php echo site_url(); ?>js/plugins/chosen/chosen.jquery.min.js"></script>
	<!-- select2 -->
	<script src="<?php echo site_url(); ?>js/plugins/select2/select2.min.js"></script>
	<!-- icheck -->
	<script src="<?php echo site_url(); ?>js/plugins/icheck/jquery.icheck.min.js"></script>

	<!-- Theme framework-->
	<script src="<?php echo site_url(); ?>js/eakroko.js"></script> 
	
	<!-- JQuery Validation Plugin -->
	<script src="<?php echo site_url(); ?>js/jquery.validate.js"></script>
	<script src="<?php echo site_url(); ?>js/jquery.form.js"></script>
	
	<!--[if lte IE 9]>
		<script src="<?php echo site_url(); ?>js/plugins/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->

	<script src="<?php echo site_url(); ?>js/plugins/wizard/jquery.form.wizard.min.js"></script>
	<script src="<?php echo site_url(); ?>js/plugins/mockjax/jquery.mockjax.js"></script>
	
	<!-- Theme scripts -->
	<script src="<?php echo site_url(); ?>js/application.min.js"></script>
	<!-- Just for demonstration -->
	<script src="<?php echo site_url(); ?>js/demonstration.min.js"></script>
         <!-- Angular -->
        <script src="<?php echo site_url(); ?>js/angular.min.js"></script>
	
	<script src="<?php echo site_url(); ?>js/ctm.js"></script>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo site_url(); ?>img/favicon.ico" />
	<!-- Apple devices Homescreen icon -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo site_url(); ?>img/apple-touch-icon-precomposed.png" />
	
	<!-- chosen -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/chosen/chosen.css">
	<!-- multi select -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/multiselect/multi-select.css">
	
	<!-- Chosen -->
	<script src="<?php echo site_url(); ?>js/plugins/chosen/chosen.jquery.min.js"></script>
	<!-- MultiSelect -->
	<script src="<?php echo site_url(); ?>js/plugins/multiselect/jquery.multi-select.js"></script>
	
	<!-- CKEditor -->
	<script src="<?php echo site_url(); ?>js/plugins/ckeditor/ckeditor.js"></script>
	
	<!-- Datepicker -->
	<link rel="stylesheet" href="<?php echo site_url(); ?>css/plugins/datepicker/datepicker.css">
	<!-- Datepicker -->
	<script src="<?php echo site_url(); ?>js/plugins/datepicker/bootstrap-datepicker.js"></script>
        
       
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo site_url(); ?>img/fav_png.png" />
	
	
	<style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 10px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 40px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
    </style>
    
    <!-- new style for frontpg without banner pic -->
    <style type="text/css">
        /*********************************************************
	HOME PAGE
*********************************************************/

.mainHeader {
	padding: 34px 0;
	background: #4D6D87;
	color: #fff;
	margin-bottom: 30px;
	/*527593*/
}
.homeHeader {
	text-align: center;
	padding: 50px 0;
}
.mainHeader h1 {
	font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
	margin: 0;
	font-size: 34px;
	font-weight: 300;
}
.mainHeader h1.pageTitle {
	margin: 0 0 15px;
	font-size: 64px;
	font-weight: 100;
}
.mainHeader h1 .angle {
	margin: 0 8px;
}
.mainHeader p {
	font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 20px;
	line-height: 28px;
	margin: 0 0 40px;
	font-weight: 300;
}
.mainHeader .btnGroup .btn {	
	border: 1px solid rgba(255, 255, 255, 0.45);
	border-radius: 3px;
	box-shadow: none;
	color: #ffffff;
	font-family: 'Roboto','Helvetica Neue',Helvetica,Arial,sans-serif;
	font-size: 16px;
	font-weight: 700;
	margin: 0 10px;
	padding: 14px 30px;
	text-transform: uppercase;
}
.mainHeader .btnGroup .btn:focus,
.mainHeader .btnGroup .btn:hover {
	border-color: #fff;
}
    </style>
    <!-- end new style... -->
    
	<!-- start Mixpanel -->
    <script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f);b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==
typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");for(g=0;g<i.length;g++)f(c,i[g]);
b._i.push([a,e,d])};b.__SV=1.2}})(document,window.mixpanel||[]);
mixpanel.init("<?= MIXPANEL_PROJECT_TOKEN ?>");
    </script>
    <!-- end Mixpanel -->
</head>