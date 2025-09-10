<?php

namespace App\Http\Requests;

use App\Models\TestSeriesCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTestSeriesCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('test_series_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:test_series_categories,id',
        ];
    }
}
