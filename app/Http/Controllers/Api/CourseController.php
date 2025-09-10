<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    /**
     * Get all course categories with courses, course content, and course FAQs
     */
    public function categories(): JsonResponse
    {
        $courseCategories = CourseCategory::where('active', true)
            ->whereNull('course_category_id') // Only get parent categories
            ->with([
                'children' => function ($query) {
                    $query->where('active', true)
                        ->with([
                            'courses' => function ($courseQuery) {
                                $courseQuery->where('active', true)
                                    ->with([
                                        'courseCourseContents' => function ($q) {
                                            $q->select(['id', 'course_id', 'title', 'content', 'sequence'])
                                                ->orderBy('sequence');
                                        },
                                        'courseCourseFaqs' => function ($q) {
                                            $q->where('active', true)
                                                ->select(['id', 'course_id', 'question', 'answer', 'sequence'])
                                                ->orderBy('sequence');
                                        },
                                        'faculties' => function ($query) {
                                            $query->select(['id', 'name', 'slug', 'designation', 'experience', 'qualifications', 'specialization', 'short_description', 'long_description', 'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'youtube_link', 'sequence']);
                                        }
                                    ])
                                    ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence']);
                            }
                        ])
                        ->orderBy('sequence')
                        ->select(['id', 'name', 'slug', 'sequence', 'course_category_id']);
                },
                'courses' => function ($query) {
                    $query->where('active', true)
                        ->with([
                            'courseCourseContents' => function ($q) {
                                $q->select(['id', 'course_id', 'title', 'content', 'sequence'])
                                    ->orderBy('sequence');
                            },
                            'courseCourseFaqs' => function ($q) {
                                $q->where('active', true)
                                    ->select(['id', 'course_id', 'question', 'answer', 'sequence'])
                                    ->orderBy('sequence');
                            },
                            'faculties' => function ($query) {
                                $query->select(['id', 'name', 'slug', 'designation', 'experience', 'qualifications', 'specialization', 'short_description', 'long_description', 'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'youtube_link', 'sequence']);
                            }
                        ])
                        ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence']);
                }
            ])
            ->orderBy('sequence')
            ->select(['id', 'name', 'slug', 'sequence'])
            ->get();

        // Transform categories and courses
        $courseCategories->transform(function ($category) {
            $category->makeHidden(['id']);

            // Transform direct courses of parent category
            $category->courses->transform(function ($course) {
                $course->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
                $course->featured_image_url = $this->getCourseImageUrl($course, 'featured_image');
                $course->study_material_url = $this->getCourseFileUrl($course, 'study_material');
                $course->timetable_url = $this->getCourseImageUrl($course, 'timetable');
                $course->courseCourseContents->makeHidden(['id', 'course_id']);
                $course->courseCourseFaqs->makeHidden(['id', 'course_id']);

                // Transform faculties
                $course->faculties->transform(function ($faculty) {
                    $faculty->makeHidden(['id', 'media', 'featured_image']);
                    $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
                    $faculty->unsetRelation('media');
                    return $faculty;
                });

                $course->unsetRelation('media');
                return $course;
            });

            // Transform child categories and their courses
            $category->children->transform(function ($childCategory) {
                $childCategory->makeHidden(['id', 'course_category_id']);
                $childCategory->courses->transform(function ($course) {
                    $course->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
                    $course->featured_image_url = $this->getCourseImageUrl($course, 'featured_image');
                    $course->study_material_url = $this->getCourseFileUrl($course, 'study_material');
                    $course->timetable_url = $this->getCourseImageUrl($course, 'timetable');
                    $course->courseCourseContents->makeHidden(['id', 'course_id']);
                    $course->courseCourseFaqs->makeHidden(['id', 'course_id']);

                    // Transform faculties
                    $course->faculties->transform(function ($faculty) {
                        $faculty->makeHidden(['id', 'media', 'featured_image']);
                        $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
                        $faculty->unsetRelation('media');
                        return $faculty;
                    });

                    $course->unsetRelation('media');
                    return $course;
                });
                return $childCategory;
            });

            return $category;
        });

        return response()->json($courseCategories);
    }

    /**
     * Get single course category by slug with courses, course content, and course FAQs
     */
    public function categoryBySlug(string $slug): JsonResponse
    {
        $courseCategory = CourseCategory::where('slug', $slug)
            ->where('active', true)
            ->with([
                'courses' => function ($query) {
                    $query->where('active', true)
                        ->with([
                            'courseCourseContents' => function ($q) {
                                $q->select(['id', 'course_id', 'title', 'content', 'sequence'])
                                    ->orderBy('sequence');
                            },
                            'courseCourseFaqs' => function ($q) {
                                $q->where('active', true)
                                    ->select(['id', 'course_id', 'question', 'answer', 'sequence'])
                                    ->orderBy('sequence');
                            },
                            'faculties' => function ($query) {
                                $query->select(['id', 'name', 'slug', 'designation', 'experience', 'qualifications', 'specialization', 'short_description', 'long_description', 'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'youtube_link', 'sequence']);
                            }
                        ])
                        ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence']);
                }
            ])
            ->select(['id', 'name', 'slug', 'sequence'])
            ->first();

        if (!$courseCategory) {
            return response()->json([
                'message' => 'Course category not found'
            ], 404);
        }

        // Transform category and courses
        $courseCategory->makeHidden(['id']);
        $courseCategory->courses->transform(function ($course) {
            $course->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
            $course->featured_image_url = $this->getCourseImageUrl($course, 'featured_image');
            $course->study_material_url = $this->getCourseFileUrl($course, 'study_material');
            $course->timetable_url = $this->getCourseImageUrl($course, 'timetable');
            $course->courseCourseContents->makeHidden(['id', 'course_id']);
            $course->courseCourseFaqs->makeHidden(['id', 'course_id']);

            // Transform faculties
            $course->faculties->transform(function ($faculty) {
                $faculty->makeHidden(['id', 'media', 'featured_image']);
                $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
                $faculty->unsetRelation('media');
                return $faculty;
            });

            $course->unsetRelation('media');
            return $course;
        });

        return response()->json($courseCategory);
    }




    /**
     * Get multiple file URLs for course
     */
    private function getCourseFilesUrl($course, string $collection): array
    {
        $mediaItems = $course->getMedia($collection);
        return $mediaItems->map(function ($media) {
            return [
                'name' => $media->file_name,
                'url' => $media->getUrl(),
            ];
        })->toArray();
    }




    /**
     * Get single course by slug with course content and course FAQs
     */
    public function show(string $slug): JsonResponse
    {
        $course = Course::where('slug', $slug)
            ->where('active', true)
            ->with([
                'courseCourseContents' => function ($q) {
                    $q->select(['id', 'course_id', 'title', 'content', 'sequence'])
                        ->orderBy('sequence');
                },
                'courseCourseFaqs' => function ($q) {
                    $q->where('active', true)
                        ->select(['id', 'course_id', 'question', 'answer', 'sequence'])
                        ->orderBy('sequence');
                },
                'course_categories' => function ($query) {
                    $query->select(['id', 'name', 'slug']);
                },
                'faculties' => function ($query) {
                    $query->select(['id', 'name', 'slug', 'designation', 'experience', 'qualifications', 'specialization', 'short_description', 'long_description', 'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'youtube_link', 'sequence']);
                }
            ])
            ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'enrolment_deadline_date', 'price', 'short_description', 'long_description', 'content', 'extra_content', 'featured_image_caption', 'featured', 'sequence'])
            ->first();

        if (!$course) {
            return response()->json([
                'message' => 'Course not found'
            ], 404);
        }

        // Transform course
        $course->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
        $course->featured_image_url = $this->getCourseImageUrl($course, 'featured_image');
        
        
        $course->study_materials = $this->getCourseFilesUrl($course, 'study_material');

        
        $course->timetable_url = $this->getCourseImageUrl($course, 'timetable');
        $course->courseCourseContents->makeHidden(['id', 'course_id']);
        $course->courseCourseFaqs->makeHidden(['id', 'course_id']);
        $course->course_categories->makeHidden(['id']);

        // Get related courses that share any of the same categories
        $categoryIds = $course->course_categories->pluck('id')->toArray();

        $relatedCourses = collect();
        if (!empty($categoryIds)) {
            $relatedCourses = Course::where('active', true)
                ->where('id', '!=', $course->id) // Exclude current course
                ->whereHas('course_categories', function ($query) use ($categoryIds) {
                    $query->whereIn('course_categories.id', $categoryIds);
                })
                ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured', 'sequence'])
                ->orderBy('sequence')
                ->limit(4)
                ->get();

            // Transform related courses
            $relatedCourses->transform(function ($relatedCourse) {
                $relatedCourse->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
                $relatedCourse->featured_image_url = $this->getCourseImageUrl($relatedCourse, 'featured_image');
                $relatedCourse->unsetRelation('media');
                return $relatedCourse;
            });
        }

        // Transform faculties
        $course->faculties->transform(function ($faculty) {
            $faculty->makeHidden(['id', 'media', 'featured_image']);
            $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
            $faculty->unsetRelation('media');
            return $faculty;
        });

        $course->unsetRelation('media');

        // Add related courses to response
        $course->related_courses = $relatedCourses;

        return response()->json($course);
    }

    /**
     * Get all courses with pagination
     */
    public function index(): JsonResponse
    {
        $courses = Course::where('active', true)
            ->with([
                'course_categories' => function ($query) {
                    $query->select(['id', 'name', 'slug']);
                },
                'faculties' => function ($query) {
                    $query->select(['id', 'name', 'slug', 'designation']);
                }
            ])
            ->select(['id', 'heading', 'slug', 'sub_heading', 'language', 'duration', 'video_lectures', 'questions_count', 'price', 'short_description', 'featured_image_caption', 'featured', 'sequence'])
            ->orderBy('sequence')
            ->get();

        // Transform courses
        $courses->transform(function ($course) {
            $course->makeHidden(['id', 'media', 'featured_image', 'study_material', 'timetable']);
            $course->featured_image_url = $this->getCourseImageUrl($course, 'featured_image');
            $course->study_material_url = $this->getCourseFileUrl($course, 'study_material');
            $course->timetable_url = $this->getCourseImageUrl($course, 'timetable');
            $course->course_categories->makeHidden(['id']);

            // Transform faculties
            $course->faculties->transform(function ($faculty) {
                $faculty->makeHidden(['id', 'media', 'featured_image']);
                $faculty->featured_image_url = $this->getFacultyImageUrl($faculty);
                $faculty->unsetRelation('media');
                return $faculty;
            });

            $course->unsetRelation('media');
            return $course;
        });

        return response()->json($courses);
    }

    /**
     * Get image URL for course
     */
    private function getCourseImageUrl($course, string $collection): ?string
    {
        $media = $course->getFirstMedia($collection);
        return $media ? $media->getUrl() : null;
    }

    /**
     * Get file URL for course (for non-image files)
     */
    private function getCourseFileUrl($course, string $collection): ?string
    {
        $media = $course->getFirstMedia($collection);
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
