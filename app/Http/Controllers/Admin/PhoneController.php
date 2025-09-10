<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPhoneRequest;
use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Models\Company;
use App\Models\Phone;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PhoneController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('phone_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Phone::with(['company'])->select(sprintf('%s.*', (new Phone)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'phone_show';
                $editGate      = 'phone_edit';
                $deleteGate    = 'phone_delete';
                $crudRoutePart = 'phones';

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

            $table->editColumn('number', function ($row) {
                return $row->number ? $row->number : '';
            });
            $table->editColumn('whatsapp', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->whatsapp ? 'checked' : null) . '>';
            });
            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'company', 'whatsapp', 'active']);

            return $table->make(true);
        }

        $companies = Company::get();

        return view('admin.phones.index', compact('companies'));
    }

    public function create()
    {
        abort_if(Gate::denies('phone_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.phones.create', compact('companies'));
    }

    public function store(StorePhoneRequest $request)
    {
        $phone = Phone::create($request->all());

        return redirect()->route('admin.phones.index');
    }

    public function edit(Phone $phone)
    {
        abort_if(Gate::denies('phone_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $phone->load('company');

        return view('admin.phones.edit', compact('companies', 'phone'));
    }

    public function update(UpdatePhoneRequest $request, Phone $phone)
    {
        $phone->update($request->all());

        return redirect()->route('admin.phones.index');
    }

    public function show(Phone $phone)
    {
        abort_if(Gate::denies('phone_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $phone->load('company');

        return view('admin.phones.show', compact('phone'));
    }

    public function destroy(Phone $phone)
    {
        abort_if(Gate::denies('phone_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $phone->delete();

        return back();
    }

    public function massDestroy(MassDestroyPhoneRequest $request)
    {
        $phones = Phone::find(request('ids'));

        foreach ($phones as $phone) {
            $phone->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
