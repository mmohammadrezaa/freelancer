<?php
/* ersadid.com */
use Illuminate\Support\Facades\Input;
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    //GET

    Route::get('home', 'AdminPanelConteroller@index');

    Route::get('Dashboard', 'AdminPanelConteroller@index');

    Route::post('Profile/Images/', 'AjaxController@Admin_Profile_Add_IMG');
    Route::post('Profile/Images/Del', 'AjaxController@Admin_Profile_Del_IMG');

        //*****************************\\ match //*********************************\\

    Route::match(['get','post'],'Profile', 'AdminPanelConteroller@Admin_Profile');

    Route::match(['get','post'],'Task/{action?}/{pid?}', 'AdminPanelConteroller@Tasks');




});
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/', 'Auth\LoginController@redirect_login');

Route::get('UpdateSQL', 'AdminPanelConteroller@UpdateSQL');
