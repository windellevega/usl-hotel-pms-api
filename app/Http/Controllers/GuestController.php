<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Guest;
use App\GuestType;
use App\Company;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guests = Guest::with([
            'Company' => function($q) {
                $q->select('id','companyname');
            },
            'GuestType' => function($q) {
                $q->select('id','guesttype');
            }
        ])->get();

        if($guests->count() <= 0) {
            return response()->json([
                'message' => 'No guests found.'
            ]);
        }

        return response()->json($guests);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'gtypeid' => 'required',
            'contactno' => 'numeric|regex:/(09)[0-9]{9}/',
            'companyid' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $guest = new Guest();

        $guest->firstname = $request->firstname;
        $guest->lastname = $request->lastname;
        $guest->guesttype_id = $request->gtypeid;
        $guest->contactno = $request->contactno;
        $guest->company_id = $request->companyid;

        $guest->save();

        return response()->json([
            'message' => 'Guest added successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guest = Guest::where('id', $id)
                        ->get();
        $guest->load('GuestType');
        $guest->load('Company');

        if($guest->count() <= 0) {
            return response()->json([
                'message' => 'Guest not found.'
            ]);
        }
        return response()->json($guest);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'gtypeid' => 'required',
            'contactno' => 'numeric|regex:/(09)[0-9]{9}/',
            'companyid' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $guest = Guest::where('id', $id)
                    ->first();

        $guest->firstname = $request->firstname;
        $guest->lastname = $request->lastname;
        $guest->guesttype_id = $request->gtypeid;
        $guest->contactno = $request->contactno;
        $guest->company_id = $request->companyid;

        $guest->save();

        return response()->json([
            'message' => 'Guest updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
