<?php

namespace App\Http\Requests;

use App\Models\Promo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePromoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('promo_create');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:promos',
            ],
            'percentage' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
