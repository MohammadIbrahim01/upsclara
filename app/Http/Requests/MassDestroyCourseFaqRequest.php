<?php

namespace App\Http\Requests;

use App\Models\CourseFaq;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCourseFaqRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('course_faq_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:course_faqs,id',
        ];
    }
}
