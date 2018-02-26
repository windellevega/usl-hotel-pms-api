<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();

        if($companies->count() <= 0) {
            return response()->json([
                'message' => 'No companies found.'
            ]);
        }

        return response()->json($companies);
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
            'name' => 'required|unique:companies,companyname'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $company = new Company();

        $company->companyname = $request->name;

        $company->save();

        return response()->json([
            'message' => 'Company added successfully.'
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
        $company = Company::where('id', $id)
                        ->get();
        if($company->count() <= 0) {
            return response()->json([
                'message' => 'Company not found.'
            ]);
        }
        return response()->json($company);
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
            'name' => 'required|unique:companies,companyname'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $company = Company::find($id);

        $company->companyname = $request->name;

        $company->save();

        return response()->json([
            'message' => 'Company information updated successfully.'
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
