<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        if($users->count() <= 0) {
            return response()->json([
                'message' => 'No companies found.'
            ]);
        }

        return response()->json($users);
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
            'username' => 'required | unique:users,username',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();

        return response()->json([
            'message' => 'User registered successfully.'
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
            'oldpassword' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $user = User::find($id);

        if(!Hash::check($request->oldpassword, $user->password)) {
            $validator->getMessageBag()->add('oldpassword', 'Old password is incorrect.');
            return response()->json($validator->errors()->all());
        }

        if(Hash::check($request->password, $user->password)) {
            $validator->getMessageBag()->add('oldpassword', 'Old password must not be used.');
            return response()->json($validator->errors()->all());
        }
        
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();

        return response()->json([
            'message' => 'User information updated successfully.'
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
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message' => 'User has been deleted.'
        ]);
    }
}
