<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('redirect', 'App\Http\Controllers\HomeController@index');
Route::get('formpage', 'App\Http\Controllers\UserController@formpage');

Route::get('users', 'App\Http\Controllers\UserController@index');
Route::get('users/list', 'App\Http\Controllers\UserController@list');
Route::post('users/createlist', 'App\Http\Controllers\UserController@createList');
Route::get('users/lists/delete/{list}', 'App\Http\Controllers\UserController@deleteList');
Route::get('users/listDetail/{list}/{type}', 'App\Http\Controllers\UserController@listDetail');
Route::post('users/addcontact/{list}', 'App\Http\Controllers\UserController@addContact');
Route::get('users/contact/delete/{list}', 'App\Http\Controllers\UserController@deleteContact');

Route::get('users/contactname/delete/{list}', 'App\Http\Controllers\UserController@deleteContactname');


Route::get('users/todayBirthday/{list}', 'App\Http\Controllers\UserController@todayBirthday');
Route::get('users/tomorrowBirthday/{list}', 'App\Http\Controllers\UserController@tomorrowBirthday');
Route::get('users/celebrantsByMonths/{list}', 'App\Http\Controllers\UserController@celebByMonth');
Route::get('users/monthExtract/{month}/{list}', 'App\Http\Controllers\UserController@monthExtract');
Route::get('users/name_phone_only/{list}', 'App\Http\Controllers\UserController@phone_name');
Route::post('users/phone_only/{list}', 'App\Http\Controllers\UserController@phone_only');
Route::get('users/phone_edit/{list}', 'App\Http\Controllers\UserController@phone_edit');
Route::put('users/phone_edit/{list}', 'App\Http\Controllers\UserController@phone_update');

Route::get('users/create_contact_list', 'App\Http\Controllers\UserController@create_contact_list');
Route::post('users/create_contact_list', 'App\Http\Controllers\UserController@create_phone_list');

Route::get('users/sentMessages', 'App\Http\Controllers\UserController@sentMessages');
Route::get('users/userProfile', 'App\Http\Controllers\UserController@userProfile');
Route::get('user/updatePassword', 'App\Http\Controllers\UserController@updatePassword');
Route::get('users/pricing', 'App\Http\Controllers\UserController@pricing');
Route::post('users/smstocontacts', 'App\Http\Controllers\UserController@smstocontacts');
Route::post('users/smstocontactsphone', 'App\Http\Controllers\UserController@smstocontactsphone');
Route::get('users/contactphone/delete/{list}', 'App\Http\Controllers\UserController@deletecontactphone');
Route::get('users/schedulesms/delete/{id}', 'App\Http\Controllers\UserController@deleteschedulesms');


Route::post('users/smstocontactstomorrow', 'App\Http\Controllers\UserController@smstocontacts2');
Route::post('users/smstocontactsmonth', 'App\Http\Controllers\UserController@smstocontacts3');
Route::get('users/schedule', 'App\Http\Controllers\UserController@schedule');
Route::post('users/autosms', 'App\Http\Controllers\UserController@autosms');
Route::get('users/scheduleList', 'App\Http\Controllers\UserController@scheduleList');
Route::get('users/deactivate/{list}', 'App\Http\Controllers\UserController@deactivateauto');
Route::get('users/scheduleUpdate/{list}/{type}/{extra}', 'App\Http\Controllers\UserController@scheduleupdate');
Route::post('users/scheduleUpdate/{list}', 'App\Http\Controllers\UserController@scheduleupdate2');
Route::post('users/multiplecontact/{list}', 'App\Http\Controllers\UserController@multiplecontact');
Route::post('users/multiplenamecontact/{list}', 'App\Http\Controllers\UserController@multiplenamecontact');
Route::post('users/schedulesms/{list}', 'App\Http\Controllers\UserController@schedulesms');
Route::post('users/schedulesms2/{list}', 'App\Http\Controllers\UserController@schedulesms2');

Route::post('users/changesenderid/{list}', 'App\Http\Controllers\UserController@changesenderid');
Route::post('users/changesenderid2/{list}', 'App\Http\Controllers\UserController@changesenderid2');

