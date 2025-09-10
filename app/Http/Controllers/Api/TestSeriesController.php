<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TestSeries;
use App\Models\TestSeriesCategory;
use Illuminate\Http\JsonResponse;

class TestSeriesController extends Controller
{
    /**
     * Get all test series categories with test series
     */
    public function categories(): JsonResponse
    {
        $testSeriesCategories = TestSeriesCategory::where('active', true)
            ->whereNull('test_series_category_id') // Only get parent categories
            ->with([
                'children' => function ($query) {
                    $query->where('active', true)
                        ->with([
                            'test_series' => function ($testSeriesQuery) {
                                $testSeriesQuery->where('active', true)
                                    ->with([
                                        'faculties' => function ($facultyQuery) {
                                            $facultyQuery->select(['id', 'name', 'slug', 'designation']);
                                        }
                                    ])
                                    ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence']);
                            }
                        ])
                        ->orderBy('sequence')
                        ->select(['id', 'name', 'slug', 'sequence', 'test_series_category_id']);
                },
                'test_series' => function ($query) {
                    $query->where('active', true)
                        ->with([
                            'faculties' => function ($facultyQuery) {
                                $facultyQuery->select(['id', 'name', 'slug', 'designation']);
                            }
                        ])
                        ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence']);
                }
            ])
            ->orderBy('sequence')
            ->select(['id', 'name', 'slug', 'sequence'])
            ->get();

        // Transform categories and test series
        $testSeriesCategories->transform(function ($category) {
            $category->makeHidden(['id']);

            // Transform direct test series of parent category
            $category->test_series->transform(function ($testSeries) {
                $testSeries->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
                $testSeries->featured_image_url = $this->getTestSeriesImageUrl($testSeries, 'featured_image');
                $testSeries->study_material_url = $this->getTestSeriesFileUrl($testSeries, 'study_material');
                $testSeries->timetable_url = $this->getTestSeriesImageUrl($testSeries, 'timetable');

                // Transform faculties
                $testSeries->faculties->transform(function ($faculty) {
                    $faculty->makeHidden(['id', 'media', 'featured_image']);
                    $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
                    $faculty->unsetRelation('media');
                    return $faculty;
                });

                $testSeries->unsetRelation('media');
                return $testSeries;
            });

            // Transform child categories and their test series
            $category->children->transform(function ($childCategory) {
                $childCategory->makeHidden(['id', 'test_series_category_id']);
                $childCategory->test_series->transform(function ($testSeries) {
                    $testSeries->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
                    $testSeries->featured_image_url = $this->getTestSeriesImageUrl($testSeries, 'featured_image');
                    $testSeries->study_material_url = $this->getTestSeriesFileUrl($testSeries, 'study_material');
                    $testSeries->timetable_url = $this->getTestSeriesImageUrl($testSeries, 'timetable');

                    // Transform faculties
                    $testSeries->faculties->transform(function ($faculty) {
                        $faculty->makeHidden(['id', 'media', 'featured_image']);
                        $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
                        $faculty->unsetRelation('media');
                        return $faculty;
                    });

                    $testSeries->unsetRelation('media');
                    return $testSeries;
                });
                return $childCategory;
            });

            return $category;
        });

        return response()->json($testSeriesCategories);
    }

    /**
     * Get single test series category by slug with test series
     */
    public function categoryBySlug(string $slug): JsonResponse
    {
        $testSeriesCategory = TestSeriesCategory::where('slug', $slug)
            ->where('active', true)
            ->with([
                'test_series' => function ($query) {
                    $query->where('active', true)
                        ->with([
                            'faculties' => function ($facultyQuery) {
                                $facultyQuery->select(['id', 'name', 'slug', 'designation']);
                            }
                        ])
                        ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence'])
                        ->orderBy('sequence');
                }
            ])
            ->select(['id', 'name', 'slug', 'sequence'])
            ->first();

        if (!$testSeriesCategory) {
            return response()->json([
                'message' => 'Test series category not found'
            ], 404);
        }

        // Transform category and test series
        $testSeriesCategory->makeHidden(['id']);
        $testSeriesCategory->test_series->transform(function ($testSeries) {
            $testSeries->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
            $testSeries->featured_image_url = $this->getTestSeriesImageUrl($testSeries, 'featured_image');
            $testSeries->study_material_url = $this->getTestSeriesFileUrl($testSeries, 'study_material');
            $testSeries->timetable_url = $this->getTestSeriesImageUrl($testSeries, 'timetable');

            // Transform faculties
            $testSeries->faculties->transform(function ($faculty) {
                $faculty->makeHidden(['id', 'media', 'featured_image']);
                $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
                $faculty->unsetRelation('media');
                return $faculty;
            });

            $testSeries->unsetRelation('media');
            return $testSeries;
        });

        return response()->json($testSeriesCategory);
    }

