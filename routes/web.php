<?php
Route::group(['namespace' => config('app.namespace_name')], function (){
Route::get('/', 'HomeController@index');    
Route::get('page_preview', 'HomeController@preview');
Route::get('/about', 'AboutController@index');
Route::get('/contact', 'ContactController@index');
Route::get('blogs', 'BlogController@index');
Route::post('ajaxhandler', 'AjaxController@index')->name('web_ajaxhandler');
});



Auth::routes();

Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});

//admin Routes
Route::group(['namespace'=>'admin','prefix'=>'admin','middleware'=>['auth', 'activity']],function () {  
Route::get('/', 'SitesController@index');
Route::post('test', 'PageController@store_data');
Route::resource('roles','RoleController');
Route::resource('users','UserController');
Route::resource('banners','BannerController');
Route::resource('sites','SitesController');
Route::resource('pages','PageController');
Route::resource('menu','MenuController');
Route::resource('blogs','BlogController');
Route::resource('categories','CategoryController');
Route::resource('coupons','CouponsController');
Route::resource('stores','StoreController');
Route::resource('footers','FooterController');
Route::resource('socialmedia','SocialMediaController');
Route::get('aws', 'Awsfilemanager@index')->name('aws');

});



