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
|	https://codeigniter.com/user_guide/general/routing.html
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


//routes for Caregiver
$route['default_controller'] = 'Caregiver';
$route['register'] = 'Caregiver/register';
$route['index.php']= 'Caregiver/index.php';
$route['account'] = 'Caregiver/account';
$route['account_overview'] = 'Caregiver/account_overview';
$route['landingPage'] = 'Caregiver/landingPage';
$route['landingpage'] = 'Caregiver/landingpage';
$route['residents'] = 'Caregiver/searchForResident';
$route['floorSelect'] = 'Caregiver/floorSelect';
$route['floorCompare'] = 'Caregiver/floorCompare';
$route['logout'] = 'Caregiver/logout';
$route['searchRes'] = 'Caregiver/searchForResident';
$route['resDash'] = 'Caregiver/resDash';
$route['residentAdded'] = 'Caregiver/residentAdded';
$route['buildingView'] = 'Caregiver/buildingView';
$route['floorView'] = 'Caregiver/floorView/';
$route['roomView'] = 'Caregiver/roomView';
$route['newResident'] = 'Caregiver/newResident';
$route['deleteResident'] = 'Caregiver/deleteResident';
$route['deleteCaregiver'] = 'Caregiver/deleteCaregiver';
$route['newQuestion'] = 'Caregiver/newQuestion';
$route['notificationView'] = 'Caregiver/notificationView';


//routes for Resident
$route['tutorial'] = 'Resident/tutorial';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


