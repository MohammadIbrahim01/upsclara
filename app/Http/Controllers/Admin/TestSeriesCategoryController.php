<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTestSeriesCategoryRequest;
use App\Http\Requests\StoreTestSeriesCategoryRequest;
use App\Http\Requests\UpdateTestSeriesCategoryRequest;
use App\Models\TestSeriesCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TestSeriesCategoryController extends Controller
{
   public function index(Request $request)
{
    abort_if(Gate::denies('test_series_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        $query = TestSeriesCategory::with(['test_series_category'])->select(sprintf('%s.*', (new TestSeriesCategory)->table));
        $table = Datatables::of($query);

        $table->addColumn('placeholder', '&nbsp;');
        $table->addColumn('actions', '&nbsp;');

        $table->editColumn('actions', function ($row) {
            $viewGate      = 'test_series_category_show';
            $editGate      = 'test_series_category_edit';
            $deleteGate    = 'test_series_category_delete';
            $crudRoutePart = 'test-series-categories';

            return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
        });

        $table->editColumn('id', function ($row) {
            return $row->id ?? '';
        });
        $table->editColumn('name', function ($row) {
            return $row->name ?? '';
        });
        $table->editColumn('slug', function ($row) {
            return $row->slug ?? '';
        });
        $table->addColumn('test_series_category_name', function ($row) {
            return $row->test_series_category ? $row->test_series_category->name : '';
        });

        $table->editColumn('sequence', function ($row) {
            return $row->sequence ?? '';
        });
        $table->editColumn('active', function ($row) {
            return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : '') . '>';
        });

        // ✅ Fixed rawColumns
        $table->rawColumns(['actions', 'placeholder', 'test_series_category_name', 'active']);

        return $table->make(true);
    }

    $test_series_categories = TestSeriesCategory::get();

    return view('admin.testSeriesCategories.index', compact('test_series_categories'));
}
    public function create()
    {
        abort_if(Gate::denies('test_series_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test_series_categories = TestSeriesCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.testSeriesCategories.create', compact('test_series_categories'));
    }

    public function store(StoreTestSeriesCategoryRequest $request)
    {
        $testSeriesCategory = TestSeriesCategory::create($request->all());

        return redirect()->route('admin.test-series-categories.index');
    }

    public function edit(TestSeriesCategory $testSeriesCategory)
    {
        abort_if(Gate::denies('test_series_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test_series_categories = TestSeriesCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $testSeriesCategory->load('test_series_category');

        return view('admin.testSeriesCategories.edit', compact('testSeriesCategory', 'test_series_categories'));
    }

    public function update(UpdateTestSeriesCategoryRequest $request, TestSeriesCategory $testSeriesCategory)
    {
        $testSeriesCategory->update($request->all());

        return redirect()->route('admin.test-series-categories.index');
    }

    public function show(TestSeriesCategory $testSeriesCategory)
    {
        abort_if(Gate::denies('test_series_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testSeriesCategory->load('test_series_category', 'testSeriesCategoryTestSeriess');

        return view('admin.testSeriesCategories.show', compact('testSeriesCategory'));
    }

    public function destroy(TestSeriesCategory $testSeriesCategory)
    {
        abort_if(Gate::denies('test_series_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testSeriesCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyTestSeriesCategoryRequest $request)
    {
        $testSeriesCategories = TestSeriesCategory::find(request('ids'));

        foreach ($testSeriesCategories as $testSeriesCategory) {
            $testSeriesCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
