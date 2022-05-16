<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['clientcheck'])->group(function () {
    Route::get('/', 'UserController@index')->name('home');
    Route::get('/login', 'AuthController@loginPage')->name('login');

    Route::get('/payslip', 'PayslipController@index')->name('payslip');
    Route::get('/report', 'UserController@report')->name('report');
    Route::get('/workview', 'UserController@workview')->name('workview');

    Route::get('/work', 'UserController@work')->name('work');
    Route::post('/work/upload', 'UserController@workUpload')->name('work.upload');
    Route::post('/admin/work/upload', 'UserController@adminWorkUpload')->name('admin.work.upload');
    Route::post('/work/remove', 'UserController@workRemove')->name('work.remove');
    Route::post('/work/update', 'UserController@workUpdate')->name('work.update');
    Route::post('/work/quantity/update', 'UserController@workQuantityUpdate')->name('work.quantity.update');

    Route::get('/addworkadmin', "UserController@addworkadmin")->name("addworkadmin");

    Route::get('/dashboard', 'UserController@index')->name('dashboard');
    Route::get('/profile', 'UserController@profile')->name('user.profile');
    Route::post('/profile/save', 'UserController@profileSave')->name('user.profile.save');

    Route::get('/users', 'UserController@userList')->name('users');
    Route::get('/users/admin', 'UserController@adminList')->name('users.admin');
    Route::get('/users/tailor', 'UserController@tailorList')->name('users.tailor');
    Route::get('/users/seamstress', 'UserController@seamstressList')->name('users.seamstress');

    Route::get('/users/add', 'UserController@userAddPage')->name('users.view');
    Route::post('/users/add', 'UserController@userAdd')->name('users.add');
    Route::post('/users/remove', 'UserController@userRemove')->name('users.remove');
    Route::post('/users/update', 'UserController@userUpdate')->name('users.update');

    Route::get('/products', 'ProductController@products')->name('products');
    Route::get('/products/add', 'ProductController@productAddPage')->name('products.view');
    Route::post('/products/add', 'ProductController@productAdd')->name('products.add');
    Route::post('/products/remove', 'ProductController@productRemove')->name('products.remove');
    Route::post('/products/update', 'ProductController@productUpdate')->name('products.update');

    Route::get('/register', 'AuthController@registerPage')->name('auth.register');
    Route::post('/register', 'AuthController@register')->name('post.register');
    Route::post('/login', 'AuthController@login')->name('auth.login');
    Route::get('/logout', 'AuthController@logout')->name('auth.logout');

    Route::get('/announce', 'AnnounceController@index')->name('announce');
    Route::post('/announce/create', 'AnnounceController@create')->name('announce.create');
    Route::post('/announce/toggle', 'AnnounceController@toggle')->name('announce.toggle');
    Route::post('/announce/update', 'AnnounceController@update')->name('announce.update');
    Route::post('/announce/remove', 'AnnounceController@remove')->name('announce.remove');


    Route::post('/deduct/add', 'DeductController@add')->name('deduct.add');
    Route::post('/deduct/remove', 'DeductController@remove')->name('deduct.remove');
    Route::post('/deduct/clear', 'DeductController@clear')->name('deduct.clear');

    Route::get('/scan', function () {
        return view('scanv2');
    });

    Route::post('/tailor/check', 'UserController@tailorCheck')->name('tailor.check');
    Route::get('/salary', 'UserController@summarySalary')->name('salary');

    Route::post('/users/lineid/update', 'UserController@updateUserLineId')->name('users.lineid.update');
    Route::get('/line-auth', 'UserController@lineAuth')->name('line.auth');
});

Route::get('/lineadd', function () {
    return view('lineadd');
});