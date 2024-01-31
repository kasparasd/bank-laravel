<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account;


class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lastname',
        'personalCodeNumber',
    ];

    public function accounts() {
        return $this->hasMany(Account::class);
    }
}
