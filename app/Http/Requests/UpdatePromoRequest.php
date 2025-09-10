<?php

namespace App\Http\Requests;

use App\Models\Promo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePromoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('promo_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:promos,code,' . request()->route('promo')->id,
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
