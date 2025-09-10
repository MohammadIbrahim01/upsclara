<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    /**
     * Get all active testimonials
     */
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::where('active', true)
            ->select(['id', 'name', 'sub_heading', 'content', 'caption', 'sequence'])
            ->orderBy('sequence')
            ->get();

        // Transform testimonials to include only image URL
        $testimonials->transform(function ($testimonial) {
            $testimonial->makeHidden(['id', 'media', 'image']);
            $testimonial->image_url = $this->getImageUrl($testimonial);
            $testimonial->unsetRelation('media');
            return $testimonial;
        });

        return response()->json($testimonials);
    }

    /**
     * Get image URL for testimonial
     */
    private function getImageUrl($testimonial): ?string
    {
        $media = $testimonial->getFirstMedia('image');
        return $media ? $media->getUrl() : null;
    }
}
