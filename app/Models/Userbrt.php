<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Userbrt extends Model
{
    use HasFactory;

    public $table = 'userbrts';

    public $fillable = [
        'user_id',
        'brt_code',
        'reserved_amount',
        'status'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        'reserved_amount' => 'required|numeric|between:0,99999999.99',
        'status' => 'nullable|string|in:active,pending,expired',
    ];

    
}
