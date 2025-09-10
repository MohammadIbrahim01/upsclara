<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCourseCategoryRequest;
use App\Http\Requests\StoreCourseCategoryRequest;
use App\Http\Requests\UpdateCourseCategoryRequest;
use App\Models\CourseCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\DB;

class CourseCategoryController extends Controller
{
    public function indejjjx(Request $request)
    {
        abort_if(Gate::denies('course_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CourseCategory::with(['course_category'])->select(sprintf('%s.*', (new CourseCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'course_category_show';
                $editGate = 'course_category_edit';
                $deleteGate = 'course_category_delete';
                $crudRoutePart = 'course-categories';

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
            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });
            $table->addColumn('course_category_name', function ($row) {
                return $row->course_category ? $row->course_category->name : '';
            });

            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'course_category', 'active']);

            return $table->make(true);
        }

        $course_categories = CourseCategory::get();

        return view('admin.courseCategories.index', compact('course_categories'));
    }





    public function index(Request $request)
    {
        abort_if(Gate::denies('course_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CourseCategory::datatableQuery(); // use model function



            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'course_category_show';
                $editGate = 'course_category_edit';
                $deleteGate = 'course_category_delete';
                $crudRoutePart = 'course-categories';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', fn($row) => $row->id ?: '');
            $table->editColumn('name', fn($row) => $row->name ?: '');
            $table->editColumn('slug', fn($row) => $row->slug ?: '');
            $table->editColumn('sequence', fn($row) => $row->sequence ?: '');
            $table->editColumn(
                'active',
                fn($row) =>
                '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>'
            );

            $table->rawColumns(['actions', 'placeholder', 'course_category_name', 'active']);

            return $table->make(true);
        }

        $course_categories = CourseCategory::get(); // for filter dropdown in view

        return view('admin.courseCategories.index', compact('course_categories'));
    }


    public function create()
    {
        abort_if(Gate::denies('course_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course_categories = CourseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.courseCategories.create', compact('course_categories'));
    }

    public function store(StoreCourseCategoryRequest $request)
    {
        $courseCategory = CourseCategory::create($request->all());

        return redirect()->route('admin.course-categories.index');
    }

    public function edit(CourseCategory $courseCategory)
    {
        abort_if(Gate::denies('course_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course_categories = CourseCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courseCategory->load('course_category');

        return view('admin.courseCategories.edit', compact('courseCategory', 'course_categories'));
    }

    public function update(UpdateCourseCategoryRequest $request, CourseCategory $courseCategory)
    {
        $courseCategory->update($request->all());

        return redirect()->route('admin.course-categories.index');
    }

    public function show(CourseCategory $courseCategory)
    {
        abort_if(Gate::denies('course_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseCategory->load('course_category');

        return view('admin.courseCategories.show', compact('courseCategory'));
    }

    public function destroy(CourseCategory $courseCategory)
    {
        abort_if(Gate::denies('course_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseCategoryRequest $request)
    {
        $courseCategories = CourseCategory::find(request('ids'));

        foreach ($courseCategories as $courseCategory) {
            $courseCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
