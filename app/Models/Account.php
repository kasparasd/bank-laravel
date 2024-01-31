<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'balance',
        'accountNumber',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
