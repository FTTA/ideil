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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

//Route::get('test/index', 'TestController@index');

Route::any('/',                        'ArticlesController@index');

Route::any('articles/add',             'ArticlesController@add');
Route::any('articles/details/{id}',    'ArticlesController@details');
Route::any('articles/edit/{id}',       'ArticlesController@edit');
Route::any('articles/index',           'ArticlesController@index');
Route::any('articles/manage',          'ArticlesController@manage');

Route::any('categories/index',         'CategoriesController@index');
Route::any('categories/edit/{id}',     'CategoriesController@edit');
Route::any('categories/add',           'CategoriesController@add');

Route::any('comments/manage/{id}',     'CommentsController@manage');

Route::any('registration/confirm',     'RegistrationController@confirm');
Route::any('registration/index',       'RegistrationController@index');
Route::any('registration/error',       'RegistrationController@error');

Route::any('users/edit',               'UsersController@edit');
Route::any('users/profile',            'UsersController@profile');
Route::any('users/publicp/{id}',       'UsersController@publicp');
Route::any('users/users',              'UsersController@users');

Route::any('fileuploader/upload',      'FileUploaderController@upload');


Route::post('ajax/articlesajax/add',           'Ajax\ArticlesAjaxController@add');
Route::post('ajax/articlesajax/edit',          'Ajax\ArticlesAjaxController@edit');
Route::post('ajax/articlesajax/published',     'Ajax\ArticlesAjaxController@published');
Route::post('ajax/articlesajax/delete',        'Ajax\ArticlesAjaxController@delete');

Route::post('ajax/generalajax/confirm',        'Ajax\GeneralAjaxController@confirm');
Route::post('ajax/generalajax/registration',   'Ajax\GeneralAjaxController@registration');
Route::post('ajax/generalajax/signin',         'Ajax\GeneralAjaxController@signIn');
Route::post('ajax/generalajax/signout',        'Ajax\GeneralAjaxController@signOut');

Route::any('ajax/categoriesajax/add',          'Ajax\CategoriesAjaxController@add');
Route::any('ajax/categoriesajax/delete',       'Ajax\CategoriesAjaxController@delete');
Route::any('ajax/categoriesajax/edit',         'Ajax\CategoriesAjaxController@edit');

Route::post('ajax/commentsajax/add',           'Ajax\CommentsAjaxController@add');
Route::post('ajax/commentsajax/blocking',      'Ajax\CommentsAjaxController@blocking');

Route::post('ajax/usersajax/changepass',       'Ajax\UsersAjaxController@changePass');
Route::post('ajax/usersajax/edit',             'Ajax\UsersAjaxController@edit');