    /**
     * Get single test series by slug
     */
    public function show(string $slug): JsonResponse
    {
        $testSeries = TestSeries::where('slug', $slug)
            ->where('active', true)
            ->with([
                'test_series_categories' => function ($query) {
                    $query->select(['id', 'name', 'slug']);
                },
                'faculties' => function ($query) {
                    $query->select(['id', 'name', 'slug', 'designation']);
                }
            ])
            ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'enrolment_deadline_date', 'price', 'short_description', 'long_description', 'content', 'extra_content', 'featured_image_caption', 'featured', 'sequence'])
            ->first();

        if (!$testSeries) {
            return response()->json([
                'message' => 'Test series not found'
            ], 404);
        }

        // Transform test series
        $testSeries->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
        $testSeries->featured_image_url = $this->getTestSeriesImageUrl($testSeries, 'featured_image');
        $testSeries->study_material_url = $this->getTestSeriesFileUrl($testSeries, 'study_material');
        $testSeries->timetable_url = $this->getTestSeriesImageUrl($testSeries, 'timetable');
        $testSeries->test_series_categories->makeHidden(['id']);

        // Transform faculties
        $testSeries->faculties->transform(function ($faculty) {
            $faculty->makeHidden(['id', 'media', 'featured_image']);
            $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
            $faculty->unsetRelation('media');
            return $faculty;
        });

        $testSeries->unsetRelation('media');

        return response()->json($testSeries);
    }

    /**
     * Get all test series with pagination
     */
    public function index(): JsonResponse
    {
        $testSeries = TestSeries::where('active', true)
            ->with([
                'test_series_categories' => function ($query) {
                    $query->select(['id', 'name', 'slug']);
                },
                'faculties' => function ($query) {
                    $query->select(['id', 'name', 'slug', 'designation']);
                }
            ])
            ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured_image_caption', 'featured', 'sequence'])
            ->orderBy('sequence')
            ->get();

        // Transform test series
        $testSeries->transform(function ($series) {
            $series->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
            $series->featured_image_url = $this->getTestSeriesImageUrl($series, 'featured_image');
            $series->study_material_url = $this->getTestSeriesFileUrl($series, 'study_material');
            $series->timetable_url = $this->getTestSeriesImageUrl($series, 'timetable');
            $series->test_series_categories->makeHidden(['id']);

            // Transform faculties
            $series->faculties->transform(function ($faculty) {
                $faculty->makeHidden(['id', 'media', 'featured_image']);
                $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
                $faculty->unsetRelation('media');
                return $faculty;
            });

            $series->unsetRelation('media');
            return $series;
        });

        return response()->json($testSeries);
    }

    /**
     * Get image URL for test series
     */
    private function getTestSeriesImageUrl($testSeries, string $collection): ?string
    {
        $media = $testSeries->getFirstMedia($collection);
        return $media ? $media->getUrl() : null;
    }

    /**
     * Get file URL for test series (for non-image files)
     */
    private function getTestSeriesFileUrl($testSeries, string $collection): ?string
    {
        $media = $testSeries->getFirstMedia($collection);
        return $media ? $media->getUrl() : null;
    }

    /**
     * Get featured image URL for faculty
     */
    private function getFacultyImageUrl($faculty): ?string
    {
        $media = $faculty->getFirstMedia('featured_image');
        return $media ? $media->getUrl() : null;
    }
}