Route::put('users/nameschedulesms/{list}', 'App\Http\Controllers\UserController@nameschedulesms');

Route::post('users/multipleanniversary/{list}', 'App\Http\Controllers\UserController@multipleanniversary');
Route::get('users/autosendtype', 'App\Http\Controllers\UserController@autosendtype');
Route::get('users/contacts/{list}/{type}', 'App\Http\Controllers\UserController@listcontacts');
Route::get('users/done_list/{list}', 'App\Http\Controllers\UserController@donelist');
Route::get('users/singleupdate/{list}', 'App\Http\Controllers\UserController@singleupdate');
Route::get('users/multipleupdate/{list}', 'App\Http\Controllers\UserController@multipleupdate');
Route::put('users/updatemultipleinfo', 'App\Http\Controllers\UserController@multipleupdateinfo');
Route::get('users/pullcontactdetail/{contact}', 'App\Http\Controllers\UserController@pullcontact');
Route::get('users/pullsmsdetail/{contact}', 'App\Http\Controllers\UserController@pullsms');
Route::get('users/pullanniversarydetail/{contact}', 'App\Http\Controllers\UserController@pullanniversary');
Route::post('users/submitcontactupdate', 'App\Http\Controllers\UserController@submitcontactupdate');
Route::post('users/submitlistupdate', 'App\Http\Controllers\UserController@submitlistupdate');
Route::post('users/fileupload', 'App\Http\Controllers\UserController@fileupload');
Route::post('users/fileuploadname', 'App\Http\Controllers\UserController@fileuploadname');
Route::get('users/pulllistdetail/{list}', 'App\Http\Controllers\UserController@pulllistdetail');
Route::get('users/pullfielddetail/{list}', 'App\Http\Controllers\UserController@pulllfielddetail');
Route::post('users/addconfirmsms', 'App\Http\Controllers\UserController@submitcomfirmsms');
Route::post('users/updateconfirmsms', 'App\Http\Controllers\UserController@updatecomfirmsms');

Route::get('admin/pulluserdetail/{user}', 'App\Http\Controllers\AdminController@pulluserdetail');


Route::get('users/edit_field/{fieldid}', 'App\Http\Controllers\UserController@editfielddetail');
Route::put('users/edit_field/{fieldid}', 'App\Http\Controllers\UserController@updatefielddetail');

Route::get('users/senderid', 'App\Http\Controllers\UserController@senderid');
Route::post('users/processmultiplemsg/{list}', 'App\Http\Controllers\UserController@multipleprocessmsg');

Route::put('users/processmultiplemsgedit/{list}', 'App\Http\Controllers\UserController@multipleprocessmsgedit');

Route::get('users/download/{filename}/folder/{path}', 'App\Http\Controllers\UserController@download')->name('download');
Route::get('users/smsallcontacts/{list}/{type}', 'App\Http\Controllers\UserController@smsallcontact')->name('smsallcontacts');
Route::get('users/my_senderid', 'App\Http\Controllers\UserController@mysender');
Route::get('users/anniversary/delete/{ann}/{list}', 'App\Http\Controllers\UserController@deleteAnniversary');
Route::get('users/anniversarylist/delete/{list}', 'App\Http\Controllers\UserController@deleteanniversarylist');
Route::post('users/submitanniversaryupdate', 'App\Http\Controllers\UserController@submitanniversaryupdate');
Route::get('users/{list}/anniversary/{anntype}/{annid}', 'App\Http\Controllers\UserController@anniversaryexc');
Route::get('users/anniversary/today/{list}/{ann}/{annid}', 'App\Http\Controllers\UserController@todayannivlist');
Route::get('users/anniversary/tomorrow/{list}/{ann}/{annid}', 'App\Http\Controllers\UserController@tomorrowannivlist');
Route::get('users/anniversaryByMonths/{list}/{ann}/{annid}', 'App\Http\Controllers\UserController@anniversaryByMonth');
Route::get('users/annmonthExtract/{month}/{list}/{ann}/{annid}', 'App\Http\Controllers\UserController@annmonthExtract');

