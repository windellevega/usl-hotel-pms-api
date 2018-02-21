<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
----------------------------
ROUTES FOR ROOM METHODS
----------------------------
*/

//Display all rooms
Route::get('/rooms', [
    'as' => 'rooms-list',
    'uses' => 'RoomController@index'
]);

//Add new room
Route::post('/room/add', [
    'as' => 'room-add',
    'uses' => 'RoomController@store'
]);

//Display specific room detail
//@parameter: id - room id
Route::get('/room/{id}', [
    'as' => 'room-show',
    'uses' => 'RoomController@show'
]);

//Update room information
//@parameter: id - room id
Route::patch('/room/update/{id}', [
    'as' => 'room-update',
    'uses' => 'RoomController@update'
]);

//Change room status
//@parameter: id = room id
Route::patch('room/changestatus/{id}', [
    'as' => 'room-changestatus',
    'uses' => 'RoomController@changeStatus'
]);


/*
----------------------------
ROUTES FOR COMPANY METHODS
----------------------------
*/

//Display all companies
Route::get('/companies', [
    'as' => 'companies-list',
    'uses' => 'CompanyController@index'
]);

//Add new company
Route::post('/company/add', [
    'as' => 'company-add',
    'uses' => 'CompanyController@store'
]);

//Display specific company detail
Route::get('/company/{id}', [
    'as' => 'company-show',
    'uses' => 'CompanyController@show'
]);

//Update company information
Route::patch('/company/update/{id}', [
    'as' => 'company-update',
    'uses' => 'RoomController@update'
]);


/*
----------------------------
ROUTES FOR GUEST METHODS
----------------------------
*/

//Display all guests
Route::get('/guests', [
    'as' => 'guests-list',
    'uses' => 'GuestController@index'
]);

//Add new guest
Route::post('/guest/add', [
    'as' => 'guest-add',
    'uses' => 'GuestController@store'
]);

//Display specific guest detail
//@parameter: id - guest id
Route::get('/guest/{id}', [
    'as' => 'guest-show',
    'uses' => 'GuestController@show'
]);

//Update guest information
//@parameter: id - guest id
Route::patch('/guest/update/{id}', [
    'as' => 'guest-update',
    'uses' => 'GuestController@update'
]);


/*
----------------------------
ROUTES FOR BOOKING METHODS
----------------------------
*/

//Display all bookings
Route::get('/bookings', [
    'as' => 'bookings-list',
    'uses' => 'BookingController@showBookings'
]);

//Display all reservations
Route::get('/reservations', [
    'as' => 'resevations-list',
    'uses' => 'BookingController@showReservations'
]);

//Add new booking
Route::post('/booking/add', [
    'as' => 'booking-add',
    'uses' => 'BookingController@book'
]);

//Add new reservation
Route::post('/reservation/add', [
    'as' => 'reservation-add',
    'uses' => 'BookingController@reserve'
]);

//Show booking or reservation detail
//@parameter: id - booking id
Route::get('/booking/{id}', [
    'as' => 'booking-show',
    'uses' => 'BookingController@show'
]);

/*
----------------------------
ROUTES FOR OTHER CHARGE METHODS
----------------------------
*/

//Add new instance of other charge
Route::post('/othercharge/add', [
    'as' => 'othercharge-add',
    'uses' => 'OtherCharge@store'
]);

//Delete instance of ther charge
Route::delete('/othercharge/delete', [
    'as' => 'othercharge-delete',
    'uses' => 'OtherCharge@delete'
]);

