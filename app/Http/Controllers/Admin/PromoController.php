<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPromoRequest;
use App\Http\Requests\StorePromoRequest;
use App\Http\Requests\UpdatePromoRequest;
use App\Models\Promo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('promo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Promo::query()->select(sprintf('%s.*', (new Promo)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'promo_show';
                $editGate      = 'promo_edit';
                $deleteGate    = 'promo_delete';
                $crudRoutePart = 'promos';

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
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->editColumn('percentage', function ($row) {
                return $row->percentage ? $row->percentage : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.promos.index');
    }

    public function create()
    {
        abort_if(Gate::denies('promo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.promos.create');
    }

    public function store(StorePromoRequest $request)
    {
        $promo = Promo::create($request->all());

        return redirect()->route('admin.promos.index');
    }

    public function edit(Promo $promo)
    {
        abort_if(Gate::denies('promo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.promos.edit', compact('promo'));
    }

    public function update(UpdatePromoRequest $request, Promo $promo)
    {
        $promo->update($request->all());

        return redirect()->route('admin.promos.index');
    }

    public function show(Promo $promo)
    {
        abort_if(Gate::denies('promo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.promos.show', compact('promo'));
    }

    public function destroy(Promo $promo)
    {
        abort_if(Gate::denies('promo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $promo->delete();

        return back();
    }

    public function massDestroy(MassDestroyPromoRequest $request)
    {
        $promos = Promo::find(request('ids'));

        foreach ($promos as $promo) {
            $promo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
