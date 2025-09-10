<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBlogCategoryRequest;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Models\BlogCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('blog_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BlogCategory::with(['blog_category'])->select(sprintf('%s.*', (new BlogCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'blog_category_show';
                $editGate      = 'blog_category_edit';
                $deleteGate    = 'blog_category_delete';
                $crudRoutePart = 'blog-categories';

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
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });
            $table->addColumn('blog_category_name', function ($row) {
                return $row->blog_category ? $row->blog_category->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'active', 'blog_category']);

            return $table->make(true);
        }

        $blog_categories = BlogCategory::get();

        return view('admin.blogCategories.index', compact('blog_categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('blog_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blog_categories = BlogCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.blogCategories.create', compact('blog_categories'));
    }

    public function store(StoreBlogCategoryRequest $request)
    {
        $blogCategory = BlogCategory::create($request->all());

        return redirect()->route('admin.blog-categories.index');
    }

    public function edit(BlogCategory $blogCategory)
    {
        abort_if(Gate::denies('blog_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blog_categories = BlogCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blogCategory->load('blog_category');

        return view('admin.blogCategories.edit', compact('blogCategory', 'blog_categories'));
    }

    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $blogCategory->update($request->all());

        return redirect()->route('admin.blog-categories.index');
    }

    public function show(BlogCategory $blogCategory)
    {
        abort_if(Gate::denies('blog_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blogCategory->load('blog_category');

        return view('admin.blogCategories.show', compact('blogCategory'));
    }

    public function destroy(BlogCategory $blogCategory)
    {
        abort_if(Gate::denies('blog_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blogCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyBlogCategoryRequest $request)
    {
        $blogCategories = BlogCategory::find(request('ids'));

        foreach ($blogCategories as $blogCategory) {
            $blogCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
