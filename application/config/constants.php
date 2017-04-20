<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// Tables
define('TBL_USERS', 'users'); 
define('TBL_USER_PERMS', 'user_perms'); 

//User status
define('USER_STATUS_INACTIVE', 0); 
define('USER_STATUS_ACTIVE', 1);

//statuses
define('INACTIVE', 0); 
define('ACTIVE', 1); 
define('APPROVED', 1); 


//User status
define('USER_TYPE_ADMIN', 1); 
define('USER_TYPE_ORDINARY', 2); 
define('USER_TYPE_SUBSCRIBER', 3); 

// Min password length
define('MIN_PWD_LEN', 6); 

//company
define('BUSINESS_NAME', 'PUTIN'); 
define('BUSINESS_NAME_FULL', 'PUTIN'); 
define('WEBSITE', 'http://zendsolutions.com'); 
define('NO_REPLY_EMAIL', 'zendsolutions.com'); 
define('INFO_EMAIL', 'info@zendsolutions.com'); 

define('FILE_PATH', FCPATH . 'files/');

define('FILE_PATH_PRODUCT_LOGO', FILE_PATH . 'product_image/');
if (!is_dir(FILE_PATH_PRODUCT_LOGO)) {
    @mkdir(FILE_PATH_PRODUCT_LOGO, 0777, true);
}

define('FILE_PATH_ADS_IMG', FILE_PATH . 'ads_image/');
if (!is_dir(FILE_PATH_ADS_IMG)) {
    @mkdir(FILE_PATH_ADS_IMG, 0777, true);
}

define('NEARING_SEASON_END', 3);
define('IN_SEASON', 4);
define('NOT_IN_SEASON', 5);


// Mix panel
define('MIXPANEL_PROJECT_TOKEN', "80f794caf212a2e64bdf4128ee2576cc");

//Bugsnag Client ID
define('BUGSNAG_API_KEY', "faa6777fb29174552a34cef63dd4dd6d");

// Perms
define('PERM_SETUP', 4);
define('PERM_PRODUCT', 10);
define('PERM_REPORT', 35);

// Perms
define('ADS_LOC_DASHBOARD', 1);
define('ADS_LOC_PRODUCT_LIST', 2);
define('ADS_LOC_PRODUCT_VIEW', 3);
