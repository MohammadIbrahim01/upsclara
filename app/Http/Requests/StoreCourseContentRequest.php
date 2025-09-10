<?php

namespace App\Http\Requests;

use App\Models\CourseContent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCourseContentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_content_create');
    }

    public function rules()
    {
        return [
            'title' => [
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