Route::get('admin/anniversary/today/{list}/{ann}/{annid}', 'App\Http\Controllers\AdminController@todayannivlist');
Route::get('admin/anniversary/tomorrow/{list}/{ann}/{annid}', 'App\Http\Controllers\AdminController@tomorrowannivlist');
Route::get('admin/anniversaryByMonths/{list}/{ann}/{annid}', 'App\Http\Controllers\AdminController@anniversaryByMonth');
Route::get('admin/annmonthExtract/{month}/{list}/{ann}/{annid}', 'App\Http\Controllers\AdminController@annmonthExtract');

Route::post('users/submitinfo', 'App\Http\Controllers\UserController@submitinfo');
Route::get('users/exportresponse', 'App\Http\Controllers\UserController@export');
Route::get('users/moreinfo', 'App\Http\Controllers\UserController@moreinfo');
Route::get('users/profile_view', 'App\Http\Controllers\UserController@profileview');
Route::post('users/profile_view', 'App\Http\Controllers\UserController@profilesubmit');
Route::get('users/create_form_stp2', 'App\Http\Controllers\UserController@form_step2')->name('formstp2');
Route::get('users/create_done_field', 'App\Http\Controllers\UserController@donefield')->name('donefield');
Route::get('users/create_done_field_edit', 'App\Http\Controllers\UserController@donefieldedit')->name('donefieldedit');

Route::get('users/custom_form_arrange', 'App\Http\Controllers\UserController@customarrange')->name('customarrange');
Route::post('users/custom_form_arrange', 'App\Http\Controllers\UserController@fieldarrange')->name('fieldarrange');

Route::get('users/custom_form_arrange_edit', 'App\Http\Controllers\UserController@customarrangeedit')->name('customarrangeedit');
Route::post('users/custom_form_arrange_edit', 'App\Http\Controllers\UserController@fieldarrangeedit')->name('fieldarrangeedit');

Route::get('users/custom_form_arrange_edit', 'App\Http\Controllers\UserController@customarrangeedit')->name('customarrangeedit');
Route::get('users/list_created/{list}', 'App\Http\Controllers\UserController@listcreated')->name('listcreated');

Route::get('users/form/delete', 'App\Http\Controllers\UserController@deletefrm');
Route::get('users/create_form_edit', 'App\Http\Controllers\UserController@formedit')->name('formedit');
Route::get('users/form_info_edit', 'App\Http\Controllers\UserController@forminfoedit')->name('forminfoedit');
Route::post('users/form_info_edit', 'App\Http\Controllers\UserController@form_info_update')->name('formupdate');


Route::get('users/create_form_sheet', 'App\Http\Controllers\UserController@form_step_sheet');
Route::get('users/removefield/{id}', 'App\Http\Controllers\UserController@removefield');
Route::post('users/processstate', 'App\Http\Controllers\UserController@processstate');
Route::post('users/pullfieldname', 'App\Http\Controllers\UserController@pullfieldname');
Route::get('users/new_field', 'App\Http\Controllers\UserController@newfield');
Route::post('users/new_field', 'App\Http\Controllers\UserController@addfield');
Route::get('users/response', 'App\Http\Controllers\UserController@response');

Route::post('users/response', 'App\Http\Controllers\UserController@deleterecord');

Route::get('users/resdetail/{id}', 'App\Http\Controllers\UserController@resdetail');
Route::get('users/response/delete/{id}', 'App\Http\Controllers\UserController@resdelete');



Route::get('users/new_field_edit', 'App\Http\Controllers\UserController@newfieldedit');
Route::post('users/new_field_edit', 'App\Http\Controllers\UserController@addfieldedit');

Route::get('form/{name}/{user}/{title}', 'App\Http\Controllers\UserController@displayform');
Route::post('form/{name}/{user}/{title}', 'App\Http\Controllers\UserController@postform');

Route::get('users/create_custom_field', 'App\Http\Controllers\UserController@customfield');
Route::post('users/create_custom_field', 'App\Http\Controllers\UserController@savecustomfield');

