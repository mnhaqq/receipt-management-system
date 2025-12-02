<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    /** @use HasFactory<\Database\Factories\ReceiptFactory> */
    use HasFactory;

    protected $fillable = [
        'vendor_name',
        'total_amount',
        'purchase_date',
        'category',
        'notes',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
