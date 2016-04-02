# Create project
	1. using Laragon

# Create database
	1. Using SQLYog or 
	2. PHPMyAdmin

# Update .env
	1. DB_DATABASE=ftsm_acl
	2. DB_USERNAME=root
	3. DB_PASSWORD=

# Include Jacopo Package
	1. Update composer.json in require to include "jacopo/laravel-authentication-acl": "1.3.*"
	2. Run `composer update` in terminal

# Remove the built-in users and reset_passwords table from database and its migration scripts
	1. 2014_10_04_00000_create_users_tables.php
	2. 2014_10_04_10000_create_reset_paswords_tables.php

# Add Authentication Service Provider
	1. Open `config/app.php`
	2. Add `LaravelAcl\Authentication\AuthenticationServiceProvider::class` in `providers`

# Authentication Installation
	1. Run `php artisan authentication:install` in terminal twice (if there's errors)

# Open app/Http/Kernel.php and add in $routeMiddleware
	'admin_logged' => \LaravelAcl\Http\Middleware\AdminLogged::class, 
	'logged' => \LaravelAcl\Http\Middleware\Logged::class, 
	'can_see' => \LaravelAcl\Http\Middleware\CanSee::class, 
	'has_perm' => \LaravelAcl\Http\Middleware\HasPerm::class,

# How to setup main menu

## Open up `config/acl_menu.php`
	1. Add new record
		[
		    "name" => "Task",
		    "route" => "task.index",
		    "link" => 'task',
		    "permissions" => []
		]

## Open up `app/Http/routes.php`
	1. Setup Prefix if required
		Route::group(['prefix' => 'ftsm'],function(){
			Route::resource('tasks','TasksController');
		});
	2. Set Route Group Name
		'as' => 'admin::'
	3. Setup Permission
		- `config/acl_menu.php`
			in permissions >> ['_read-task,_create-task,_update-task,_delete-task']
		- `app/Http/routes.php`
			Use middleware >> 
				[
					'middleware':[
						'has_perm:_read-task,_create-task,_update-task,_delete-task'
					]
				]
	4. Sidebar
		- add in Controller@method
			$sidebar = array(
	            "Task List" => array(
	                'url' => route('admin::admin.tasks.index'), 
	                'icon' => '<i class="fa fa-table"></i>'
	            ),
	            'Add New' => array(
	                'url' => route('admin::admin.tasks.create'), 
	                'icon' => '<i class="fa fa-plus-circle"></i>'
	            ),
	        );
	        return view('task.admin.index',['sidebar_items' => $sidebar]);
