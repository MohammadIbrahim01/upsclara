<?php

namespace App\Http\Requests;

use App\Models\CourseFaq;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCourseFaqRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_faq_edit');
    }

    public function rules()
    {
        return [
            'course_id' => [
                'required',
                'integer',
            ],
            'question' => [
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
