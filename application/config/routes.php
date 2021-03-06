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

$route['default_controller'] = 'pages/view';
$route['mail'] = 'pages/mail';

/* Como a ideia é fazer os tipos funcionarem dinamicamente, é necessaria uma query que busque as urls no banco e marque as rotas
$route['carros'] = 'veiculos/show/carros';
$route['carros/page/(:num)'] = 'veiculos/page/carros/$1';

$route['motos'] = 'veiculos/show/motos';*/

require_once( BASEPATH .'database/DB.php');
$db =& DB();
$db->select('id_tipo');
$db->select('url');
$db->where('id_tipo > 0');
$query = $db->get( 'veiculos_tipos' );
$result = $query->result();
foreach( $result as $row ) {
    $route[ $row->url ] = 'veiculos/show/'.$row->url;
    $route[ $row->url.'/page/(:num)' ] = 'veiculos/page/'.$row->id_tipo.'/$1';
    $route[ $row->url.'/(:num)' ] = 'veiculos/info/$1';
    $route[$row->url.'/marca/(:num)' ] = 'veiculos/marca/'.$row->id_tipo.'/$1';
}

$route['veiculos/node/(:any)'] = 'veiculos/node/$1';
$route['veiculos/search'] = 'veiculos/search';
$route['veiculos/search.json'] = 'veiculos/search/json';
$route['veiculos/auto_complete'] = 'veiculos/auto_complete';


$route['admin'] = 'admin/view';
$route['admin/upload'] = 'admin/upload';
$route['admin/admin/upload'] = 'admin/upload';
$route['admin/test'] = 'admin/test';
$route['admin/login'] = 'admin/login';
$route['admin/logout'] = 'admin/logout';
$route['admin/validate'] = 'admin/validate';
$route['admin/config'] = 'admin/config';
$route['admin/user'] = 'admin/user';

$route['admin/vehicle'] = 'admin/vehicle';

$route['admin/vehicle/type/(:any)'] = 'admin/type/$1';
$route['admin/vehicle/brand/(:any)'] = 'admin/brand/$1';
$route['admin/vehicle/model/(:any)'] = 'admin/model/$1';
$route['admin/vehicle/optional/(:any)'] = 'admin/optional/$1';
$route['admin/vehicle/fuel/(:any)'] = 'admin/fuel/$1';

$route['admin/vehicle/type/(:any)/(:any)'] = 'admin/type/$1/$2';
$route['admin/vehicle/brand/(:any)/(:any)'] = 'admin/brand/$1/$2';
$route['admin/vehicle/model/(:any)/(:any)'] = 'admin/model/$1/$2';
$route['admin/vehicle/optional/(:any)/(:any)'] = 'admin/optional/$1/$2';
$route['admin/vehicle/fuel/(:any)/(:any)'] = 'admin/fuel/$1/$2';

$route['admin/analytics/(:any)'] = 'admin/analytics/$1';

$route['admin/dropdown/(:any)'] = 'admin/dropdown/$1';
$route['admin/dropdown/(:any)/(:any)'] = 'admin/dropdown/$1/$2';
$route['admin/dropdown/(:any)/(:any)/(:any)'] = 'admin/dropdown/$1/$2/$3';

$route['dropdown/(:any)'] = 'admin/dropdown/$1';
$route['dropdown/(:any)/(:any)'] = 'admin/dropdown/$1/$2';
$route['dropdown/(:any)/(:any)/(:any)'] = 'admin/dropdown/$1/$2/$3';
$route['dropdown/(:any)/(:any)/(:any)/(:any)'] = 'admin/dropdown/$1/$2/$3/$4';

$route['admin/(:any)'] = 'admin/view/$1';


$route['assets/(:any)'] = 'assets/$1';

$route['oauth2callback'] = 'admin/google';

$route['(:any)'] = 'pages/view/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
