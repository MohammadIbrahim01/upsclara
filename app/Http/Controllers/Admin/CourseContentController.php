<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCourseContentRequest;
use App\Http\Requests\StoreCourseContentRequest;
use App\Http\Requests\UpdateCourseContentRequest;
use App\Models\Course;
use App\Models\CourseContent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CourseContentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('course_content_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CourseContent::with(['course'])->select(sprintf('%s.*', (new CourseContent)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'course_content_show';
                $editGate      = 'course_content_edit';
                $deleteGate    = 'course_content_delete';
                $crudRoutePart = 'course-contents';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('content', function ($row) {
                return $row->content ? $row->content : '';
            });
            $table->addColumn('course_heading', function ($row) {
                return $row->course ? $row->course->heading : '';
            });

            $table->editColumn('sequence', function ($row) {
                return $row->sequence ? $row->sequence : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course']);

            return $table->make(true);
        }

        $courses = Course::get();

        return view('admin.courseContents.index', compact('courses'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_content_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('heading', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.courseContents.create', compact('courses'));
    }

    public function store(StoreCourseContentRequest $request)
    {
        $courseContent = CourseContent::create($request->all());

        return redirect()->route('admin.course-contents.index');
    }

    public function edit(CourseContent $courseContent)
    {
        abort_if(Gate::denies('course_content_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('heading', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courseContent->load('course');

        return view('admin.courseContents.edit', compact('courseContent', 'courses'));
    }

    public function update(UpdateCourseContentRequest $request, CourseContent $courseContent)
    {
        $courseContent->update($request->all());

        return redirect()->route('admin.course-contents.index');
    }

    public function show(CourseContent $courseContent)
    {
        abort_if(Gate::denies('course_content_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseContent->load('course');

        return view('admin.courseContents.show', compact('courseContent'));
    }

    public function destroy(CourseContent $courseContent)
    {
        abort_if(Gate::denies('course_content_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseContent->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseContentRequest $request)
    {
        $courseContents = CourseContent::find(request('ids'));

        foreach ($courseContents as $courseContent) {
            $courseContent->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