Route::get('users/create_custom_field_edit', 'App\Http\Controllers\UserController@customfieldedit');
Route::post('users/create_custom_field_edit', 'App\Http\Controllers\UserController@savecustomfield2');

Route::get('admin/sent_messages', 'App\Http\Controllers\AdminController@sentMessages');
Route::get('admin/smsdetail/{sms}', 'App\Http\Controllers\AdminController@smsdetail');
Route::get('admin/user_list', 'App\Http\Controllers\AdminController@userlist');

Route::post('users/processoption', 'App\Http\Controllers\UserController@processoption');
Route::post('users/displayprocessoption', 'App\Http\Controllers\UserController@displayprocessoption');
Route::post('users/processmenuoption', 'App\Http\Controllers\UserController@processmenuoption');


Route::post('users/displayprocessmenuoption', 'App\Http\Controllers\UserController@displayprocessmenuoption');

Route::post('users/deleteoption', 'App\Http\Controllers\UserController@deleteoption');
Route::post('users/deletemenuoption', 'App\Http\Controllers\UserController@deletemenuoption');



Route::get('admin/{list}/anniversary/{anntype}/{annid}', 'App\Http\Controllers\AdminController@anniversaryexc');


Route::get('users/collect_information', 'App\Http\Controllers\UserController@collectinfo')->name('collectinfo');
Route::get('users/create_form', 'App\Http\Controllers\UserController@createform');
Route::post('users/create_form', 'App\Http\Controllers\UserController@submitformfield');
Route::get('users/form_info', 'App\Http\Controllers\UserController@form_info');
Route::post('users/form_info', 'App\Http\Controllers\UserController@store_form_info');

Route::get('users/form_create', 'App\Http\Controllers\UserController@form_create')->name('form_create');



Route::get('admin/list', 'App\Http\Controllers\AdminController@list');
Route::get('admin/listDetail/{list}/{type}', 'App\Http\Controllers\AdminController@listDetail');
Route::get('admin/todayBirthday/{list}', 'App\Http\Controllers\AdminController@todayBirthday');
Route::get('admin/tomorrowBirthday/{list}', 'App\Http\Controllers\AdminController@tomorrowBirthday');
Route::get('admin/celebrantsByMonths/{list}', 'App\Http\Controllers\AdminController@celebByMonth');
Route::get('admin/scheduleList', 'App\Http\Controllers\AdminController@scheduleList');
Route::post('admin/createlist', 'App\Http\Controllers\AdminController@createList');
Route::post('admin/multiplecontact/{list}', 'App\Http\Controllers\AdminController@multiplecontact');
Route::get('admin/monthExtract/{month}/{list}', 'App\Http\Controllers\AdminController@monthExtract');
Route::get('admin/smsallcontacts/{list}/{type}', 'App\Http\Controllers\AdminController@smsallcontact')->name('smsallcontacts');
Route::get('admin/multipleupdate/{list}', 'App\Http\Controllers\AdminController@multipleupdate');
Route::get('admin/autosendtype', 'App\Http\Controllers\AdminController@autosendtype');
Route::post('admin/autosms', 'App\Http\Controllers\AdminController@autosms');
Route::get('admin/contacts/{list}/{type}', 'App\Http\Controllers\AdminController@listcontacts');
Route::post('admin/processmultiplemsg/{list}', 'App\Http\Controllers\AdminController@multipleprocessmsg');
Route::get('admin/done_list/{list}', 'App\Http\Controllers\AdminController@donelist');
Route::get('admin/scheduleUpdate/{list}/{type}', 'App\Http\Controllers\AdminController@scheduleupdate');
Route::get('admin/singleupdate/{list}', 'App\Http\Controllers\AdminController@singleupdate');
Route::get('admin/multipleupdate/{list}', 'App\Http\Controllers\AdminController@multipleupdate');
Route::put('admin/updatemultipleinfo', 'App\Http\Controllers\AdminController@multipleupdateinfo');
Route::post('admin/scheduleUpdate/{list}', 'App\Http\Controllers\AdminController@scheduleupdate2');
Route::get('admin/task/', 'App\Http\Controllers\AdminController@todaytask');
Route::get('admin/senderid/', 'App\Http\Controllers\AdminController@senderid');
Route::post('admin/senderidprocess', 'App\Http\Controllers\AdminController@processsenderid');
Route::get('admin/insertname/{sender}', 'App\Http\Controllers\AdminController@insertname');
Route::get('users/smsdetail/{sms}', 'App\Http\Controllers\UserController@smsdetail');
Route::post('users/resendsms', 'App\Http\Controllers\UserController@resend');
Route::post('users/createAnniversary', 'App\Http\Controllers\UserController@createAnniversary');

