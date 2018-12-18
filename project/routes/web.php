<?php

use App\UsersModel;

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

Route::get('/', 'FrontEndController@index');
Route::get('/about', 'FrontEndController@about');
Route::get('/faq', 'FrontEndController@faq');
Route::get('/contact', 'FrontEndController@contact');
Route::get('/listall', 'FrontEndController@all');
Route::get('/listfeatured', 'FrontEndController@featured');
Route::get('/category/{category}', 'FrontEndController@category');
Route::post('/search', 'FrontEndController@search');
Route::post('/subscribe', 'FrontEndController@subscribe');
Route::post('/profile/email', 'FrontEndController@usermail');
Route::post('/contact/email', 'FrontEndController@contactmail');
Route::get('/profile/{id}/{name}', 'FrontEndController@viewprofile');

Route::post('user/review', 'FrontEndController@reviewsubmit')->name('review.submit');

Route::get('/admin', function () {
    return view('admin.index');
});

Route::get('/login', function () {
    return view('admin.login');
});

Auth::routes();

Route::get('/admin/dashboard', 'HomeController@index');

Route::post('admin/settings/title', 'SettingsController@title');
Route::post('admin/settings/paymentinfo', 'SettingsController@paymentinfo');
Route::post('admin/settings/about', 'SettingsController@about');
Route::post('admin/settings/address', 'SettingsController@address');
Route::post('admin/settings/footer', 'SettingsController@footer');
Route::post('admin/settings/logo', 'SettingsController@logo');
Route::post('admin/settings/favicon', 'SettingsController@favicon');
Route::post('admin/settings/background', 'SettingsController@background');
Route::resource('/admin/settings', 'SettingsController');

Route::resource('/admin/users', 'UsersController');
Route::resource('/admin/category', 'CategoryController');

Route::post('admin/pagesettings/about', 'PageSettingsController@about');
Route::post('admin/pagesettings/faq', 'PageSettingsController@faq');
Route::post('admin/pagesettings/contact', 'PageSettingsController@contact');
Route::resource('/admin/pagesettings', 'PageSettingsController');

Route::get('admin/ads/status/{id}/{status}', 'AdvertiseController@status');

Route::resource('/admin/ads', 'AdvertiseController');
Route::resource('/admin/social', 'SocialLinkController');
Route::resource('/admin/tools', 'SeoToolsController');
Route::get('admin/subscribers/download', 'SubscriberController@download');

Route::resource('/admin/subscribers', 'SubscriberController');
Route::post('/admin/adminpassword/change/{id}', 'AdminProfileController@changepass');
Route::get('/admin/adminpassword', 'AdminProfileController@password');
Route::resource('/admin/adminprofile', 'AdminProfileController');

Route::get('/user/dashboard', 'UserProfileController@index')->name('user.dashboard');
Route::get('/user/edit', 'UserProfileController@edit')->name('user.profile.edit');
Route::get('/user/changepassword', 'UserProfileController@changePassform')->name('user.changepassword');
Route::post('/user/changepass/{id}', 'UserProfileController@changepass')->name('user.changepassword.submit');
Route::post('/user/update/{id}', 'UserProfileController@update')->name('user.update');
Route::get('/user/publish/{id}', 'UserProfileController@publish')->name('user.publish');

Route::get('/user/login', 'Auth\ProfileLoginController@showLoginFrom')->name('user.login');
Route::post('/user/login', 'Auth\ProfileLoginController@login')->name('user.login.submit');
Route::get('/user/registration', 'Auth\ProfileRegistrationController@showRegistrationForm')->name('user.reg');
Route::post('/user/registration', 'Auth\ProfileRegistrationController@register')->name('user.reg.submit');

Route::get('/user/forgot', 'Auth\ProfileResetPassController@showForgotForm')->name('user.forgotpass');
Route::post('/user/forgot', 'Auth\ProfileResetPassController@resetPass')->name('user.forgotpass.submit');

Route::group(['middleware' => 'auth:profile'], function () {
    
Route::post('/user/payment', 'PaymentController@store')->name('payment.submit');
Route::get('/user/payment/cancle', 'PaymentController@paycancle')->name('payment.cancle');
Route::get('/user/payment/return', 'PaymentController@payreturn')->name('payment.return');
});

Route::post('user/payment/notify', 'PaymentController@notify')->name('payment.notify');
Route::post('/stripe-submit', 'StripeController@store')->name('stripe.submit');