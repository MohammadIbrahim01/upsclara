<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyJobOpeningRequest;
use App\Http\Requests\StoreJobOpeningRequest;
use App\Http\Requests\UpdateJobOpeningRequest;
use App\Models\JobOpening;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class JobOpeningController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('job_opening_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = JobOpening::query()->select(sprintf('%s.*', (new JobOpening)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'job_opening_show';
                $editGate      = 'job_opening_edit';
                $deleteGate    = 'job_opening_delete';
                $crudRoutePart = 'job-openings';

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
            $table->editColumn('designation', function ($row) {
                return $row->designation ? $row->designation : '';
            });
            $table->editColumn('location', function ($row) {
                return $row->location ? $row->location : '';
            });
            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'active']);

            return $table->make(true);
        }

        return view('admin.jobOpenings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('job_opening_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.jobOpenings.create');
    }

    public function store(StoreJobOpeningRequest $request)
    {
        $jobOpening = JobOpening::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $jobOpening->id]);
        }

        return redirect()->route('admin.job-openings.index');
    }

    public function edit(JobOpening $jobOpening)
    {
        abort_if(Gate::denies('job_opening_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.jobOpenings.edit', compact('jobOpening'));
    }

    public function update(UpdateJobOpeningRequest $request, JobOpening $jobOpening)
    {
        $jobOpening->update($request->all());

        return redirect()->route('admin.job-openings.index');
    }

    public function show(JobOpening $jobOpening)
    {
        abort_if(Gate::denies('job_opening_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.jobOpenings.show', compact('jobOpening'));
    }

    public function destroy(JobOpening $jobOpening)
    {
        abort_if(Gate::denies('job_opening_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOpening->delete();

        return back();
    }

    public function massDestroy(MassDestroyJobOpeningRequest $request)
    {
        $jobOpenings = JobOpening::find(request('ids'));

        foreach ($jobOpenings as $jobOpening) {
            $jobOpening->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('job_opening_create') && Gate::denies('job_opening_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new JobOpening();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
