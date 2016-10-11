<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// AUTHENTICATION ===========================================================================================================
// Login / Logout ------------------------------------
Route::get('login', ['as'=>'login', 'uses'=>'Auth\AuthController@getLogin'] );
Route::post('login', ['as'=>'login', 'uses'=>'Auth\AuthController@postLogin']);
Route::get('logout', ['as'=>'logout', 'uses'=>'Auth\AuthController@logout']);
// Register ------------------------------------
Route::get('register', ['as'=>'register', 'uses'=>'Auth\AuthController@getRegister']);
Route::post('register', ['as'=>'register', 'uses'=>'Auth\AuthController@postRegister']);
// Password reset ------------------------------------
Route::get('password/reset/{token?}', ['as'=>'password.reset', 'uses'=>'Auth\PasswordController@showResetForm']);
Route::post('password/email', ['as'=>'password.email', 'uses'=>'Auth\PasswordController@sendResetLinkEmail']);
Route::post('password/reset', ['as'=>'password.reset', 'uses'=>'Auth\PasswordController@reset']);

// LOGIN ACCESS ONLY =========================================================================================================
Route::group(['middleware' => 'auth'], function () {

// HOME ROUTES: go to getIndex function in PagesController - Only Admin & Owner access ------------------------------------
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner']], function () {
    Route::get('/', ['as'=>'home','uses'=>'PageController@getIndex']);
    Route::get('/search', ['as'=>'pages.search','uses'=>'PageController@getSearch']);
 });

// CLIENT ROUTES - Only Admin & Owner access ------------------------------------
//Route::resource('clients', 'ClientController');
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner']], function () {
    Route::get('clients/search', ['as' => 'clients.search','uses' => 'ClientController@search']);
    Route::resource('clients', 'ClientController', ['except' => ['search']]);
 });

// SITE ROUTES - Only Admin & Owner access------------------------------------
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner']], function () {
    Route::get('sites/search', ['as' => 'sites.search', 'uses' => 'SiteController@search']);
    Route::get('sites/create/{sites}', ['as' => 'sites.create', 'uses' => 'SiteController@create']);
    Route::get('sites/index/{sites}', ['as' => 'sites.index', 'uses' => 'SiteController@index']);
    Route::resource('sites', 'SiteController', ['except' => ['index','search','create']]);
 });

// JOB ROUTES ------------------------------------
// Only Admin & Owner access
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner']], function () {
    Route::get('jobs/search', ['as' => 'jobs.search', 'uses' => 'JobController@search']);
    Route::get('jobs/create/{jobs}/{type}', ['as' => 'jobs.create', 'uses' => 'JobController@create']);
    Route::get('jobs/index/{jobs}', ['as' => 'jobs.index', 'uses' => 'JobController@index']);
    Route::resource('jobs', 'JobController', ['except' => ['index','search','create','show']]);
});
// Only allow technician to access jobs.show
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner','Technician']], function () {
    Route::get('jobs/{jobs}', ['as' => 'jobs.show', 'uses' => 'JobController@show']);
});



// TECHNICIAN ROUTES - All access------------------------------------
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner','Technician']], function () {
    Route::get('technicians/search', ['as' => 'technicians.search', 'uses' => 'TechnicianController@search']);
    Route::get('technicians/create/{technicians}', ['as' => 'technicians.create', 'uses' => 'TechnicianController@create']);
    Route::get('technicians/index/{technicians}', ['as' => 'technicians.index', 'uses' => 'TechnicianController@index']);
    Route::resource('technicians', 'TechnicianController', ['except' => ['index','search','create']]);
});

// MATERIAL ROUTES ------------------------------------
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner','Technician']], function () {
    Route::resource('materials', 'MaterialController');
});

// PENDING INVOICE ROUTES - Only Admin & Owner access ------------------------------------
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner']], function () {
    Route::get('pendinginvoices/create/{pendinginvoices}', ['as' => 'pendinginvoices.create', 'uses' => 'PendingInvoiceController@create']);
    Route::get('pendinginvoices/index/{pendinginvoices}', ['as' => 'pendinginvoices.index', 'uses' => 'PendingInvoiceController@index']);
    Route::resource('pendinginvoices', 'PendingInvoiceController', ['except' => ['index','create']]);
});

