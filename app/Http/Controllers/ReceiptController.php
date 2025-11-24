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
        return response()->json(Receipt::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'company_name' => 'required|string',
            'product_name' => 'required|string',
            'amount_paid' => 'required|numeric',
            'customer_name' => 'required|string'
        ]);

        $receipt = Receipt::create($fields);

        return response()->json($receipt);
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        return response()->json($receipt);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receipt $receipt)
    {
        $fields = $request->validate([
            'company_name' => 'string',
            'product_name' => 'string',
            'amount_paid' => 'numeric',
            'customer_name' => 'string'
        ]);

        $receipt->update($fields);

        return response()->json($receipt);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        $receipt->delete();

        return response()->json(['message' => 'Receipt deleted successfully']);
    }
}
