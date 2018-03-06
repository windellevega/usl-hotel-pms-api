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
Route::middleware('auth:api')->get('/rooms', [
    'as' => 'rooms-list',
    'uses' => 'RoomController@index'
]);

//Add new room
Route::middleware('auth:api')->post('/room/add', [
    'as' => 'room-add',
    'uses' => 'RoomController@store'
]);

//Display specific room detail
//@parameter: id - room id
Route::middleware('auth:api')->get('/room/{id}', [
    'as' => 'room-show',
    'uses' => 'RoomController@show'
]);

//Update room information
//@parameter: id - room id
Route::middleware('auth:api')->patch('/room/{id}', [
    'as' => 'room-update',
    'uses' => 'RoomController@update'
]);

//Change room status
//@parameter: id = room id
Route::middleware('auth:api')->post('room/changestatus/{id}', [
    'as' => 'room-changestatus',
    'uses' => 'RoomController@changeStatus'
]);

//Get room reservation dates
//@parameter: id = room id
Route::middleware('auth:api')->get('room/reservationdates/{id}', [
    'as' => 'room-reservationdates',
    'uses' => 'RoomController@showReservationDates'
]);


/*
----------------------------
ROUTES FOR COMPANY METHODS
----------------------------
*/

//Display all companies
Route::middleware('auth:api')->get('/companies', [
    'as' => 'companies-list',
    'uses' => 'CompanyController@index'
]);

//Add new company
Route::middleware('auth:api')->post('/company', [
    'as' => 'company-add',
    'uses' => 'CompanyController@store'
]);

//Display specific company detail
Route::middleware('auth:api')->get('/company/{id}', [
    'as' => 'company-show',
    'uses' => 'CompanyController@show'
]);

//Update company information
Route::middleware('auth:api')->patch('/company/{id}', [
    'as' => 'company-update',
    'uses' => 'CompanyController@update'
]);


/*
----------------------------
ROUTES FOR GUEST METHODS
----------------------------
*/

//Display all guests
Route::middleware('auth:api')->get('/guests', [
    'as' => 'guests-list',
    'uses' => 'GuestController@index'
]);

//Add new guest
Route::middleware('auth:api')->post('/guest/add', [
    'as' => 'guest-add',
    'uses' => 'GuestController@store'
]);

//Display specific guest detail
//@parameter: id - guest id
Route::middleware('auth:api')->get('/guest/{id}', [
    'as' => 'guest-show',
    'uses' => 'GuestController@show'
]);

//Update guest information
//@parameter: id - guest id
Route::middleware('auth:api')->patch('/guest/{id}', [
    'as' => 'guest-update',
    'uses' => 'GuestController@update'
]);


/*
----------------------------
ROUTES FOR BOOKING METHODS
----------------------------
*/

//Display all bookings
Route::middleware('auth:api')->get('/bookings', [
    'as' => 'bookings-list',
    'uses' => 'BookingController@getBookings'
]);

//Display all reservations
Route::middleware('auth:api')->get('/reservations', [
    'as' => 'resevations-list',
    'uses' => 'BookingController@getReservations'
]);

//Add new booking
Route::middleware('auth:api')->post('/booking', [
    'as' => 'booking-add',
    'uses' => 'BookingController@book'
]);

//Add new reservation
Route::middleware('auth:api')->post('/reservation', [
    'as' => 'reservation-add',
    'uses' => 'BookingController@reserve'
]);

//Show booking or reservation detail
//@parameter: id - booking id
Route::middleware('auth:api')->get('/booking/{id}', [
    'as' => 'booking-show',
    'uses' => 'BookingController@show'
]);

//Show booking or reservation detail for a particular room
//@parameter: id - room id
Route::middleware('auth:api')->get('/booking-by-room/{id}', [
    'as' => 'booking-by-room-show',
    'uses' => 'BookingController@showBookingByRoom'
]);

//Show booking types
Route::middleware('auth:api')->get('/bookingtypes', [
    'as' => 'bookingtype-show',
    'uses' => 'BookingController@getBookingTypes'
]);

//Update reservation detail
//@parameter: id - booking id
Route::middleware('auth:api')->patch('/reservation/{id}', [
    'as' => 'reservation-update',
    'uses' => 'BookingController@updateReservation'
]);

//Delete booking/reservation
//@parameter: id - booking id
Route::middleware('auth:api')->delete('/booking/{id}', [
    'as' => 'booking-delete',
    'uses' => 'BookingController@destroy'
]);

/*
----------------------------
ROUTES FOR OTHER CHARGE METHODS
----------------------------
*/

//Add new instance of other charge
Route::middleware('auth:api')->post('/othercharge', [
    'as' => 'othercharge-add',
    'uses' => 'OtherChargeController@store'
]);

//Delete instance of ther charge
Route::middleware('auth:api')->delete('/othercharge/{id}', [
    'as' => 'othercharge-delete',
    'uses' => 'OtherChargeController@destroy'
]);
