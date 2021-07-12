<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/clear-cache-all', function() {

    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');

    dd("Cache Clear All");

});
Route::get('/create/folder/link', function() {

    Artisan::call('storage:link');

    dd("created link");

});


Route::get('getCountry','ProvinceStatesController@getCountry');
Route::get('getCountryStates','CountryStatesController@getCountryStates');
Route::get('getExperiences','ExperiencesController@getExperiences');
Route::get('getExperiencesActive','ExperiencesController@getExperiencesActive');
Route::get('getTimeType','TimeTypeController@getTimeType');
Route::get('getTimeCurrency','CurrencyController@getCurrency');
Route::get('getCommonTiming','CommonTimingController@getCommonTiming');
Route::get('getCurrencyArr','CurrencyController@getCurrencyArr');

Route::group(['namespace' => 'Tools','middleware' => ['cors']], function() {
    Route::get('user/profile/{token}','UserProfileController@userProfile');
    Route::get('pub/{token}','PubController@pub');
});

Route::group(['namespace' => 'Auth'], function() {
	Route::post('register', 'RegisterController@register');
	Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name
	Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
	Route::post('login', 'AuthController@login');
    Route::post('forgot-password', 'ForgotPasswordController@forgotPassword');
    Route::post('reset-password', 'ForgotPasswordController@reset');
    Route::get('abilities','AbilitiesController@abilities');
});

Route::group(['namespace' => 'Subscriptions','middleware' => ['auth.api','UserType']], function() {
    Route::get('plan-create','PlansController@create');
    Route::get('plan-details/{plane}/{type}','PlansController@getDetails');
    Route::get('plan-feature-value/{subscription}/{feature}','PlansController@getFeatureValue');
    Route::get('plan-create-subscription/{plane}/{subscription}/{user}','PlansController@creatSubscription');
    Route::get('plan-change-subscription/{plane}/{subscription}','PlansController@changePlanSubscription');
    Route::get('plan-subscription-feature-usage/{type}/{subscription}/{feature}/{user}','PlansController@subscriptionFeatureUsage');
    Route::get('plan-subscription-record-feature-usage/{type}/{subscription}/{feature}/{user}/{value}','PlansController@recordFeatureUsage');
    Route::get('plan-subscription-record-feature-cleare/{subscription}/{user}','PlansController@recordFeatureCleare');
    Route::get('plan-subscription-check-status/{type}/{subscription}/{feature}/{user}','PlansController@checkSubscriptionStatus');
    Route::get('plan-subscription-renew/{type}/{subscription}/{user}','PlansController@renewSubscription');
    Route::get('plan-get-plans','PlansController@getPlans');
    Route::post('plan-pre-subscription','PlansController@preSubscription');
    Route::get('plan-get-invoice','PlansController@getInvoice');
    Route::get('plan-get-invoices','PlansController@getInvoices');
    Route::get('plan-get-user-plan/{user}','PlansController@getUserPlan');
    Route::post('plan-subscription','PlansController@applyInvoce');
    Route::get('plan-get-full','PlansController@getPlansFull');
    Route::get('plan-get-feature/{id}','PlansController@getFeature');
});

Route::group(['namespace' => 'Auth','middleware' => ['auth.api','UserType']], function() {
    Route::post('logout', 'AuthController@logout');
    Route::post('logoutAll', 'AuthController@logoutAll');
    Route::get('userMode/{mode}','ToolsController@mode');
    Route::get('userLocale/{locale}','ToolsController@locale');
    Route::get('userGetLocale','ToolsController@getLocale');
    Route::get('userModeGet','ToolsController@getMode');
    Route::get('getUserData','ToolsController@getUserData');
    Route::post('change-password', 'AuthController@changePassword');
    Route::post('userEdit', 'EditUserController@userEdit');
    Route::post('tools/use/avatar','ToolsController@avatar');

});


Route::group(['namespace' => 'Helpers','middleware' => ['auth.api','UserType']], function() {
	Route::post('filePicture','FilesController@filePicture');
	Route::post('fileOtherFormat','FilesController@fileOtherFormat');
	Route::post('createComments','CommentsController@createComments');
	Route::get('getComments/{table}/{source_id}','CommentsController@getComments');
});

Route::group(['namespace' => 'Chefe','middleware' => ['auth.api','CheckStatus','UserType']], function() {
	Route::post('create/cv','CVController@createCV');
	Route::get('getCVData/{id}','CVController@getCVData');
	//experience
	Route::post('chefe/experience/new','ExperienceController@create');
	Route::get('chefe/experience/getThis','ExperienceController@getThis');
	Route::get('chefe/experience/get/{id}','ExperienceController@getThisId');
	Route::get('chefe/experience/delete/{id}','ExperienceController@delete');
	Route::post('chefe/experience/update/{id}','ExperienceController@update');
	//school

	Route::post('chefe/school/new','SchoolController@create');
	Route::get('chefe/school/getThis','SchoolController@getThis');
	Route::get('chefe/school/get/{id}','SchoolController@getThisId');
	Route::get('chefe/school/delete/{id}','SchoolController@delete');
	Route::post('chefe/school/update/{id}','SchoolController@update');
	//references

	Route::post('create/references','ReferencesController@create');
	Route::get('getContactData/{id}','ReferencesController@getData');
	//files
	Route::post("chefe/files/new",'FilesChefeController@create');
	Route::get('chefe/files/getThis','FilesChefeController@getThis');
	Route::get('chefe/file/get/{key}','FilesChefeController@getThisId');
	Route::get('chefe/file/delete/{key}','FilesChefeController@delete');
	Route::get('chefe/file/getAllData','FilesChefeController@getAllData');

});



