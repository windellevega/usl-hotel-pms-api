<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OtherCharge;
use App\Billing;

class OtherChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'othercharge_info' => 'required',
            'cost' => 'numeric',
            'billingid' => 'required',
            'quantity' => 'required | numeric'
        ]);

        
        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $othercharge = OtherCharge::where('othercharge_info', $request->othercharge_info)
                        ->where('billing_id', $request->billingid)
                        ->first();

        if($othercharge) {
            $othercharge->quantity += $request->quantity;
        }
        else {
            $othercharge = new OtherCharge();

            $othercharge->othercharge_info = $request->othercharge_info;
            $othercharge->cost = $request->cost;
            $othercharge->quantity = $request->quantity;
            $othercharge->billing_id = $request->billingid;
        }

        $othercharge->save();

        $billing = Billing::find($request->billingid);

        $billing->totalcharges += $othercharge->cost * $request->quantity;

        $billing->save();

        return response()->json([
            'message' => 'Other charge added successfully.'
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
        $othercharges = OtherCharge::where('billing_id', $id)
                        ->get();
        return response()->json($othercharges);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $othercharge = OtherCharge::find($id);
        
        $billing = Billing::find($othercharge->billing_id);
        $billing->totalcharges -= $othercharge->cost * $othercharge->quantity;
        $billing->save();

        $othercharge->delete();

        return response()->json([
            'message' => 'Other charge was removed.'
        ]);
    }
}
