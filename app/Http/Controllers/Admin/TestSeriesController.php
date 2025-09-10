<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTestSeriesRequest;
use App\Http\Requests\StoreTestSeriesRequest;
use App\Http\Requests\UpdateTestSeriesRequest;
use App\Models\Faculty;
use App\Models\TestSeries;
use App\Models\TestSeriesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TestSeriesController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('test_series_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TestSeries::with(['faculties', 'test_series_categories'])->select(sprintf('%s.*', (new TestSeries)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'test_series_show';
                $editGate      = 'test_series_edit';
                $deleteGate    = 'test_series_delete';
                $crudRoutePart = 'test-seriess';

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
                return $row->language ? TestSeries::LANGUAGE_SELECT[$row->language] : '';
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
                return $row->study_material ? '<a href="' . $row->study_material->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
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
            $table->editColumn('test_series_category', function ($row) {
                $labels = [];
                foreach ($row->test_series_categories as $test_series_category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $test_series_category->name);
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

            $table->rawColumns(['actions', 'placeholder', 'featured_image', 'study_material', 'timetable', 'faculty', 'test_series_category', 'featured', 'active']);

            return $table->make(true);
        }

        $faculties              = Faculty::get();
        $test_series_categories = TestSeriesCategory::get();

        return view('admin.testSeriess.index', compact('faculties', 'test_series_categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('test_series_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculties = Faculty::pluck('name', 'id');

        $test_series_categories = TestSeriesCategory::pluck('name', 'id');

        return view('admin.testSeriess.create', compact('faculties', 'test_series_categories'));
    }

    public function store(StoreTestSeriesRequest $request)
    {
        $testSeries = TestSeries::create($request->all());
        $testSeries->faculties()->sync($request->input('faculties', []));
        $testSeries->test_series_categories()->sync($request->input('test_series_categories', []));
        if ($request->input('featured_image', false)) {
            $testSeries->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        if ($request->input('study_material', false)) {
            $testSeries->addMedia(storage_path('tmp/uploads/' . basename($request->input('study_material'))))->toMediaCollection('study_material');
        }

        if ($request->input('timetable', false)) {
            $testSeries->addMedia(storage_path('tmp/uploads/' . basename($request->input('timetable'))))->toMediaCollection('timetable');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $testSeries->id]);
        }

        return redirect()->route('admin.test-seriess.index');
    }

    public function edit(TestSeries $test_seriess)
    {
        abort_if(Gate::denies('test_series_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculties = Faculty::pluck('name', 'id');

        $test_series_categories = TestSeriesCategory::pluck('name', 'id');

        $test_seriess->load('faculties', 'test_series_categories');

        return view('admin.testSeriess.edit', compact('faculties', 'test_seriess', 'test_series_categories'));
    }

    public function update(UpdateTestSeriesRequest $request, TestSeries $test_seriess)
    {
        $test_seriess->update($request->all());
        $test_seriess->faculties()->sync($request->input('faculties', []));
        $test_seriess->test_series_categories()->sync($request->input('test_series_categories', []));
        if ($request->input('featured_image', false)) {
            if (! $test_seriess->featured_image || $request->input('featured_image') !== $test_seriess->featured_image->file_name) {
                if ($test_seriess->featured_image) {
                    $test_seriess->featured_image->delete();
                }
                $test_seriess->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($test_seriess->featured_image) {
            $test_seriess->featured_image->delete();
        }

        if ($request->input('study_material', false)) {
            if (! $test_seriess->study_material || $request->input('study_material') !== $test_seriess->study_material->file_name) {
                if ($test_seriess->study_material) {
                    $test_seriess->study_material->delete();
                }
                $test_seriess->addMedia(storage_path('tmp/uploads/' . basename($request->input('study_material'))))->toMediaCollection('study_material');
            }
        } elseif ($test_seriess->study_material) {
            $test_seriess->study_material->delete();
        }

        if ($request->input('timetable', false)) {
            if (! $test_seriess->timetable || $request->input('timetable') !== $test_seriess->timetable->file_name) {
                if ($test_seriess->timetable) {
                    $test_seriess->timetable->delete();
                }
                $test_seriess->addMedia(storage_path('tmp/uploads/' . basename($request->input('timetable'))))->toMediaCollection('timetable');
            }
        } elseif ($test_seriess->timetable) {
            $test_seriess->timetable->delete();
        }

        return redirect()->route('admin.test-seriess.index');
    }

    public function show(TestSeries $test_seriess)
    {
        abort_if(Gate::denies('test_series_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test_seriess->load('faculties', 'test_series_categories');

        return view('admin.testSeriess.show', compact('test_seriess'));
    }

    public function destroy(TestSeries $test_seriess)
    {
        abort_if(Gate::denies('test_series_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test_seriess->delete();

        return back();
    }

    public function massDestroy(MassDestroyTestSeriesRequest $request)
    {
        $testSeriess = TestSeries::find(request('ids'));

        foreach ($testSeriess as $testSeries) {
            $testSeries->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('test_series_create') && Gate::denies('test_series_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new TestSeries();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
