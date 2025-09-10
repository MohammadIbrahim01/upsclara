<?php

namespace App\Http\Requests;

use App\Models\Course;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCourseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_create');
    }

    public function rules()
    {
        return [
            'heading' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'required',
                'unique:courses',
            ],
            'sub_heading' => [
                'string',
                'nullable',
            ],
            'duration' => [
                'string',
                'nullable',
            ],
            'video_lectures' => [
                'string',
                'nullable',
            ],
            'questions_count' => [
                'string',
                'nullable',
            ],
            'enrolment_deadline_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'price' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'featured_image_caption' => [
                'string',
                'nullable',
            ],
            'faculties.*' => [
                'integer',
            ],
            'faculties' => [
                'array',
            ],
            'course_categories.*' => [
                'integer',
            ],
            'course_categories' => [
                'array',
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
