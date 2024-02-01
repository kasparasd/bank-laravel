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

    protected static $sorts = [
        'no_sort' => 'Default',
        "name_asc" => 'Name a-z',
        "name_desc" => 'Name z-a',
        "lastname_asc" => 'Lastname a-z',
        "lastname_desc" => 'Lastname z-a',
        "balance_asc" => 'Balance ASC',
        "balance_desc" => 'Balance DESC',
        'accounts_asc' => 'Accounts Qty ASC',
        'accounts_desc' => 'Accounts Qty DESC',
    ];

    public static function getSorts()
    {
        return self::$sorts;
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
