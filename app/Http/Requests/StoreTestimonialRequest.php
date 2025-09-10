<?php

namespace App\Http\Requests;

use App\Models\Testimonial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('testimonial_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'sub_heading' => [
                'string',
                'nullable',
            ],
            'content' => [
                'required',
            ],
            'caption' => [
                'string',
                'nullable',
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