// INVOICE ROUTES - Only Admin & Owner access ------------------------------------
Route::group(['middleware' => 'roles', 'roles' => ['Admin','Owner']], function () {
    Route::get('invoices/search', ['as' => 'invoices.search', 'uses' => 'InvoiceController@search']);
    Route::get('invoices/email/{invoices}/{height}', ['as' => 'invoices.email', 'uses' => 'InvoiceController@email']);
    Route::get('invoices/pdf/{invoices}/{height}', ['as' => 'invoices.pdf', 'uses' => 'InvoiceController@pdf']);
    Route::get('invoices/create/{invoices}', ['as' => 'invoices.create', 'uses' => 'InvoiceController@create']);
    Route::get('invoices/index/{invoices}', ['as' => 'invoices.index', 'uses' => 'InvoiceController@index']);
    Route::resource('invoices', 'InvoiceController', ['except' => ['index','search','pdf','email','create']]);


    //Michal router for approving invoice
    Route::get('invoices/approval/{id}', 'InvoiceController@approval');
    Route::post('/invoice/approval/send/{id}', 'InvoiceController@send');
});

// ACTIVITY LOGS ROUTES: go to getIndex function in ActivityLogController - Only Owner access ------------------------------------
Route::group(['middleware' => 'roles', 'roles' => ['Owner']], function () {
    Route::get('activitylogs', ['as'=>'activitylogs.index','uses'=>'ActivityLogController@index']);
    Route::get('activitylogs/{activitylogs}', ['as'=>'activitylogs.show','uses'=>'ActivityLogController@show']);
 });

}); // END LOGIN ACCESS =========================================================================================================

/*
|--------------------------------------------------------------------------
| ALL USEFUL LINKS USED TO BUILD THIS SITE
|--------------------------------------------------------------------------
|
| How to pass paremeter to controller in resource
| --https://laracasts.com/discuss/channels/general-discussion/pass-parameters-to-index-controllers-function
|
| Laravel Validations in controller
| --https://laravel.com/docs/master/validation
|
| Laravel Database
| --https://laravel.com/docs/master/eloquent
|
| Useful knowleadge
| https://scotch.io
|
| Working with Carbon (neat ways of dealing with Date & Time)
| http://carbon.nesbot.com/docs/
| https://scotch.io/tutorials/easier-datetime-in-laravel-and-php-with-carbon
|
| Using Form from Laravel Collective
| --Form: https://laravelcollective.com/docs/5.2/html
| --http://laravel-recipes.com
|
| Parsley JS Validation
| --Parsley JS: http://parsleyjs.org/doc/index.html#validators
| --http://geekswithblogs.net/brcraju/archive/2003/10/23/235.aspx
| --http://www.regexlib.com/DisplayPatterns.aspx?cattabindex=2&categoryId=3
|
| Bootstrap CSS
| --http://getbootstrap.com/components/
|
| PHP Date & Time
| --http://php.net/manual/en/function.date.php
| --http://php.net/manual/en/function.strtotime.php
|
| Emmet plugin for sublime
| --http://emmet.io
| --https://packagecontrol.io/packages/Emmet
|
| Linters plugin for Sublime
| --http://sublimelinter.readthedocs.io/en/latest/about.html
| --https://scotch.io/tutorials/how-to-catch-your-errors-in-sublime-text-3
|
| Laravel Blade Extensions
| http://robin.radic.nl/blade-extensions/directives/assignment.html
| @set--https://github.com/sineld/bladeset
|
| Search All
| https://github.com/nicolaslopezj/searchable
| https://github.com/jarektkaczyk/eloquence/wiki/Builder-searchable-and-more#joining-relations
| https://softonsofa.com/laravel-searchable-the-best-package-for-eloquent/
|
|
| Activity log
| https://docs.spatie.be/laravel-activitylog/v1/advanced-usage/logging-model-events
|
|
*/