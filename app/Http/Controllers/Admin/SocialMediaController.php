<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSocialMediumRequest;
use App\Models\Company;
use App\Models\SocialMedium;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SocialMediaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('social_medium_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $socialMedia = SocialMedium::with(['company'])->get();

        return view('admin.socialMedia.index', compact('socialMedia'));
    }

    public function edit(SocialMedium $socialMedium)
    {
        abort_if(Gate::denies('social_medium_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $socialMedium->load('company');

        return view('admin.socialMedia.edit', compact('companies', 'socialMedium'));
    }

    public function update(UpdateSocialMediumRequest $request, SocialMedium $socialMedium)
    {
        $socialMedium->update($request->all());

        return redirect()->route('admin.social-media.index');
    }

    public function show(SocialMedium $socialMedium)
    {
        abort_if(Gate::denies('social_medium_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $socialMedium->load('company');

        return view('admin.socialMedia.show', compact('socialMedium'));
    }
}
