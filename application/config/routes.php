<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'user/user_controller/login';
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']  = 'user/user_controller/login';
$route['logout']  = 'user/user_controller/logout';
$route['upload']  = 'user/user_controller/upload';
$route['batches']  = 'user/user_controller/batches';


$route['forgot_password'] = 'user/user_controller/forgot_password';
$route['user/change_password']  = 'user/user_controller/change_password';
$route['user/deleteUser']  = 'user/user_controller/deleteUser';
$route['user/deleteUser/(:num)']  = 'user/user_controller/deleteUser/$1';
$route['user/edit_user']  = 'user/user_controller/edit_user';
$route['user/view_price_logs']  = 'user/user_controller/view_price_logs';
$route['user/view_plog_details/(:num)/(:num)']  = 'user/user_controller/view_plog_details/$1/$2';
$route['user/edit_user/(:num)']  = 'user/user_controller/edit_user/$1';
$route['user/assign_market/(:num)']  = 'user/user_controller/assign_market/$1';

$route['admin']  = 'user/admin_controller';
$route['admin/(:any)']  = 'user/admin_controller/$1';
$route['admin/(:any)/(:any)']  = 'user/admin_controller/$1/$2';

// Access control
$route['access_control']  = 'user/access_controller';
$route['access_control/(:any)']  = 'user/access_controller/$1';
$route['access_control/(:any)/(:any)']  = 'user/access_controller/$1/$2';


// Setup
$route['setup/markets/products']  = 'market/market_controller/market_products';
$route['setup/markets/products/(:num)']  = 'market/market_controller/market_products/$1';

$route['product/addMetricInfo']  = 'setup/product_controller/addMetricInfo';
$route['product/delete_metric_info/(:num)']  = 'setup/product_controller/delete_metric_info/$1';
$route['product']  = 'setup/setup_controller';
$route['product/(:any)']  = 'setup/setup_controller/$1';
$route['product/(:any)/(:any)']  = 'setup/setup_controller/$1/$2';

$route['setup']  = 'setup/setup_controller';
$route['setup/(:any)']  = 'setup/setup_controller/$1';
$route['setup/(:any)/(:any)']  = 'setup/setup_controller/$1/$2';
$route['setup/(:any)/(:any)/(:any)']  = 'setup/setup_controller/$1/$2/$3';
$route['setup/(:any)/(:any)/(:any)/(:any)']  = 'setup/setup_controller/$1/$2/$3/$4';

// Market

$route['market']  = 'market/market_controller';
$route['market/(:any)']  = 'market/market_controller/$1';
$route['market/(:any)/(:any)']  = 'market/market_controller/$1/$2';
$route['market/(:any)/(:any)/(:any)']  = 'market/market_controller/$1/$2/$3';
$route['market/(:any)/(:any)/(:any)/(:any)']  = 'market/market_controller/$1/$2/$3/$4';
$route['market/(:any)/(:any)/(:any)/(:any)/(:any)']  = 'market/market_controller/$1/$2/$3/$4/$5';

//Reports
$route['report']  = 'reports/report_controller';
$route['report/(:any)']  = 'reports/report_controller/$1';
$route['report/(:any)/(:any)']  = 'reports/report_controller/$1/$2';
$route['report/(:any)/(:any)/(:any)']  = 'reports/report_controller/$1/$2/$3';
$route['report/(:any)/(:any)/(:any)/(:any)']  = 'reports/report_controller/$1/$2/$3/$4';
$route['report/(:any)/(:any)/(:any)/(:any)/(:any)']  = 'reports/report_controller/$1/$2/$3/$4/$5';
$route['report/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)']  = 'reports/report_controller/$1/$2/$3/$4/$5/$6';

//Analytics
$route['analytics']  = 'reports/analytics_controller';
$route['analytics/(:any)']  = 'reports/analytics_controller/$1';
$route['analytics/(:any)/(:any)']  = 'reports/analytics_controller/$1/$2';
$route['analytics/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/$1/$2/$3';
$route['analytics/(:any)/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/$1/$2/$3/$4';
$route['analytics/(:any)/(:any)/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/$1/$2/$3/$4/$5';
$route['analytics/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/$1/$2/$3/$4/$5/$6';
$route['analytics/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/$1/$2/$3/$4/$5/$6/$7';

$route['source-products']  = 'reports/analytics_controller/source_products';


$route['retail-analytics']  = 'reports/analytics_controller/retail_analytics';
$route['retail-analytics/analyse']  = 'reports/analytics_controller/json_analyse_retail_report';
$route['retail-analytics/analyse/(:any)']  = 'reports/analytics_controller/json_analyse_retail_report/$1';
$route['retail-analytics/analyse/(:any)/(:any)']  = 'reports/analytics_controller/json_analyse_retail_report/$1/$2';
$route['retail-analytics/analyse/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/json_analyse_retail_report/$1/$2/$3';
$route['retail-analytics/analyse/(:any)/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/json_analyse_retail_report/$1/$2/$3/$4';
$route['retail-analytics/analyse/(:any)/(:any)/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/json_analyse_retail_report/$1/$2/$3/$4/$5';
$route['retail-analytics/analyse/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)']  = 'reports/analytics_controller/json_analyse_retail_report/$1/$2/$3/$4/$5/$6';


//API V1 routes
$route['api/v1/info'] = 'api_v1/api_info_controller/index';
$route['api/v1/auth/(:any)'] = 'api_v1/api_auth_controller/$1';
$route['api/v1/markets'] = 'api_v1/api_market_controller/index';
$route['api/v1/markets/(:any)'] = 'api_v1/api_market_controller/$1';
$route['api/v1/product'] = 'api_v1/api_product_controller';
$route['api/v1/products'] = 'api_v1/api_market_controller/products';
$route['api/v1/product/([a-z_A-Z]+)'] = 'api_v1/api_product_controller/$1';
$route['api/v1/adverts'] = 'api_v1/api_advert_controller/index';

//Subscriptions
$route['register']  = 'subscription/subscription_controller/index';
$route['activate/(:num)/([a-z_A-Z]+)']  = 'subscription/subscription_controller/activate/$1/$2';
$route['subscription/([a-z_A-Z]+)']  = 'subscription/subscription_controller/$1';
$route['subscription/([a-z_A-Z]+)/(:any)']  = 'subscription/subscription_controller/$1/$2';
$route['subscriber/dashboard']  = 'subscription/subscription_controller/dashboard';
$route['subscriber/logout']  = 'subscription/subscription_controller/logout';
$route['subscriber/account']  = 'subscription/subscription_controller/my_account';
$route['subscriber/add_product']  = 'subscription/subscription_controller/add_product';
$route['subscriber/removeProduct/(:num)']  = 'subscription/subscription_controller/removeProduct/$1';
$route['subscriber/add_market']  = 'subscription/subscription_controller/add_market';
$route['subscriber/removeMarket/(:num)']  = 'subscription/subscription_controller/removeMarket/$1';


//Adverts
$route['advert']  = 'setup/advert_controller/index';
$route['adverts']  = 'setup/advert_controller/index';
$route['advert/(:any)']  = 'setup/advert_controller/$1';
$route['advert/(:any)/(:num)']  = 'setup/advert_controller/$1/$2';