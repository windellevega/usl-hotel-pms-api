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

/**
 * -------------------------
 * ROUTES FOR ROOM METHODS
 * -------------------------
 */

/**
 * Get all rooms
 */
Route::get('/rooms', [
    'as' => 'rooms-list',
    'uses' => 'RoomController@index'
]);

/**
 * Add new room
 */
Route::middleware('auth:api')->post('/room', [
    'as' => 'room-add',
    'uses' => 'RoomController@store'
]);

/**
 * Get specific room detail
 * @param: id - room id
 */
Route::middleware('auth:api')->get('/room/{id}', [
    'as' => 'room-show',
    'uses' => 'RoomController@show'
]);

/**
 * Update room information
 * @param: id - room id
 */
Route::middleware('auth:api')->patch('/room/{id}', [
    'as' => 'room-update',
    'uses' => 'RoomController@update'
]);

/**
 * Change room status
 * @param: id = room id
 */
Route::middleware('auth:api')->post('room/changestatus/{id}', [
    'as' => 'room-changestatus',
    'uses' => 'RoomController@changeStatus'
]);

/**
 * Get room reservation dates
 * @param: id = room id
 */
Route::middleware('auth:api')->get('room/reservationdates/{id}', [
    'as' => 'room-reservationdates',
    'uses' => 'RoomController@showReservationDates'
]);


/**
 * ---------------------------
 * ROUTES FOR COMPANY METHODS
 * ---------------------------
 */

/**
 * Get all companies
 */
Route::middleware('auth:api')->get('/companies', [
    'as' => 'companies-list',
    'uses' => 'CompanyController@index'
]);

/**
 * Add new company
 */
Route::middleware('auth:api')->post('/company', [
    'as' => 'company-add',
    'uses' => 'CompanyController@store'
]);

/**
 * Get specific company detail
 * @param: id - company id
 */
Route::middleware('auth:api')->get('/company/{id}', [
    'as' => 'company-show',
    'uses' => 'CompanyController@show'
]);

/**
 * Update company information
 * @param: id - company id
 */
Route::middleware('auth:api')->patch('/company/{id}', [
    'as' => 'company-update',
    'uses' => 'CompanyController@update'
]);


/**
 * --------------------------
 * ROUTES FOR GUEST METHODS
 * --------------------------
 */

/**
 * Get all guests
 */
Route::get('/guests', [
    'as' => 'guests-list',
    'uses' => 'GuestController@index'
]);

/**
 * Add new guest
 */
Route::middleware('auth:api')->post('/guest', [
    'as' => 'guest-add',
    'uses' => 'GuestController@store'
]);

/** 
 * Get specific guest detail
 * @param: id - guest id
 */
Route::middleware('auth:api')->get('/guest/{id}', [
    'as' => 'guest-show',
    'uses' => 'GuestController@show'
]);

/** 
 * Update guest information
 * @param: id - guest id
 */
Route::middleware('auth:api')->patch('/guest/{id}', [
    'as' => 'guest-update',
    'uses' => 'GuestController@update'
]);

/**
 * Get all guest types
 */
Route::middleware('auth:api')->get('/guesttypes', [
    'as' => 'guesttypes-list',
    'uses' => 'GuestController@getGuestTypes'
]);

/**
 * Add guest type
 */
Route::middleware('auth:api')->post('/guesttype', [
    'as' => 'guesttype-add',
    'uses' => 'GuestController@addGuestType'
]);

/**
 * Delete guest infomation
 * @param = id - guest id
 */
Route::middleware('auth:api')->delete('/guest/{id}', [
    'as' => 'guest-delete',
    'uses' => 'GuestController@destroy'
]);


/** 
 * ----------------------------
 * ROUTES FOR BOOKING METHODS
 * ----------------------------
 */

/**
 * Get all bookings
 */
Route::middleware('auth:api')->get('/bookings', [
    'as' => 'bookings-list',
    'uses' => 'BookingController@getBookings'
]);

