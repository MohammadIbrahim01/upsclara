<?php

namespace App\Http\Requests;

use App\Models\CourseCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCourseCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'required',
                'unique:course_categories,slug,' . request()->route('course_category')->id,
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
