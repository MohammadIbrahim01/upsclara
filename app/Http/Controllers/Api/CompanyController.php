<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * Get company data (first row)
     */
    public function show(): JsonResponse
    {
        $company = Company::with([
            'emails' => function ($query) {
                $query->where('active', true)->select(['id', 'company_id', 'email'])->orderBy('sequence');
            },
            'addresses' => function ($query) {
                $query->where('active', true)->select(['id', 'company_id', 'address'])->orderBy('sequence');
            },
            'phones' => function ($query) {
                $query->where('active', true)->select(['id', 'company_id', 'number', 'whatsapp'])->orderBy('sequence');
            },
            'socialMedia' => function ($query) {
                $query->select(['id', 'company_id', 'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'youtube_link']);
            }
        ])
        ->select(['id', 'name', 'map_link'])
        ->first();

        if (!$company) {
            return response()->json([
                'message' => 'Company not found'
            ], 404);
        }

        // Transform company data
        $company->makeHidden(['id', 'media', 'favicon', 'logo']);
        $company->favicon_url = $this->getCompanyImageUrl($company, 'favicon');
        $company->logo_url = $this->getCompanyImageUrl($company, 'logo');
        $company->emails->makeHidden(['id', 'company_id']);
        $company->addresses->makeHidden(['id', 'company_id']);
        $company->phones->makeHidden(['id', 'company_id']);
        if ($company->socialMedia) {
            $company->socialMedia->makeHidden(['id', 'company_id']);
        }
        $company->unsetRelation('media');

        return response()->json($company);
    }

    /**
     * Get image URL for company
     */
    private function getCompanyImageUrl($company, string $collection): ?string
    {
        $media = $company->getFirstMedia($collection);
        return $media ? $media->getUrl() : null;
    }
}
