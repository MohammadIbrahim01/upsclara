<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Faculty;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Course::with(['faculties', 'course_categories'])->select(sprintf('%s.*', (new Course)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'course_show';
                $editGate = 'course_edit';
                $deleteGate = 'course_delete';
                $crudRoutePart = 'courses';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('heading', function ($row) {
                return $row->heading ? $row->heading : '';
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->editColumn('sub_heading', function ($row) {
                return $row->sub_heading ? $row->sub_heading : '';
            });
            $table->editColumn('language', function ($row) {
                return $row->language ? Course::LANGUAGE_SELECT[$row->language] : '';
            });
            $table->editColumn('duration', function ($row) {
                return $row->duration ? $row->duration : '';
            });
            $table->editColumn('video_lectures', function ($row) {
                return $row->video_lectures ? $row->video_lectures : '';
            });
            $table->editColumn('questions_count', function ($row) {
                return $row->questions_count ? $row->questions_count : '';
            });

            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('short_description', function ($row) {
                return $row->short_description ? $row->short_description : '';
            });
            $table->editColumn('long_description', function ($row) {
                return $row->long_description ? $row->long_description : '';
            });
            $table->editColumn('featured_image', function ($row) {
                if ($photo = $row->featured_image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('featured_image_caption', function ($row) {
                return $row->featured_image_caption ? $row->featured_image_caption : '';
            });








            $table->editColumn('study_material', function ($row) {
                if ($row->study_material && $row->study_material->count() > 0) {
                    $links = [];
                    foreach ($row->study_material as $media) {
                        $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                    }
                    return implode('<br>', $links);
                }
                return '';
            });




            $table->editColumn('timetable', function ($row) {
                if ($photo = $row->timetable) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('faculty', function ($row) {
                $labels = [];
                foreach ($row->faculties as $faculty) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $faculty->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('course_category', function ($row) {
                $labels = [];
                foreach ($row->course_categories as $course_category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $course_category->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('featured', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->featured ? 'checked' : null) . '>';
            });
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });
            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'featured_image', 'study_material', 'timetable', 'faculty', 'course_category', 'featured', 'active']);

            return $table->make(true);
        }

        $faculties = Faculty::get();
        $course_categories = CourseCategory::get();

        return view('admin.courses.index', compact('faculties', 'course_categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculties = Faculty::pluck('name', 'id');

        $course_categories = CourseCategory::pluck('name', 'id');

        return view('admin.courses.create', compact('course_categories', 'faculties'));
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());
        $course->faculties()->sync($request->input('faculties', []));
        $course->course_categories()->sync($request->input('course_categories', []));
        if ($request->input('featured_image', false)) {
            $course->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }











        if ($request->input('study_material', false)) {
            foreach ($request->input('study_material') as $file) {
                $course->addMedia(storage_path('tmp/uploads/' . basename($file)))
                    ->toMediaCollection('study_material');
            }
        }












        if ($request->input('timetable', false)) {
            $course->addMedia(storage_path('tmp/uploads/' . basename($request->input('timetable'))))->toMediaCollection('timetable');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $course->id]);
        }

        return redirect()->route('admin.courses.index');
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculties = Faculty::pluck('name', 'id');

        $course_categories = CourseCategory::pluck('name', 'id');

        $course->load('faculties', 'course_categories');

        return view('admin.courses.edit', compact('course', 'course_categories', 'faculties'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());
        $course->faculties()->sync($request->input('faculties', []));
        $course->course_categories()->sync($request->input('course_categories', []));
        if ($request->input('featured_image', false)) {
            if (!$course->featured_image || $request->input('featured_image') !== $course->featured_image->file_name) {
                if ($course->featured_image) {
                    $course->featured_image->delete();
                }
                $course->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($course->featured_image) {
            $course->featured_image->delete();
        }






        // ✅ study_material (multiple files)
        if ($request->input('study_material', false)) {
            // pehle se jo files DB me hain unko check karo
            $existingFiles = $course->study_material->pluck('file_name')->toArray();

            // jo files request me nahi hain unko delete karo
            foreach ($course->study_material as $media) {
                if (!in_array($media->file_name, $request->input('study_material'))) {
                    $media->delete();
                }
            }

            // jo nayi files request me hain unko add karo
            foreach ($request->input('study_material') as $file) {
                if (!in_array($file, $existingFiles)) {
                    $course->addMedia(storage_path('tmp/uploads/' . basename($file)))
                        ->toMediaCollection('study_material');
                }
            }
        } else {
            // agar request me study_material nahi aaya to purane sab delete kar do
            foreach ($course->study_material as $media) {
                $media->delete();
            }
        }











        if ($request->input('timetable', false)) {
            if (!$course->timetable || $request->input('timetable') !== $course->timetable->file_name) {
                if ($course->timetable) {
                    $course->timetable->delete();
                }
                $course->addMedia(storage_path('tmp/uploads/' . basename($request->input('timetable'))))->toMediaCollection('timetable');
            }
        } elseif ($course->timetable) {
            $course->timetable->delete();
        }

        return redirect()->route('admin.courses.index');
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->load('faculties', 'course_categories', 'courseCourseContents', 'courseCourseFaqs');

        return view('admin.courses.show', compact('course'));
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        $courses = Course::find(request('ids'));

        foreach ($courses as $course) {
            $course->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('course_create') && Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Course();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