Route::post('users/sentMessages', 'App\Http\Controllers\UserController@filtermessage');


Route::middleware(['auth:sanctum', 'verified'])->get('admin/pullpilotdetail/{id}', 'App\Http\Controllers\AdminController@pullpilot');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/pilot/delete/{id}', 'App\Http\Controllers\AdminController@deletepilot');
Route::middleware(['auth:sanctum', 'verified'])->post('admin/perform-action', 'App\Http\Controllers\AdminController@performaction');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/pilot/{id}', 'App\Http\Controllers\AdminController@pilotdetail');
Route::middleware(['auth:sanctum', 'verified'])->put('admin/pilot/{id}', 'App\Http\Controllers\AdminController@editpilot');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/customers', 'App\Http\Controllers\AdminController@customers');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/customer/{id}', 'App\Http\Controllers\AdminController@customerdetail');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/online-status', 'App\Http\Controllers\AdminController@onlinestatus');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/orders', 'App\Http\Controllers\AdminController@customerorders');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/order-assign/{id}', 'App\Http\Controllers\AdminController@assignorders');
Route::middleware(['auth:sanctum', 'verified'])->put('admin/order-assign/{id}', 'App\Http\Controllers\AdminController@postassignorders');

Route::middleware(['auth:sanctum', 'verified'])->get('admin/accounts', 'App\Http\Controllers\AdminController@allaccounts');
Route::middleware(['auth:sanctum', 'verified'])->post('admin/accounts', 'App\Http\Controllers\AdminController@postaccounts');
Route::middleware(['auth:sanctum', 'verified'])->put('admin/editaccount', 'App\Http\Controllers\AdminController@editaccounts');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/pilots', 'App\Http\Controllers\AdminController@pilots');
Route::middleware(['auth:sanctum', 'verified'])->post('admin/pilots', 'App\Http\Controllers\AdminController@createnewpilot');


Route::middleware(['auth:sanctum', 'verified'])->get('admin', 'App\Http\Controllers\AdminController@index');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/pullaccountdetail/{user}', 'App\Http\Controllers\AdminController@pullaccountdetail');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/account/delete/{id}', 'App\Http\Controllers\AdminController@deleteaccount');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/account/delete/{id}', 'App\Http\Controllers\AdminController@deleteaccount');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/new_pilot/', 'App\Http\Controllers\AdminController@newpilot');


Route::middleware(['auth:sanctum', 'verified'])->post('admin/new_pilot/', 'App\Http\Controllers\AdminController@postnewpilot');
Route::middleware(['auth:sanctum', 'verified'])->get('admin/real-time-track/', 'App\Http\Controllers\AdminController@locationtrack');



////////APIs//////////////////
Route::get('api/checkifexist/{phone}', 'App\Http\Controllers\AdminController@checkexist');
Route::get('api/sendotp/{phone}', 'App\Http\Controllers\AdminController@sendotp');
Route::get('api/otppairing/{phone}/{otp}', 'App\Http\Controllers\AdminController@otppairing');
Route::post('api/registration', 'App\Http\Controllers\AdminController@registerrider');
Route::get('api/ifemailexist/{phone}/', 'App\Http\Controllers\AdminController@ifemailexist');

Route::get('api/go_online_status/{riderid}/', 'App\Http\Controllers\AdminController@go_online_status');

