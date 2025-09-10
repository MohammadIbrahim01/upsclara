<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCareerApplicationRequest;
use App\Http\Requests\StoreCareerApplicationRequest;
use App\Http\Requests\UpdateCareerApplicationRequest;
use App\Models\CareerApplication;
use App\Models\JobOpening;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CareerApplicationController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('career_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CareerApplication::with(['job_opening'])->select(sprintf('%s.*', (new CareerApplication)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'career_application_show';
                $editGate      = 'career_application_edit';
                $deleteGate    = 'career_application_delete';
                $crudRoutePart = 'career-applications';

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
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('location', function ($row) {
                return $row->location ? $row->location : '';
            });
            $table->editColumn('experience', function ($row) {
                return $row->experience ? $row->experience : '';
            });
            $table->editColumn('qualifications', function ($row) {
                return $row->qualifications ? $row->qualifications : '';
            });
            $table->editColumn('resume', function ($row) {
                return $row->resume ? '<a href="' . $row->resume->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->addColumn('job_opening_designation', function ($row) {
                return $row->job_opening ? $row->job_opening->designation : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'resume', 'job_opening']);

            return $table->make(true);
        }

        $job_openings = JobOpening::get();

        return view('admin.careerApplications.index', compact('job_openings'));
    }

    public function create()
    {
        abort_if(Gate::denies('career_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $job_openings = JobOpening::pluck('designation', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.careerApplications.create', compact('job_openings'));
    }

    public function store(StoreCareerApplicationRequest $request)
    {
        $careerApplication = CareerApplication::create($request->all());

        if ($request->input('resume', false)) {
            $careerApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('resume'))))->toMediaCollection('resume');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $careerApplication->id]);
        }

        return redirect()->route('admin.career-applications.index');
    }

    public function edit(CareerApplication $careerApplication)
    {
        abort_if(Gate::denies('career_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $job_openings = JobOpening::pluck('designation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $careerApplication->load('job_opening');

        return view('admin.careerApplications.edit', compact('careerApplication', 'job_openings'));
    }

    public function update(UpdateCareerApplicationRequest $request, CareerApplication $careerApplication)
    {
        $careerApplication->update($request->all());

        if ($request->input('resume', false)) {
            if (! $careerApplication->resume || $request->input('resume') !== $careerApplication->resume->file_name) {
                if ($careerApplication->resume) {
                    $careerApplication->resume->delete();
                }
                $careerApplication->addMedia(storage_path('tmp/uploads/' . basename($request->input('resume'))))->toMediaCollection('resume');
            }
        } elseif ($careerApplication->resume) {
            $careerApplication->resume->delete();
        }

        return redirect()->route('admin.career-applications.index');
    }

    public function show(CareerApplication $careerApplication)
    {
        abort_if(Gate::denies('career_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careerApplication->load('job_opening');

        return view('admin.careerApplications.show', compact('careerApplication'));
    }

    public function destroy(CareerApplication $careerApplication)
    {
        abort_if(Gate::denies('career_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careerApplication->delete();

        return back();
    }

    public function massDestroy(MassDestroyCareerApplicationRequest $request)
    {
        $careerApplications = CareerApplication::find(request('ids'));

        foreach ($careerApplications as $careerApplication) {
            $careerApplication->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('career_application_create') && Gate::denies('career_application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CareerApplication();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
