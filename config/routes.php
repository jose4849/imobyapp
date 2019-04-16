<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */
$route['default_controller'] = "register/login";
$route['404_override'] = '';

/* ADMIN */

$route['admin/(:any)'] = "admin/$1";
$route['admin'] = "admin/gebruikers";


$route['backoffice/relatiebeheer/(:any)'] = "crm/$1";

// $route['superadmin/user'] = "admin/user";
// $route['superadmin/user/detail'] = "admin/user/detailUser";
// $route['superadmin/administrator'] = "admin/administrator";
// $route['superadmin/administrator/add'] = "admin/administrator/add";

/* BCAKOFFICE */
$route['backoffice/(:any)'] = "backoffice/$1";
$route['backoffice'] = "backoffice/dashboard";

/* WEBSITE 
  $route['website/(:any)'] = "website/$1";
  $route['website'] = "website/website"; */

/* COMMON */
$route['login'] = "register/login";
$route['logout'] = "register/logout";
$route['wachtwoordvergeten'] = "register/forgot";
$route['login/dealerLogin'] = "register/dealerLogin";

/* APP */
$route['(:num)/mobile'] = 'mobile/home';
$route['(:num)/mobile/(:any)'] = 'mobile/$2';

/* WEBSITE */
$route['(:num)/website'] = 'website/home';
$route['(:num)/website/(:any)'] = 'website/$2';

/* WEBSITE OR APP */

$route['home/(:num)'] = "home/index";
$route['site/(:any)/(:num)'] = "home/site";


require_once(APPPATH . 'libraries/Mobile_Detect.php');
$detect = new Mobile_Detect;
if ($detect->isMobile()) {
    $route['(:num)'] = 'mobile/index';
} else {
    $route['(:num)'] = 'website/index';
}

/* End of file routes.php */
/* Location: ./application/config/routes.php */