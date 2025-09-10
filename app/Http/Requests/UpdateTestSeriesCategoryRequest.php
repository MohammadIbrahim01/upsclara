<?php

namespace App\Http\Requests;

use App\Models\TestSeriesCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTestSeriesCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('test_series_category_edit');
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
                'unique:test_series_categories,slug,' . request()->route('test_series_category')->id,
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
