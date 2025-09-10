<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFacultyRequest;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\TestSeries;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FacultyController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('faculty_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Faculty::with(['courses', 'test_series'])->select(sprintf('%s.*', (new Faculty)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'faculty_show';
                $editGate      = 'faculty_edit';
                $deleteGate    = 'faculty_delete';
                $crudRoutePart = 'faculties';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->editColumn('designation', function ($row) {
                return $row->designation ? $row->designation : '';
            });
            $table->editColumn('experience', function ($row) {
                return $row->experience ? $row->experience : '';
            });
            $table->editColumn('qualifications', function ($row) {
                return $row->qualifications ? $row->qualifications : '';
            });
            $table->editColumn('specialization', function ($row) {
                return $row->specialization ? $row->specialization : '';
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
            $table->editColumn('facebook_link', function ($row) {
                return $row->facebook_link ? $row->facebook_link : '';
            });
            $table->editColumn('instagram_link', function ($row) {
                return $row->instagram_link ? $row->instagram_link : '';
            });
            $table->editColumn('twitter_link', function ($row) {
                return $row->twitter_link ? $row->twitter_link : '';
            });
            $table->editColumn('linkedin_link', function ($row) {
                return $row->linkedin_link ? $row->linkedin_link : '';
            });
            $table->editColumn('youtube_link', function ($row) {
                return $row->youtube_link ? $row->youtube_link : '';
            });
            $table->editColumn('course', function ($row) {
                $labels = [];
                foreach ($row->courses as $course) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $course->heading);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('test_series', function ($row) {
                $labels = [];
                foreach ($row->test_series as $test_series) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $test_series->heading);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'featured_image', 'course', 'test_series', 'active']);

            return $table->make(true);
        }

        $courses      = Course::get();
        $test_seriess = TestSeries::get();

        return view('admin.faculties.index', compact('courses', 'test_seriess'));
    }

    public function create()
    {
        abort_if(Gate::denies('faculty_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('heading', 'id');

        $test_series = TestSeries::pluck('heading', 'id');

        return view('admin.faculties.create', compact('courses', 'test_series'));
    }

    public function store(StoreFacultyRequest $request)
    {
        $faculty = Faculty::create($request->all());
        $faculty->courses()->sync($request->input('courses', []));
        $faculty->test_series()->sync($request->input('test_series', []));
        if ($request->input('featured_image', false)) {
            $faculty->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $faculty->id]);
        }

        return redirect()->route('admin.faculties.index');
    }

    public function edit(Faculty $faculty)
    {
        abort_if(Gate::denies('faculty_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('heading', 'id');

        $test_series = TestSeries::pluck('heading', 'id');

        $faculty->load('courses', 'test_series');

        return view('admin.faculties.edit', compact('courses', 'faculty', 'test_series'));
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $faculty->update($request->all());
        $faculty->courses()->sync($request->input('courses', []));
        $faculty->test_series()->sync($request->input('test_series', []));
        if ($request->input('featured_image', false)) {
            if (! $faculty->featured_image || $request->input('featured_image') !== $faculty->featured_image->file_name) {
                if ($faculty->featured_image) {
                    $faculty->featured_image->delete();
                }
                $faculty->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($faculty->featured_image) {
            $faculty->featured_image->delete();
        }

        return redirect()->route('admin.faculties.index');
    }

    public function show(Faculty $faculty)
    {
        abort_if(Gate::denies('faculty_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculty->load('courses', 'test_series');

        return view('admin.faculties.show', compact('faculty'));
    }

    public function destroy(Faculty $faculty)
    {
        abort_if(Gate::denies('faculty_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculty->delete();

        return back();
    }

    public function massDestroy(MassDestroyFacultyRequest $request)
    {
        $faculties = Faculty::find(request('ids'));

        foreach ($faculties as $faculty) {
            $faculty->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('faculty_create') && Gate::denies('faculty_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Faculty();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}