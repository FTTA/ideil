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

Route::get('/',                        'ArticlesController@index');

Route::get('articles/add',             'ArticlesController@add');
Route::get('articles/details/{id}',    'ArticlesController@details');
Route::get('articles/edit/{id}',       'ArticlesController@edit');
Route::get('articles/index',           'ArticlesController@index');
Route::get('articles/manage',          'ArticlesController@manage');

Route::get('categories/index',         'CategoriesController@index');
Route::get('categories/edit/{id}',     'CategoriesController@edit');
Route::get('categories/add',           'CategoriesController@add');

Route::get('comments/manage/{id}',     'CommentsController@manage');

Route::get('registration/confirm',     'RegistrationController@confirm');
Route::get('registration/index',       'RegistrationController@index');
Route::get('registration/error',       'RegistrationController@error');

Route::get('users/edit',               'UsersController@edit');
Route::get('users/profile',            'UsersController@profile');
Route::get('users/publicp/{id}',       'UsersController@publicp');
Route::get('users/users',              'UsersController@users');

Route::any('fileuploader/upload',      'FileUploaderController@upload');


Route::post('ajax/articlesajax/article',           'Ajax\ArticlesAjaxController@add');
Route::delete('ajax/articlesajax/article/{id}',    'Ajax\ArticlesAjaxController@delete');
Route::put('ajax/articlesajax/article/{id}',       'Ajax\ArticlesAjaxController@edit');
Route::put('ajax/articlesajax/published/{id}',     'Ajax\ArticlesAjaxController@published');

Route::post('ajax/generalajax/confirm',            'Ajax\GeneralAjaxController@confirm');
Route::post('ajax/generalajax/registration',       'Ajax\GeneralAjaxController@registration');
Route::post('ajax/generalajax/signin',             'Ajax\GeneralAjaxController@signIn');
Route::post('ajax/generalajax/signout',            'Ajax\GeneralAjaxController@signOut');

Route::post('ajax/categoriesajax/category',        'Ajax\CategoriesAjaxController@add');
Route::delete('ajax/categoriesajax/category/{id}', 'Ajax\CategoriesAjaxController@delete');
Route::put('ajax/categoriesajax/category/{id}',    'Ajax\CategoriesAjaxController@edit');

Route::post('ajax/commentsajax/comment',           'Ajax\CommentsAjaxController@add');
Route::put('ajax/commentsajax/blocking',           'Ajax\CommentsAjaxController@blocking');

Route::put('ajax/usersajax/changepass',            'Ajax\UsersAjaxController@changePass');
Route::put('ajax/usersajax/edit',                  'Ajax\UsersAjaxController@edit');
