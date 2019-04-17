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

Route::get('env', function() {
   dd(env('APP_ENV'));
});

Route::get('/', function () {
    // return view('welcome');
    return view('adminlte::auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

// Route:post('change-password', 'Auth\UpdatePasswordController@update')->name('password.update');

// Route::get('/', 'UserController@index')->name('login.index');
// Route::get('/login', 'UserController@index')->name('login.index');


// Route::post('/login2', 'UserController@userLogin')->name('login.login');
// Route::post('/sendOtp', 'UserController@sendOtp')->name('login.sendOtp')->middleware('checkSession');
// Route::post('/verifyOtp', 'UserController@verifyOtp')->name('login.verifyOtp')->middleware('checkSession');
// Route::get('/logout', 'UserController@logout')->name('login.logout');

// Route::get('/getOtp', 'UserController@home')->name('login.home');

Route::post('/notices_data', 'Property_noticeController@notices_data')->name('notices_data');
Route::post('/noticecriteria', 'Property_noticeController@noticecriteria')->name('noticecriteria');
Route::post('/matching_notice', 'Property_noticeController@matching_notice')->name('matching_notice');
Route::post('/approve_record', 'Property_noticeController@approve_record')->name('approve_record');
Route::post('/reject_record', 'Property_noticeController@reject_record')->name('reject_record');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('/log/{id}', 'LogController@get_list')->name('log.get_list');
Route::get('/log', 'LogController@get_list')->name('log.get_list');
Route::get('/idatalog', 'IdataLogController@get_list')->name('idatalog.get_list');
Route::post('/home/get_data', 'HomeController@get_data')->name('home.get_data');
Route::get('/developer', 'DeveloperController@index')->name('developer.index');
Route::post('/developer/get_data', 'DeveloperController@get_data')->name('developer.get_data');

Route::get('/search', 'SearchController@index')->name('search.index');
Route::post('/search/get_data', 'SearchController@get_data')->name('search.get_data');

Route::get('/search/get_details/{id}', 'SearchController@get_details')->name('search.get_details');

Route::get('/compare', 'CompareController@index')->name('compare.index');
Route::post('/compare/get_data', 'CompareController@get_data')->name('compare.get_data');

Route::get('/user_feedback', 'User_feedbackController@index')->name('user_feedback.index');
Route::get('/user_feedback/details/{id}', 'User_feedbackController@details')->name('user_feedback.details');
// Route::get('/user_feedback/add', 'User_feedbackController@add')->name('user_feedback.add');
// Route::get('/user_feedback/edit/{id}', 'User_feedbackController@edit')->name('user_feedback.edit');
Route::post('/user_feedback/save', 'User_feedbackController@save')->name('user_feedback.save');

Route::get('/user_form', 'UserController@insertform')->name('user_form.insertform');

Route::post('/user_form/save', 'UserController@save')->name('user_form.save');

Route::get('/terms', 'TermsController@index')->name('terms.index');

Route::get('/property', function () {
    return view('property');
});

Route::get('/project', 'ProjectController@index')->name('project.index');
Route::get('project/details/{id}', 'ProjectController@get_details')->name('project.details');
Route::post('project/details/save', 'ProjectController@save')->name('project.save');
Route::post('project/details/save1', 'ProjectController@save1')->name('project.save1');
Route::post('project/details/save2', 'ProjectController@save2')->name('project.save2');
Route::post('/project/details/hello', 'ProjectController@hello')->name('project.hello');


Route::get('/newspapers', 'NewspaperController@index')->name('newspapers.index');
Route::get('/newspapers/details/{id}', 'NewspaperController@details')->name('newspapers.details');
Route::get('/newspapers/add', 'NewspaperController@add')->name('newspapers.add');
Route::get('/newspapers/edit/{id}', 'NewspaperController@edit')->name('newspapers.edit');
Route::post('/newspapers/save', 'NewspaperController@save')->name('newspapers.save');
// Route::post('/newspapers/insert', 'NewspaperController@insert')->name('newspapers.insert');
// Route::post('/newspapers/update/{id}', 'NewspaperController@update')->name('newspapers.update');
Route::post('/newspapers/delete', 'NewspaperController@delete')->name('newspapers.delete');


Route::get('/notice', 'NoticeController@index')->name('notice.index');
Route::get('/notice/details/{id}', 'NoticeController@details')->name('notice.details');
Route::get('/notice/add', 'NoticeController@add')->name('notice.add');
Route::get('/notice/edit/{id}', 'NoticeController@edit')->name('notice.edit');
Route::post('/notice/save', 'NoticeController@save')->name('notice.save');
Route::post('/notice/add_notice', 'NoticeController@add_notice')->name('notice.add_notice');
Route::post('/notice/get_data', 'NoticeController@get_data')->name('notice.get_data');
// Route::get('/notice/get_data', 'NoticeController@get_data')->name('notice.get_data');
Route::post('/notice/map_notice', 'NoticeController@map_notice')->name('notice.map_notice');
// Route::get('/notice/map_notice', 'NoticeController@map_notice')->name('notice.map_notice');
Route::get('/notice/match_property', 'NoticeController@match_property')->name('notice.match_property');
Route::get('/notice/map/{id}', 'NoticeController@map')->name('notice.map');
Route::post('/notice/delete', 'NoticeController@delete')->name('notice.delete');
Route::get('/notice/scan', 'NoticeController@scan')->name('notice.scan');
Route::post('/notice/save_scan', 'NoticeController@save_scan')->name('notice.save_scan');

Route::get('/notice/test_ocr', 'NoticeController@test_ocr')->name('notice.test_ocr');
Route::get('/notice/test_session', 'NoticeController@test_session')->name('notice.test_session');

Route::post('/notice/get_scan', 'NoticeController@get_scan')->name('notice.get_scan');
Route::post('/notice/set_scan', 'NoticeController@set_scan')->name('notice.set_scan');

Route::post('/notice/get_notice_count', 'NoticeController@get_notice_count')->name('notice.get_notice_count');
Route::post('/notice/set_non_relevant_count', 'NoticeController@set_non_relevant_count')->name('notice.set_non_relevant_count');

Route::get('/notice/get_matching_log', 'NoticeController@get_matching_log')->name('notice.get_matching_log');
Route::post('/notice/get_log', 'NoticeController@get_log')->name('notice.get_log');

Route::get('/notice_type', 'Notice_typeController@index')->name('notice_type.index');
Route::get('/notice_type/details/{id}', 'Notice_typeController@details')->name('notice_type.details');
Route::get('/notice_type/add', 'Notice_typeController@add')->name('notice_type.add');
Route::get('/notice_type/edit/{id}', 'Notice_typeController@edit')->name('notice_type.edit');
Route::post('/notice_type/save', 'Notice_typeController@save')->name('notice_type.save');
Route::post('/notice_type/delete', 'Notice_typeController@delete')->name('notice_type.delete');

Route::get('/property', 'PropertyController@index')->name('property.index');
Route::get('/property/details/{id}', 'PropertyController@details')->name('property.details');
Route::get('/property/add', 'PropertyController@add')->name('property.add');
Route::get('/property/edit/{id}', 'PropertyController@edit')->name('property.edit');
Route::post('/property/save', 'PropertyController@save')->name('property.save');
Route::get('/property/list1', 'PropertyController@list1')->name('property.list1');

Route::get('/group', 'GroupController@index')->name('group.index');
Route::get('/group/details/{id}', 'GroupController@details')->name('group.details');
Route::get('/group/add', 'GroupController@add')->name('group.add');
Route::get('/group/edit/{id}', 'GroupController@edit')->name('group.edit');
Route::post('/group/save', 'GroupController@save')->name('group.save');

Route::get('/property_notice/match_notice', 'Property_noticeController@match_notice')->name('property_notice.match_notice');

Route::get('/property_notice/match_property', 'Property_noticeController@match_property')->name('property_notice.match_property');
Route::get('/property_notice', 'Property_noticeController@index')->name('property_notice.index');
Route::get('/property_notice/details/{id}', 'Property_noticeController@details')->name('property_notice.details');
Route::post('/property_notice/save', 'Property_noticeController@save')->name('property_notice.save');
Route::post('/property_notice/send', 'Property_noticeController@send')->name('property_notice.send');
Route::post('/property_notice/reject', 'Property_noticeController@reject')->name('property_notice.reject');

Route::get('/user_notice', 'User_noticeController@index')->name('user_notice.index');
Route::get('/user_notice/send/{id}', 'User_noticeController@send')->name('user_notice.send');

Route::get('/public_notice', 'HomeController@public_notice')->name('home.public_notice');
Route::get('/idata', 'HomeController@idata')->name('home.idata');

Route::get('/user', 'User_listController@index')->name('user.index');
Route::get('/user/add_user', 'User_listController@add_user')->name('user.add_user');
Route::get('/user/edit/{gu_id}', 'User_listController@edit')->name('user.edit');
Route::post('/user/save', 'User_listController@save')->name('user.save');

Route::get('/user_payment_detail', 'User_payment_detailController@index')->name('user_payment_detail.index');
Route::get('/user_payment_detail/set_payment_details', 'User_payment_detailController@set_payment_details')->name('user_payment_detail.set_payment_details');
Route::get('/user_payment_detail/set_monthly_payment_details', 'User_payment_detailController@set_monthly_payment_details')->name('user_payment_detail.set_monthly_payment_details');
Route::get('/user_payment_detail/pay_now/{id}', 'User_payment_detailController@pay_now')->name('user_payment_detail.edit');
Route::post('/user_payment_detail/save', 'User_payment_detailController@save')->name('user_payment_detail.save');

Route::get('/user_payment_detail/list1', 'User_payment_detailController@list1')->name('user_payment_detail.list1');
Route::get('/user_payment_detail/get_invoice/{id}', 'User_payment_detailController@get_invoice')->name('user_payment_detail.get_invoice');
Route::get('/user_payment_detail/payment_response/{response_message}/{order_status}', 'User_payment_detailController@payment_response')->name('user_payment_detail.payment_response');

Route::get('/user_payment_detail/set_monthly_payment_details2', 'User_payment_detailController@set_monthly_payment_details2')->name('user_payment_detail.set_monthly_payment_details2');

Route::post('/update_password/check_old_password', 'Update_passwordController@check_old_password')->name('update_password.check_old_password');
Route::post('/update_password/change_password', 'Update_passwordController@change_password')->name('update_password.change_password');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/login/get_ci_session/{id}', 'Auth\LoginController@get_ci_session')->name('login.get_ci_session');
Route::get('/reams', 'HomeController@reams')->name('home.reams');

Route::post('/logout','LoginController@performLogout')->name('logout');



// Route::get('/test', function () {
//     return view('test/test');
// });


Route::get('/test', 'TestController@index')->name('notice.index');
Route::get('/test/details/{id}', 'TestController@details')->name('notice.details');
Route::get('/test/add', 'TestController@add')->name('notice.add');
Route::get('/test/edit/{id}', 'TestController@edit')->name('notice.edit');
Route::post('/test/save', 'TestController@save')->name('notice.save');
Route::post('/test/add_notice', 'TestController@add_notice')->name('notice.add_notice');
Route::post('/test/get_data', 'TestController@get_data')->name('notice.get_data');
// Route::get('/test/get_data', 'TestController@get_data')->name('notice.get_data');
Route::post('/test/map_notice', 'TestController@map_notice')->name('notice.map_notice');
// Route::get('/test/map_notice', 'TestController@map_notice')->name('notice.map_notice');
Route::get('/test/match_property', 'TestController@match_property')->name('notice.match_property');
Route::get('/test/map/{id}', 'TestController@map')->name('notice.map');
Route::post('/test/delete', 'TestController@delete')->name('notice.delete');
Route::get('/test/match_property_notice', 'TestController@match_property_notice')->name('notice.match_property_notice');
Route::get('/test/fetched_matchingproperty_data', 'TestController@fetched_matchingproperty_data')->name('notice.fetched_matchingproperty_data');
Route::get('/test/get_matching_criteria_summery', 'TestController@get_matching_criteria_summery')->name('test.get_matching_criteria_summery');
Route::get('/test/send_email', 'TestController@send_email')->name('notice.send_email');

Route::get('/notice_count', 'Notice_countController@index')->name('notice_count.index');
Route::post('/notice_count/get_data', 'Notice_countController@get_data')->name('notice_count.get_data');
Route::post('/notice_count/save', 'Notice_countController@save')->name('notice_count.save');