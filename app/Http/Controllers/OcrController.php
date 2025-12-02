<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OcrService;

class OcrController extends Controller
{
    protected $ocr;

    public function __construct(OcrService $ocr)
    {
        $this->ocr = $ocr;
    }


    public function extract(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png'
        ]);

        $path = $request->file('file')->store('receipts', 'public');
        $fullPath = storage_path('app/public/' . $path);

        $data = $this->ocr->extract($fullPath);

        return response()->json([
            'status' => 'success',
            'message' => 'OCR extraction completed',
            'data' => $data
        ]);
    }
}
