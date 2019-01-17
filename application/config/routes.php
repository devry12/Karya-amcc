<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

// auth login
$route['login/admin'] = 'auth/loginadmin';

$route['admin/wait'] = 'admin/posts';
$route['admin/publish'] = 'admin/posts_publish';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
