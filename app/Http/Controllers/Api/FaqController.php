<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\CourseFaq;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    /**
     * Get all general FAQs
     */
    public function index(): JsonResponse
    {
        $faqs = Faq::where('active', true)
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->makeHidden(['id']);

        return response()->json($faqs);
    }

    /**
     * Get FAQs for a specific course by slug
     */
    public function courseBySlug(string $slug): JsonResponse
    {
        $course = Course::where('slug', $slug)
            ->where('active', true)
            ->first();

        if (!$course) {
            return response()->json([
                'message' => 'Course not found'
            ], 404);
        }

        $courseFaqs = CourseFaq::where('course_id', $course->id)
            ->where('active', true)
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->makeHidden(['id', 'course_id']);

        return response()->json([
            'course' => $course->makeHidden(['id']),
            'faqs' => $courseFaqs
        ]);
    }

    /**
     * Get all course FAQs grouped by course
     */
    public function courseFaqs(): JsonResponse
    {
        $courseFaqs = CourseFaq::with(['course' => function($query) {
                $query->where('active', true);
            }])
            ->where('active', true)
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('course.slug')
            ->map(function($faqs) {
                $course = $faqs->first()->course;
                return [
                    'course' => $course ? $course->makeHidden(['id']) : null,
                    'faqs' => $faqs->makeHidden(['id', 'course_id'])
                ];
            })
            ->filter(function($item) {
                return $item['course'] !== null;
            })
            ->values();

        return response()->json($courseFaqs);
    }
}
