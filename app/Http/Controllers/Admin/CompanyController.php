<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::with(['media'])->get();

        return view('admin.companies.index', compact('companies'));
    }

    public function edit(Company $company)
    {
        abort_if(Gate::denies('company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->all());

        if ($request->input('favicon', false)) {
            if (! $company->favicon || $request->input('favicon') !== $company->favicon->file_name) {
                if ($company->favicon) {
                    $company->favicon->delete();
                }
                $company->addMedia(storage_path('tmp/uploads/' . basename($request->input('favicon'))))->toMediaCollection('favicon');
            }
        } elseif ($company->favicon) {
            $company->favicon->delete();
        }

        if ($request->input('logo', false)) {
            if (! $company->logo || $request->input('logo') !== $company->logo->file_name) {
                if ($company->logo) {
                    $company->logo->delete();
                }
                $company->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($company->logo) {
            $company->logo->delete();
        }

        return redirect()->route('admin.companies.index');
    }

    public function show(Company $company)
    {
        abort_if(Gate::denies('company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.show', compact('company'));
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('company_create') && Gate::denies('company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Company();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