Route::group(['namespace' => 'Chefe','middleware' => ['auth.api']], function() {
	Route::get('getAllCVData','CVController@getAllCVData');

});


Route::group(['namespace' => 'Tools','middleware' => ['auth.api','UserType']], function() {
	Route::get('getThisMealPrices/{idMeal}','ToolsController@getThisMealPrices');
	Route::post('tools/experience/update/{key}','ExperienceController@update');
	Route::post('tools/experience/create','ExperienceController@create');
	Route::post('tools/experience/status/{status}','ExperienceController@status');
	Route::get('getUsersList','UserListController@getUsersList');
	Route::post('tools/users/update/{key}','UserListController@UserUpdate');
	Route::get('getRoles','RolesPermissionsController@getRoles');
	Route::get('getPermissions','RolesPermissionsController@getPermissions');
    Route::post('role/create','RolesPermissionsController@createRole');
    Route::get('role/delete/{id}','RolesPermissionsController@deleteRole');
    Route::get('getUserRoles/{key}','RolesPermissionsController@getUserRoles');
    Route::post('roles/users/create/{id}','RolesPermissionsController@setUserRoles');
	Route::get('grafUser','UserListController@grafUser');
    Route::post('plan-create-validate','PlansController@create');
    Route::get('plan-delete/{id}','PlansController@delete');
    Route::get('plan-restor-delete/{id}','PlansController@recoverPlan');
    Route::post('plan-features-save','PlansController@createFeatures');
	Route::get('contact/get/messages','MessageController@getMessages');

});

Route::group(['namespace' => 'Meal','middleware' => []], function() {
	Route::get('getPagmMalsW','GetMealWelcomeController@getPagmMals');
	Route::get('getPagmMalsSearchW/{search}','GetMealWelcomeController@searchMeals');

});


Route::group(['namespace' => 'Wellcome','middleware' => []], function() {//not
	Route::post('contact/send/message','MessageController@sendMessage');

});

Route::group(['namespace' => 'Meal','middleware' => ['auth.api','UserType','CheckStatus','SetLocaleDynamically','cors']], function() {
	Route::get('GetMeals','GetMealController@getAllMeals');
	Route::get('getMealsV2/{currency}','GetMealController@getMealsV2');
	Route::get('getPagmMals','GetMealController@getPagmMals');
	Route::get('getPagmMalsSearch/{search}','GetMealController@searchMeals');
	Route::post('create/meal','CreateMealController@newMeal');
	Route::post('update/meal/{id}','UpdateMealController@updateMeal');
	Route::get('getThisMeal/{idMeal}','GetMealController@getThisMeal');
	Route::get('getThisMealPrices/{idMeal}','GetMealController@getThisMealPrices');
	Route::get('getMealType','GetMealController@getMealType');
	Route::post('meal/price/new/{idMeal}','CreateMealController@addprices');
	Route::post('meal/price/status/{status}','CreateMealController@pricesStatus');
    Route::get('grafPost','GetMealController@getPost');
    Route::get('grafPosts','GetMealController@getPosts');
    Route::get('getPostRead','GetMealController@getPostRead');
    Route::get('getPostsReads','GetMealController@getPostsReads');

});

Route::group(['namespace' => 'Cuisines','middleware' => ['auth.api','UserType']], function() {
	Route::get('getCuisines','CuisinesController@getCuisines');
	Route::get('getCuisinesV2','CuisinesController@getCuisinesV2');

});

Route::group(['namespace' => 'Options','middleware' => ['auth.api','UserType']], function() {
	Route::get('getOptions','OptionsController@getOptions');

});


Route::group(['namespace' => 'Kitchen','middleware' => ['auth.api','UserType']], function() {
	Route::post('createKitchen','KitchenController@createKitchen');
	Route::get('getKitchen/{user_id}','KitchenController@getKitchen');

});


Route::group(['namespace' => 'Booking','middleware' => ['auth.api','UserType']], function() {
	Route::post('createBooking','BookingController@createBooking');

});

Route::group(['namespace' => 'Tags','middleware' => ['auth.api','UserType']], function() {
	Route::get('getTags/{type}','TagsController@getTags');

});
Route::group(['namespace' => 'Ingredients','middleware' => ['auth.api','UserType']], function() {
	Route::get('getIngredients','IngredientsController@getIngredients');

});
