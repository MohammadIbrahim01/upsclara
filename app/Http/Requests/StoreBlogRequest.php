<?php

namespace App\Http\Requests;

use App\Models\Blog;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBlogRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('blog_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'required',
                'unique:blogs',
            ],
            'heading' => [
                'string',
                'nullable',
            ],
            'featured_image_caption' => [
                'string',
                'nullable',
            ],
            'publish_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'blog_categories.*' => [
                'integer',
            ],
            'blog_categories' => [
                'array',
            ],
        ];
    }
}
