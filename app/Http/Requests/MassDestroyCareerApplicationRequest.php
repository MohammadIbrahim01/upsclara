<?php

namespace App\Http\Requests;

use App\Models\CareerApplication;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCareerApplicationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('career_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:career_applications,id',
        ];
    }
}
