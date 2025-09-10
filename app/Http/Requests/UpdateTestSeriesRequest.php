<?php

namespace App\Http\Requests;

use App\Models\TestSeries;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateTestSeriesRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('test_series_edit');
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
                'unique:test_seriess,slug,' . request()->route('test_seriess')->id,
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
            'test_series_categories.*' => [
                'integer',
            ],
            'test_series_categories' => [
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
