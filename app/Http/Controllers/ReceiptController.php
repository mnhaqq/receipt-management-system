<?php

namespace App\Http\Controllers;


use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;

class ReceiptController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

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
            'vendor_name'   => 'required|string',
            'total_amount'  => 'required|numeric',
            'purchase_date' => 'date',
            'category'      => 'string|nullable',
            'notes'         => 'string|nullable',
        ]);

        $receipt = $request->user()->receipts()->create($fields);

        return response()->json($receipt, 201);
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
        Gate::authorize('modify', $receipt);

        $fields = $request->validate([
            'vendor_name' => 'string',
            'total_amount' => 'numeric',
            'purchase_date' => 'date',
            'category' => 'string',
            'notes' => 'string'
        ]);

        $receipt->update($fields);

        return response()->json($receipt);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        Gate::authorize('modify', $receipt);
        
        $receipt->delete();

        return response()->json(['message' => 'Receipt deleted successfully']);
    }
}
