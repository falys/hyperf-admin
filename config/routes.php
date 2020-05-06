<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');
Router::post('/admin/login','App\Controller\AuthController@login');
Router::addGroup('/admin/',function (){
    Router::get('refresh/token','App\Controller\AuthController@refreshToken');
    Router::get('logout','App\Controller\AuthController@logout');
    Router::get('menus','App\Controller\AuthController@getMenus');
    Router::get('buttons','App\Controller\AuthController@getButtons');
    Router::post('refresh','App\Controller\AuthController@refreshToken');
    Router::post('logout','App\Controller\AuthController@logout');
    Router::post('user/list', 'App\Controller\UserController@list');
    Router::post('user/create', 'App\Controller\UserController@create');
    Router::post('user/update', 'App\Controller\UserController@update');
    Router::post('user/delete', 'App\Controller\UserController@delete');
    Router::post('user/search', 'App\Controller\UserController@userSearch');
    Router::get('permission/list', 'App\Controller\PermissionController@list');
    Router::post('permission/create', 'App\Controller\PermissionController@create');
    Router::post('permission/update', 'App\Controller\PermissionController@update');
    Router::post('permission/delete', 'App\Controller\PermissionController@delete');
    Router::post('roles/list', 'App\Controller\RoleController@list');
    Router::get('roles/options', 'App\Controller\RoleController@getRolesOptions');
    Router::post('roles/permissions', 'App\Controller\RoleController@rolePermissions');
    Router::post('roles/create', 'App\Controller\RoleController@create');
    Router::post('roles/update', 'App\Controller\RoleController@update');
    Router::post('roles/delete', 'App\Controller\RoleController@delete');
    Router::post('member/add', 'App\Controller\RoleController@roleMemberAdd');
    Router::post('member/delete', 'App\Controller\RoleController@roleMemberDelete');
    Router::post('roles/member', 'App\Controller\RoleController@roleMemberList');
    Router::post('assign/permission', 'App\Controller\RoleController@assignPermission');
},['middleware' => [\App\Middleware\AuthMiddleware::class]]);
