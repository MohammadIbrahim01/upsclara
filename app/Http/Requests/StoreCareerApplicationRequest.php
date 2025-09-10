<?php

namespace App\Http\Requests;

use App\Models\CareerApplication;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCareerApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('career_application_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'location' => [
                'string',
                'nullable',
            ],
            'experience' => [
                'string',
                'nullable',
            ],
        ];
    }
}
