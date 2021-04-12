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

Route::group(['namespace' => 'Tools','middleware' => []], function() {
    Route::get('user/profile/{token}','UserProfileController@userProfile');
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


Route::group(['namespace' => 'Auth','middleware' => ['auth.api']], function() {
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


Route::group(['namespace' => 'Helpers','middleware' => []], function() {
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


Route::group(['namespace' => 'Meal','middleware' => ['auth.api','CheckStatus','UserType']], function() {


});

Route::group(['namespace' => 'Chefe','middleware' => ['auth.api','CheckStatus','UserType','CheckChefe']], function() {

});

//move to middleware


Route::group(['namespace' => 'Chefe','middleware' => []], function() {
	Route::get('getAllCVData','CVController@getAllCVData');

});


Route::group(['namespace' => 'Tools','middleware' => []], function() {
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
});

Route::group(['namespace' => 'Meal','middleware' => []], function() {
	Route::get('getPagmMalsW','GetMealWelcomeController@getPagmMals');
	Route::get('getPagmMalsSearchW/{search}','GetMealWelcomeController@searchMeals');

});


Route::group(['namespace' => 'Wellcome','middleware' => []], function() {
	Route::post('contact/send/message','MessageController@sendMessage');

});

Route::group(['namespace' => 'Meal','middleware' => []], function() {
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

});

Route::group(['namespace' => 'Cuisines','middleware' => []], function() {
	Route::get('getCuisines','CuisinesController@getCuisines');
	Route::get('getCuisinesV2','CuisinesController@getCuisinesV2');

});

Route::group(['namespace' => 'Options','middleware' => []], function() {
	Route::get('getOptions','OptionsController@getOptions');

});


Route::group(['namespace' => 'Kitchen','middleware' => []], function() {
	Route::post('createKitchen','KitchenController@createKitchen');
	Route::get('getKitchen/{user_id}','KitchenController@getKitchen');

});


Route::group(['namespace' => 'Booking','middleware' => []], function() {
	Route::post('createBooking','BookingController@createBooking');

});

Route::group(['namespace' => 'Tags','middleware' => []], function() {
	Route::get('getTags/{type}','TagsController@getTags');

});
Route::group(['namespace' => 'Ingredients','middleware' => []], function() {
	Route::get('getIngredients','IngredientsController@getIngredients');

});
