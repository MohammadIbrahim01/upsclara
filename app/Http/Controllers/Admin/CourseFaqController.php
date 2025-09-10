<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCourseFaqRequest;
use App\Http\Requests\StoreCourseFaqRequest;
use App\Http\Requests\UpdateCourseFaqRequest;
use App\Models\Course;
use App\Models\CourseFaq;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CourseFaqController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('course_faq_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CourseFaq::with(['course'])->select(sprintf('%s.*', (new CourseFaq)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'course_faq_show';
                $editGate      = 'course_faq_edit';
                $deleteGate    = 'course_faq_delete';
                $crudRoutePart = 'course-faqs';

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
            $table->addColumn('course_heading', function ($row) {
                return $row->course ? $row->course->heading : '';
            });

            $table->editColumn('question', function ($row) {
                return $row->question ? $row->question : '';
            });
            $table->editColumn('answer', function ($row) {
                return $row->answer ? $row->answer : '';
            });
            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'active']);

            return $table->make(true);
        }

        $courses = Course::get();

        return view('admin.courseFaqs.index', compact('courses'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_faq_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('heading', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.courseFaqs.create', compact('courses'));
    }

    public function store(StoreCourseFaqRequest $request)
    {
        $courseFaq = CourseFaq::create($request->all());

        return redirect()->route('admin.course-faqs.index');
    }

    public function edit(CourseFaq $courseFaq)
    {
        abort_if(Gate::denies('course_faq_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('heading', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courseFaq->load('course');

        return view('admin.courseFaqs.edit', compact('courseFaq', 'courses'));
    }

    public function update(UpdateCourseFaqRequest $request, CourseFaq $courseFaq)
    {
        $courseFaq->update($request->all());

        return redirect()->route('admin.course-faqs.index');
    }

    public function show(CourseFaq $courseFaq)
    {
        abort_if(Gate::denies('course_faq_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseFaq->load('course');

        return view('admin.courseFaqs.show', compact('courseFaq'));
    }

    public function destroy(CourseFaq $courseFaq)
    {
        abort_if(Gate::denies('course_faq_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseFaq->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseFaqRequest $request)
    {
        $courseFaqs = CourseFaq::find(request('ids'));

        foreach ($courseFaqs as $courseFaq) {
            $courseFaq->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
