<?php

namespace App\Http\Requests;

use App\Models\Phone;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePhoneRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('phone_create');
    }

    public function rules()
    {
        return [
            'company_id' => [
                'required',
                'integer',
            ],
            'number' => [
                'string',
                'required',
            ],
            'sequence' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
