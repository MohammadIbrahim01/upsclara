<?php

namespace App\Http\Requests;

use App\Models\TestSeries;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTestSeriesRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('test_series_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:test_seriess,id',
        ];
    }
}
