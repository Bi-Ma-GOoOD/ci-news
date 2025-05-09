<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\News;

$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']);
$routes->post('news', [News::class, 'create']);
$routes->get('news/(:segment)', [News::class, 'show']);

$routes->get('/', 'Home::index');
$routes->get('pages', [Pages::class, 'index']);
// '(:segment)' หมายถึงส่วนต่อที่จาก URL ที่ไม่รู้จัก เช่น /pages/about หรือ /pages/contact พวก about or contact นี่แหละที่เรียกว่า segment
$routes->get('(:segment)', [Pages::class, 'view']);

