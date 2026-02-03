<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Public knowledge base routes
$route['kb']['get'] = 'knowledgebase/index';
$route['kb/category/(:num)']['get'] = 'knowledgebase/category/$1';
$route['kb/article/(:num)']['get'] = 'knowledgebase/article/$1';
$route['kb/search']['get'] = 'knowledgebase/search';

// Admin routes
$route['kb/admin']['get'] = 'admin/index';
$route['kb/admin/categories']['get'] = 'admin/categories';
$route['kb/admin/categories/add']['get'] = 'admin/add_category';
$route['kb/admin/categories/add']['post'] = 'admin/add_category';
$route['kb/admin/categories/edit/(:num)']['get'] = 'admin/edit_category/$1';
$route['kb/admin/categories/edit/(:num)']['post'] = 'admin/edit_category/$1';
$route['kb/admin/categories/delete/(:num)']['post'] = 'admin/delete_category/$1';

$route['kb/admin/articles']['get'] = 'admin/articles';
$route['kb/admin/articles/add']['get'] = 'admin/add_article';
$route['kb/admin/articles/add']['post'] = 'admin/add_article';
$route['kb/admin/articles/edit/(:num)']['get'] = 'admin/edit_article/$1';
$route['kb/admin/articles/edit/(:num)']['post'] = 'admin/edit_article/$1';
$route['kb/admin/articles/delete/(:num)']['post'] = 'admin/delete_article/$1';
$route['kb/admin/articles/publish/(:num)']['post'] = 'admin/publish_article/$1';

$route['kb/admin/tags']['get'] = 'admin/tags';
$route['kb/admin/tags/add']['get'] = 'admin/add_tag';
$route['kb/admin/tags/add']['post'] = 'admin/add_tag';
$route['kb/admin/tags/edit/(:num)']['get'] = 'admin/edit_tag/$1';
$route['kb/admin/tags/edit/(:num)']['post'] = 'admin/edit_tag/$1';
$route['kb/admin/tags/delete/(:num)']['post'] = 'admin/delete_tag/$1';