/**
 * Get all reservations
 */
Route::middleware('auth:api')->get('/reservations', [
    'as' => 'resevations-list',
    'uses' => 'BookingController@getReservations'
]);

/**
 * Add new booking
 */
Route::middleware('auth:api')->post('/booking', [
    'as' => 'booking-add',
    'uses' => 'BookingController@book'
]);

/**
 * Add new reservation
 */
Route::middleware('auth:api')->post('/reservation', [
    'as' => 'reservation-add',
    'uses' => 'BookingController@reserve'
]);

/**
 * Show booking or reservation detail
 * @param: id - booking id
 */
Route::middleware('auth:api')->get('/booking/{id}', [
    'as' => 'booking-show',
    'uses' => 'BookingController@show'
]);

/**
 * Show booking or reservation detail for a particular room
 * @param: id - room id
 */
Route::middleware('auth:api')->get('/booking-by-room/{id}', [
    'as' => 'booking-by-room-show',
    'uses' => 'BookingController@showBookingByRoom'
]);

/**
 * Show booking types
 */
Route::middleware('auth:api')->get('/bookingtypes', [
    'as' => 'bookingtype-show',
    'uses' => 'BookingController@getBookingTypes'
]);

/**
 * Update reservation detail
 * @param: id - booking id
 */
Route::middleware('auth:api')->patch('/reservation/{id}', [
    'as' => 'reservation-update',
    'uses' => 'BookingController@updateReservation'
]);

/**
 * Delete booking/reservation
 * @param: id - booking id
 */
Route::middleware('auth:api')->delete('/booking/{id}', [
    'as' => 'booking-delete',
    'uses' => 'BookingController@destroy'
]);

/**
 * Check-out booking
 * @param: id - booking id
 */
Route::middleware('auth:api')->patch('/booking/check-out/{id}', [
    'as' => 'booking-check-out',
    'uses' => 'BookingController@checkout'
]);

/**
 * Modify bookingcharge
 * @param: id - booking id
 */
Route::middleware('auth:api')->patch('/booking/bookingcharge/{id}', [
    'as' => 'bookingcharge-update',
    'uses' => 'BookingController@modifyBookingCharge'
]);


/**
 * --------------------------------
 * ROUTES FOR OTHER CHARGE METHODS
 * --------------------------------
 */

/**
 * Add new instance of other charge
 */
Route::middleware('auth:api')->post('/othercharge', [
    'as' => 'othercharge-add',
    'uses' => 'OtherChargeController@store'
]);

/**
 * Delete instance of ther charge
 * @param: id - other charges id
 */
Route::middleware('auth:api')->delete('/othercharge/{id}', [
    'as' => 'othercharge-delete',
    'uses' => 'OtherChargeController@destroy'
]);

/**
 * Get all other charges information
 * @param: id - billing id
 */
Route::middleware('auth:api')->get('/othercharges/{id}', [
    'as' => 'othercharges-show',
    'uses' => 'OtherChargeController@show'
]);

/**
 * ------------------------
 * ROUTES FOR USER METHODS
 * ------------------------
 */

 /**
  * Get all user information
  */
  Route::get('/users', [
      'as' => 'users-list',
      'uses' => 'UserController@index'
  ]);
  
  /**
   * Add user information
   */
  Route::middleware('auth:api')->post('/user', [
      'as' => 'user-add',
      'uses' => 'UserController@store'
  ]);

  /**
   * Edit user information
   * @param: id - user id
   */
  Route::middleware('auth:api')->patch('/user/{id}', [
      'as' => 'user-update',
      'uses' => 'UserController@update'
  ]);

  /**
   * Delete user
   * @param: id - user id
   */
  Route::middleware('auth:api')->delete('/user/{id}', [
      'as' => 'user-delete',
      'uses' => 'UserController@destroy'
  ]);