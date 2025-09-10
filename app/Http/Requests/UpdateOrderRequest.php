<?php

namespace App\Http\Requests;

use App\Models\Order;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    public function rules()
    {
        return [
            'order_number' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'pin_code' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'state' => [
                'string',
                'nullable',
            ],
            'country' => [
                'string',
                'nullable',
            ],
            'courses.*' => [
                'integer',
            ],
            'courses' => [
                'array',
            ],
            'test_series.*' => [
                'integer',
            ],
            'test_series' => [
                'array',
            ],
            'gross_amount' => [
                'numeric',
            ],
            'discount_amount' => [
                'numeric',
            ],
            'net_amount' => [
                'numeric',
            ],
            'promo_code_applied' => [
                'string',
                'nullable',
            ],
        ];
    }
}
