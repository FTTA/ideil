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

Route::get('articles/add',             ['middleware' => 'gate_check', 'uses' => 'ArticlesController@add']);
Route::get('articles/details/{id}',    'ArticlesController@details');
Route::get('articles/edit/{id}',       ['middleware' => 'gate_check', 'uses' => 'ArticlesController@edit']);
Route::get('articles/index',           'ArticlesController@index');
Route::get('articles/manage',          ['middleware' => 'gate_check', 'uses' => 'ArticlesController@manage']);

Route::get('categories/index',         ['middleware' => 'gate_check', 'uses' => 'CategoriesController@index']);
Route::get('categories/edit/{id}',     ['middleware' => 'gate_check', 'uses' => 'CategoriesController@edit']);
Route::get('categories/add',           ['middleware' => 'gate_check', 'uses' => 'CategoriesController@add']);

Route::get('comments/manage/{id}',     ['middleware' => 'gate_check', 'uses' => 'CommentsController@manage']);

Route::get('registration/confirm',     'RegistrationController@confirm');
Route::get('registration/index',       'RegistrationController@index');
Route::get('registration/error',       'RegistrationController@error');

Route::get('users/edit',               ['middleware' => 'gate_check', 'uses' => 'UsersController@edit']);
Route::get('users/profile',            ['middleware' => 'gate_check', 'uses' => 'UsersController@profile']);
Route::get('users/publicp/{id}',       'UsersController@publicp');
Route::get('users/users',              ['middleware' => 'gate_check', 'uses' => 'UsersController@users']);

Route::any('fileuploader/upload',      'FileUploaderController@upload');


Route::post('ajax/articlesajax/article',           ['middleware' => 'gate_check', 'uses' => 'Ajax\ArticlesAjaxController@add']);
Route::delete('ajax/articlesajax/article/{id}',    ['middleware' => 'gate_check', 'uses' => 'Ajax\ArticlesAjaxController@delete']);
Route::put('ajax/articlesajax/article/{id}',       ['middleware' => 'gate_check', 'uses' => 'Ajax\ArticlesAjaxController@edit']);
Route::put('ajax/articlesajax/published/{id}',     ['middleware' => 'gate_check', 'uses' => 'Ajax\ArticlesAjaxController@published']);

Route::post('ajax/generalajax/confirm',            'Ajax\GeneralAjaxController@confirm');
Route::post('ajax/generalajax/registration',       'Ajax\GeneralAjaxController@registration');
Route::post('ajax/generalajax/signin',             'Ajax\GeneralAjaxController@signIn');
Route::post('ajax/generalajax/signout',            'Ajax\GeneralAjaxController@signOut');

Route::post('ajax/categoriesajax/category',        ['middleware' => 'gate_check', 'uses' => 'Ajax\CategoriesAjaxController@add']);
Route::delete('ajax/categoriesajax/category/{id}', ['middleware' => 'gate_check', 'uses' => 'Ajax\CategoriesAjaxController@delete']);
Route::put('ajax/categoriesajax/category/{id}',    ['middleware' => 'gate_check', 'uses' => 'Ajax\CategoriesAjaxController@edit']);

Route::post('ajax/commentsajax/comment',           'Ajax\CommentsAjaxController@add');
Route::put('ajax/commentsajax/blocking/{id}',       ['middleware' => 'gate_check', 'uses' => 'Ajax\CommentsAjaxController@blocking']);

Route::put('ajax/usersajax/changepass',            ['middleware' => 'gate_check', 'uses' => 'Ajax\UsersAjaxController@changePass']);
Route::put('ajax/usersajax/edit',                  ['middleware' => 'gate_check', 'uses' => 'Ajax\UsersAjaxController@edit']);

Route::auth();

Route::get('/home', 'HomeController@index');


