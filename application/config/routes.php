<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = TRUE;

$route['user-ratings/thank-you'] = 'user_ratings/thank_you';
$route['user-ratings/(:any)(/?:any)'] = 'user_ratings/index/$1$2';
$route['logout'] = 'home/logout';
$route['change-password/(:any)'] = 'auth/login/change_password/$1';