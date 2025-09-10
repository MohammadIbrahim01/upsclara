<?php

namespace App\Http\Requests;

use App\Models\JobOpening;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreJobOpeningRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('job_opening_create');
    }

    public function rules()
    {
        return [
            'designation' => [
                'string',
                'required',
            ],
            'location' => [
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
