<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReceiptRequest;
use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Receipt::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'company_name' => 'required',
            'product_name' => 'required',
            'amount_paid' => 'required',
            'customer_name' => 'required'
        ]);

        $receipt = Receipt::create($fields);

        return ['receipt' => $receipt];
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        return ['receipt' => $receipt];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
}
