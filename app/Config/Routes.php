<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', static fn () => redirect()->to(url_to('admin.profile')));

$routes->group('', ['filter' => 'guest'], static function (RouteCollection $routes): void {
    $routes->get('login', 'AuthController::login', ['as' => 'auth.login']);
    $routes->post('login', 'AuthController::attemptLogin', ['as' => 'auth.login.attempt']);
});

$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('profile', 'ProfileController::show', ['as' => 'admin.profile']);
    $routes->post('profile/picture', 'ProfileController::updatePicture', ['as' => 'admin.profile.picture']);
    $routes->get('dashboard', 'OrderController::index', ['as' => 'admin.dashboard']);
    $routes->post('logout', 'AuthController::logout', ['as' => 'auth.logout']);
    $routes->get('logout', 'AuthController::logout');

    // ==========================================
    // Categories Module
    // ==========================================
    $routes->group('categories', static function (RouteCollection $routes): void {
        $routes->get('index', 'CategoryController::index', ['as' => 'categories.index']);
        $routes->get('create', 'CategoryController::create', ['as' => 'categories.create']);
        $routes->post('store', 'CategoryController::store', ['as' => 'categories.store']);
        $routes->get('(:num)/edit', 'CategoryController::edit/$1', ['as' => 'categories.edit']);
        $routes->post('(:num)', 'CategoryController::update/$1', ['as' => 'categories.update']);
        $routes->post('(:num)/delete', 'CategoryController::delete/$1', ['as' => 'categories.delete']);
    });

    // ==========================================
    // Branches Module
    // ==========================================
    $routes->group('branches', static function (RouteCollection $routes): void {
        $routes->get('index', 'BranchController::index', ['as' => 'branches.index']);
        $routes->get('create', 'BranchController::create', ['as' => 'branches.create']);
        $routes->post('store', 'BranchController::store', ['as' => 'branches.store']);
        $routes->get('(:num)/edit', 'BranchController::edit/$1', ['as' => 'branches.edit']);
        $routes->post('(:num)', 'BranchController::update/$1', ['as' => 'branches.update']);
        $routes->post('(:num)/delete', 'BranchController::delete/$1', ['as' => 'branches.delete']);
    });

    // ==========================================
    // Warehouses Module
    // ==========================================
    $routes->group('warehouses', static function (RouteCollection $routes): void {
        $routes->get('index', 'WarehouseController::index', ['as' => 'warehouses.index']);
        $routes->get('create', 'WarehouseController::create', ['as' => 'warehouses.create']);
        $routes->post('store', 'WarehouseController::store', ['as' => 'warehouses.store']);
        $routes->get('(:num)/edit', 'WarehouseController::edit/$1', ['as' => 'warehouses.edit']);
        $routes->post('(:num)', 'WarehouseController::update/$1', ['as' => 'warehouses.update']);
        $routes->post('(:num)/delete', 'WarehouseController::delete/$1', ['as' => 'warehouses.delete']);
    });

    // ==========================================
    // Employee Module
    // ==========================================
    $routes->group('employee', static function (RouteCollection $routes): void {
        $routes->get('index', 'EmployeeController::index', ['as' => 'employee.index']);
        $routes->get('create', 'EmployeeController::create', ['as' => 'employee.create']);
        $routes->post('store', 'EmployeeController::store', ['as' => 'employee.store']);
        $routes->get('(:num)/profile', 'EmployeeProfileController::show/$1', ['as' => 'employee.profile']);
        $routes->get('(:num)/edit', 'EmployeeController::edit/$1', ['as' => 'employee.edit']);
        $routes->post('(:num)', 'EmployeeController::update/$1', ['as' => 'employee.update']);
        $routes->post('(:num)/delete', 'EmployeeController::delete/$1', ['as' => 'employee.delete']);
    });
	
    // ==========================================
    // Products Module
    // ==========================================
    $routes->group('products', static function (RouteCollection $routes): void {
        $routes->get('index', 'ProductController::index', ['as' => 'products.index']);
        $routes->get('create', 'ProductController::create', ['as' => 'products.create']);
        $routes->post('store', 'ProductController::store', ['as' => 'products.store']);
        $routes->get('(:num)/edit', 'ProductController::edit/$1', ['as' => 'products.edit']);
        $routes->post('(:num)', 'ProductController::update/$1', ['as' => 'products.update']);
        $routes->post('(:num)/delete', 'ProductController::delete/$1', ['as' => 'products.delete']);
    });

    $routes->group('product-history', static function (RouteCollection $routes): void {
		$routes->get('index', 'ProductUpdateHistoryController::index', ['as' => 'product-history.index']);
	});
	
    // ==========================================
    // Expenses Module
    // ==========================================
    $routes->group('expenses', static function (RouteCollection $routes): void {
        $routes->get('index', 'ExpenseController::index', ['as' => 'expenses.index']);
        $routes->get('create', 'ExpenseController::create', ['as' => 'expenses.create']);
        $routes->post('store', 'ExpenseController::store', ['as' => 'expenses.store']);
        $routes->get('(:num)/edit', 'ExpenseController::edit/$1', ['as' => 'expenses.edit']);
        $routes->post('(:num)', 'ExpenseController::update/$1', ['as' => 'expenses.update']);
        $routes->post('(:num)/delete', 'ExpenseController::delete/$1', ['as' => 'expenses.delete']);
    });
	
 
	$routes->group('roles', static function (RouteCollection $routes): void {
		$routes->get('index', 'RoleController::index', ['as' => 'roles.index']);
		$routes->get('(:num)/edit', 'RoleController::edit/$1', ['as' => 'roles.edit']);
		$routes->post('(:num)', 'RoleController::update/$1', ['as' => 'roles.update']);
    });


});

$routes->get('test-doctrine', 'TestDoctrineController::index');
