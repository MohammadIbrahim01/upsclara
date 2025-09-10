<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmailRequest;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\Company;
use App\Models\Email;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Email::with(['company'])->select(sprintf('%s.*', (new Email)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'email_show';
                $editGate      = 'email_edit';
                $deleteGate    = 'email_delete';
                $crudRoutePart = 'emails';

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
            $table->addColumn('company_name', function ($row) {
                return $row->company ? $row->company->name : '';
            });

            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'company', 'active']);

            return $table->make(true);
        }

        $companies = Company::get();

        return view('admin.emails.index', compact('companies'));
    }

    public function create()
    {
        abort_if(Gate::denies('email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.emails.create', compact('companies'));
    }

    public function store(StoreEmailRequest $request)
    {
        $email = Email::create($request->all());

        return redirect()->route('admin.emails.index');
    }

    public function edit(Email $email)
    {
        abort_if(Gate::denies('email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $email->load('company');

        return view('admin.emails.edit', compact('companies', 'email'));
    }

    public function update(UpdateEmailRequest $request, Email $email)
    {
        $email->update($request->all());

        return redirect()->route('admin.emails.index');
    }

    public function show(Email $email)
    {
        abort_if(Gate::denies('email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->load('company');

        return view('admin.emails.show', compact('email'));
    }

    public function destroy(Email $email)
    {
        abort_if(Gate::denies('email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmailRequest $request)
    {
        $emails = Email::find(request('ids'));

        foreach ($emails as $email) {
            $email->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
