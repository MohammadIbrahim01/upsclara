<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\JsonResponse;

class FacultyController extends Controller
{
    /**
     * Get all active faculties
     */
    public function index(): JsonResponse
    {
        $faculties = Faculty::where('active', true)
            ->select(['id', 'name', 'slug', 'designation', 'experience', 'qualifications', 'specialization', 'short_description', 'long_description', 'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'youtube_link', 'sequence'])
            ->orderBy('sequence')
            ->get();

        // Transform faculties to include only image URL
        $faculties->transform(function ($faculty) {
            $faculty->makeHidden(['id', 'media', 'featured_image']);
            $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
            $faculty->unsetRelation('media');
            return $faculty;
        });

        return response()->json($faculties);
    }

    /**
     * Get single faculty by slug
     */
    public function show(string $slug): JsonResponse
    {
        $faculty = Faculty::where('slug', $slug)
            ->where('active', true)
            ->with([
                'courses' => function ($query) {
                    $query->where('active', true)
                        ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence']);
                },
                'test_series' => function ($query) {
                    $query->where('active', true)
                        ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence']);
                }
            ])
            ->select(['id', 'name', 'slug', 'designation', 'experience', 'qualifications', 'specialization', 'short_description', 'long_description', 'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'youtube_link', 'sequence'])
            ->first();

        if (!$faculty) {
            return response()->json([
                'message' => 'Faculty not found'
            ], 404);
        }

        // Transform faculty to include only image URL
        $faculty->makeHidden(['id', 'media', 'featured_image']);
        $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);

        // Transform courses
        $faculty->courses->transform(function ($course) {
            $course->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
            $course->featured_image_url = $this->getCourseImageUrl($course);
            $course->study_material_url = $this->getCourseFileUrl($course, 'study_material');
            $course->timetable_url = $this->getCourseImageUrl($course, 'timetable');
            $course->unsetRelation('media');
            return $course;
        });

        // Transform test series
        $faculty->test_series->transform(function ($testSeries) {
            $testSeries->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
            $testSeries->featured_image_url = $this->getTestSeriesImageUrl($testSeries);
            $testSeries->study_material_url = $this->getTestSeriesFileUrl($testSeries, 'study_material');
            $testSeries->timetable_url = $this->getTestSeriesImageUrl($testSeries, 'timetable');
            $testSeries->unsetRelation('media');
            return $testSeries;
        });

        $faculty->unsetRelation('media');

        return response()->json($faculty);
    }

    /**
     * Get featured image URL for faculty
     */
    private function getFacultyImageUrl($faculty): ?string
    {
        $media = $faculty->getFirstMedia('featured_image');
        return $media ? $media->getUrl() : null;
    }

    /**
     * Get featured image URL for course
     */
    private function getCourseImageUrl($course, string $collection = 'featured_image'): ?string
    {
        $media = $course->getFirstMedia($collection);
        return $media ? $media->getUrl() : null;
    }

    /**
     * Get featured image URL for test series
     */
    private function getTestSeriesImageUrl($testSeries, string $collection = 'featured_image'): ?string
    {
        $media = $testSeries->getFirstMedia($collection);
        return $media ? $media->getUrl() : null;
    }

    /**
     * Get course file URL
     */
    private function getCourseFileUrl($course, string $collection): ?string
    {
        $media = $course->getFirstMedia($collection);
        return $media ? $media->getUrl() : null;
    }

    /**
     * Get test series file URL
     */
    private function getTestSeriesFileUrl($testSeries, string $collection): ?string
    {
        $media = $testSeries->getFirstMedia($collection);
        return $media ? $media->getUrl() : null;
    }
}
