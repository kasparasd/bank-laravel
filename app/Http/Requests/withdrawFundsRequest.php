<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class withdrawFundsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'gt:0',
        ];
    }
}

