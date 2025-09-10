<?php

namespace App\Http\Requests;

use App\Models\SocialMedium;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSocialMediumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('social_medium_edit');
    }

    public function rules()
    {
        return [
            'company_id' => [
                'required',
                'integer',
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
            'google_link' => [
                'string',
                'nullable',
            ],
            'snapchat_link' => [
                'string',
                'nullable',
            ],
        ];
    }
}
