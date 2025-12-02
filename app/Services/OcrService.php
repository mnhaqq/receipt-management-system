<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrService
{
    public function extract(string $fullPath): array
    {
        $text = (new TesseractOCR($fullPath))
                    ->lang('eng')
                    ->oem(3)
                    ->run();

        return [
            'raw_text' => $text,
            'vendor_name' => $this->extractVendor($text),
            'total_amount' => $this->extractTotal($text),
            'purchase_date' => $this->extractDate($text),
            'category' => $this->guessCategory($text),
        ];
    }

    private function extractVendor(string $text)
    {
        $lines = array_filter(array_map('trim', explode("\n", $text)));

        return $lines[0] ?? null;
    }

    private function extractTotal(string $text)
    {
        preg_match('/(GHC|GHS|GH₵)?\s?(\d{1,3}(?:,\d{3})*|\d+)\.\d{2}/i', $text, $m);

        return $m[0] ?? null;
    }

    private function extractDate(string $text)
    {
        $patterns = [
            '/\b\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}\b/',       // 12/01/2025
            '/\b\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}\b/',       // 2025-01-12
            '/\b\d{1,2}\s?(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s?\d{4}\b/i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $m)) {
                return $m[0];
            }
        }

        return null;
    }

    private function guessCategory(string $text)
    {
        $patterns = [
            'Food' => '/food|meal|restaurant|inn/i',
            'Groceries' => '/provisions|grocery|market/i',
            'Transport' => '/fuel|petrol|diesel|shell|total/i',
            'Shopping' => '/clothes|fashion|wear|mall/i',
        ];

        foreach ($patterns as $category => $regex) {
            if (preg_match($regex, $text)) {
                return $category;
            }
        }

        return 'General';
    }

}