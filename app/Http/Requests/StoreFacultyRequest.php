<?php

namespace App\Http\Requests;

use App\Models\Faculty;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFacultyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('faculty_create');
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
                'unique:faculties',
            ],
            'designation' => [
                'string',
                'nullable',
            ],
            'experience' => [
                'string',
                'nullable',
            ],
            'qualifications' => [
                'string',
                'nullable',
            ],
            'specialization' => [
                'string',
                'nullable',
            ],
            'short_description' => [
                'string',
                'nullable',
            ],
            'facebook_link' => [
                'string',
                'nullable',
            ],
            'instagram_link' => [
                'string',
                'nullable',
            ],
            'twitter_link' => [
                'string',
                'nullable',
            ],
            'linkedin_link' => [
                'string',
                'nullable',
            ],
            'youtube_link' => [
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
            'sequence' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
